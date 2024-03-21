<?php

declare(strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\Commentaire;
use PDO;

class CommentaireModel{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }
    public function getAllCommentaires():array{
        $sql = "SELECT * FROM Commentaire";
        $stmt = $this-> db-> query($sql);
        $commentaires = [];
        while($row = $stmt->fetch()){
            $commentaires[] = new Commentaire($row['idCommentaire'], $row['NameProduct'], $row['Commentaire'], $row['Etoile']);
        }
        return $commentaires;
    }
    public function createCommentaire(Commentaire $commentaire): bool {
        $sql = "INSERT INTO Commentaire (NameProduct, Commentaire, Etoile)  VALUES (:NameProduct, :Commentaire, :Etoile)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':NameProduct', $commentaire->getNameProduct(), PDO::PARAM_STR);
        $stmt->bindValue(':Commentaire', $commentaire->getCommentaire(), PDO::PARAM_STR);
        $stmt->bindValue(':Etoile', $commentaire->getEtoile(), PDO::PARAM_STR);
        return $stmt->execute();
    }
}