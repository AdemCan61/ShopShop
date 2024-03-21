<?php

declare(strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\Panier;
use PDO;

class PanierModel{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }
    public function getAllPaniers():array{
        $sql = "SELECT * FROM Panier";
        $stmt = $this-> db-> query($sql);
        $paniers = [];
        while($row = $stmt->fetch()){
            $paniers[] = new Panier($row['idPanier'], $row['name'], $row['prix']);
        }
        return $paniers;
    }
    public function createPanier(Panier $panier): bool {
        $sql = "INSERT INTO Panier (name, prix) VALUES (:name, :prix)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $panier->getNamePanier(), PDO::PARAM_STR);
        $stmt->bindValue(':prix', $panier->getPrixPanier(), PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function deletePanier(int $idPanier): bool {
        $sql = "DELETE FROM Panier WHERE idPanier = :idPanier";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);
        return $stmt->execute();
    }    
}