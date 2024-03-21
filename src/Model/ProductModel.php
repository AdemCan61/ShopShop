<?php

declare(strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\Product;
use PDO;

class ProductModel{
    private PDO $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }
    public function getAllProducts():array{
        $sql = "SELECT * FROM Product";
        $stmt = $this-> db-> query($sql);
        $products = [];
        while($row = $stmt->fetch()){
            $products[] = new Product($row['idProduct'], $row['name'], $row['description'], $row['prix'],
            $row['stock'], $row['ProductType']);
        }
        return $products;
    }
}
