<?php

declare (strict_types = 1);

namespace MyApp\Controller;
use MyApp\Service\DependencyContainer;
use Twig\Environment;
use MyApp\Model\TypeModel;
use MyApp\Model\ProductModel;
use MyApp\Entity\Products;
use MyApp\Model\UserModel;
use MyApp\Entity\Type;
use MyApp\Entity\User;
use MyApp\Model\CommentaireModel;
use MyApp\Entity\Commentaire;
use MyApp\Model\PanierModel;
use MyApp\Entity\Panier;

class DefaultController
{
    private $twig;
    private $typeModel;
    private $productModel;
    private $userModel;
    private $commentaireModel;
    private $panierModel;
  
    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
        $this->typeModel = $dependencyContainer->get('TypeModel');
        $this->productModel = $dependencyContainer->get('ProductModel');
        $this->userModel = $dependencyContainer->get('UserModel');
        $this->commentaireModel = $dependencyContainer->get('CommentaireModel');
        $this->panierModel = $dependencyContainer->get('PanierModel');
    }

    public function home()
    {
        echo $this->twig->render('defaultController/home.html.twig', []);
    }

    public function error404()
    {
        echo $this->twig->render('defaultController/error404.html.twig', []);
    }

    public function error500()
    {
        echo $this->twig->render('defaultController/error500.html.twig', []);
    }
    public function contact()
    {
        echo $this->twig->render('defaultController/contact.html.twig', []);
    }
    public function updateType(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $label = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
            if (!empty($_POST['label'])) {
                $type = new Type(intVal($id), $label);
                $success = $this->typeModel->updateType($type);
                if ($success) {
                header('Location: index.php?page=types');
                }
            }
        }
        else{
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $type = $this->typeModel->getOneType(intVal($id));
        echo $this->twig->render('defaultController/updateType.html.twig', ['type'=>$type]);
    }
    public function types()
    {
        $types = $this->typeModel->getAllTypes();
        echo $this->twig->render('defaultController/types.html.twig', ['types' =>$types]);
    }
    public function product()
    {
        $products = $this->productModel->getAllProducts();
        echo $this->twig->render('defaultController/product.html.twig', ['products' =>$products]);
    }
    public function user()
    {
        $users = $this->userModel->getAllUsers();
        echo $this->twig->render('defaultController/user.html.twig', ['users' =>$users]);
    }
    public function updateUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if (!empty($_POST['email'])) {
                $user = new User(intVal($id), $email, $lastname, $firstname, $password);
                $success = $this->userModel->updateUser($user);
                $password = password_hash($password, PASSWORD_DEFAULT);
                if ($success) {
                header('Location: index.php?page=user');
                }
            }
        }
        else{
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $user = $this->userModel->getOneUser(intVal($id));
        echo $this->twig->render('defaultController/updateUser.html.twig', ['user' =>$user]);
    }
    public function addType(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $label = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
            if (!empty($_POST['label'])) {
                $type = new Type(null, $label);
                $success = $this->typeModel->createType($type);
                if ($success) {
                    header('Location: index.php?page=types');
                }
            }
        }
        echo $this->twig->render('defaultController/addType.html.twig', []);
    }
    public function deleteType(){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->typeModel->deleteType(intVal($id));
        header('Location: index.php?page=types');
    } 
    public function addUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if (!empty($_POST['email'])) {
                $user = new User(null, $email, $lastname, $firstname, $password, []);
                $success = $this->userModel->createUser($user);
                if ($success) {
                    header('Location: index.php?page=user');
                }
            }
        }
        echo $this->twig->render('defaultController/addUser.html.twig', []);
    }
    public function deleteUser(){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->userModel->deleteUser(intVal($id));
        header('Location: index.php?page=user');
    } 
    public function productType()
    {
        echo $this->twig->render('defaultController/productType.html.twig', []);
    }
    public function security(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password']; 
        $passwordLength = strlen($password);
        if ($passwordLength < 2) {
           $_SESSION['message'] = 'Erreur : mot de passe non conforme';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = new User(null,$firstname, $lastname,$email,$hashedPassword,['user']);
            $result = $this->userModel->createUser($user);
            if ($result) {
            $_SESSION['message'] = 'Votre inscription est terminée';
            header('Location: index.php?page=security');
            exit;
            }
            else{
            $_SESSION['message'] = 'Erreur lors de l\'inscription';
            }
        }
        header('Location: index.php?page=addAvis');
        exit;
    }
     echo $this->twig->render('defaultController/security.html.twig', []);
    }
    public function accueil()
    {
        $types = $this->typeModel->getAllTypes();
        echo $this->twig->render('defaultController/accueil.html.twig', ['types' =>$types]);
    }  
    public function ProductListebyType()
    {
        $products = $this->productModel->getAllProducts();
        echo $this->twig->render('defaultController/ProductListebyType.html.twig', ['products' =>$products]);
    }
    public function avis()
    {
        $commentaires = $this->commentaireModel->getAllCommentaires();
        echo $this->twig->render('defaultController/avis.html.twig', ['commentaires' =>$commentaires]);
    }
    public function addAvis()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $NameProduct = filter_input(INPUT_POST, 'NameProduct', FILTER_SANITIZE_STRING);
            $Commentaire = filter_input(INPUT_POST, 'Commentaire', FILTER_SANITIZE_STRING);
            $Etoile = filter_input(INPUT_POST, 'Etoile', FILTER_SANITIZE_STRING);
            if (!empty($_POST['NameProduct'])) {
                $commentaire = new Commentaire(null, $NameProduct, $Commentaire, $Etoile);
                $success = $this->commentaireModel->createCommentaire($commentaire);
                if ($success) {
                    header('Location: index.php?page=avis');
                }
            }
        }
        $products = $this->productModel->getAllProducts();
        echo $this->twig->render('defaultController/addAvis.html.twig', ['products' =>$products]);
    }
    public function login()
    {    
        echo $this->twig->render('defaultController/login.html.twig', []);
    }
    public function panier()
    {    
        $paniers = $this->panierModel->getAllPaniers();
        echo $this->twig->render('defaultController/panier.html.twig', ['paniers' => $paniers]);
    }
    public function addPanier()
    {    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            // Convertir le prix en nombre à virgule flottante
            $prix = (float) $_POST['prix'];
            if (!empty($name)) {
                $panier = new Panier(null, $name, $prix, []);
                $success = $this->panierModel->createPanier($panier);
                if ($success) {
                    header('Location: index.php?page=panier');
                    exit(); // Ajouter cette ligne pour arrêter l'exécution après la redirection
                }
            }
        }
        $products = $this->productModel->getAllProducts();
        echo $this->twig->render('defaultController/addPanier.html.twig', ['products' => $products]);
    }    
    public function deletePanier()
    {    
        $idPanier = filter_input(INPUT_GET, 'idPanier', FILTER_SANITIZE_NUMBER_INT);
        $this->panierModel->deletePanier(intVal($Panier));
        header('Location: index.php?page=panier');
    }
}
