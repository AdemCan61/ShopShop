<?php

declare(strict_types = 1);

namespace MyApp\Entity;
use MyApp\Entity\Type;

class Product {
    private ?int $idProduct = null;
    private string $name;
    private string $description;
    private float $prix;
    private string $ProductType;

    public function __construct(?int $idProduct, string $name, string $description, float $prix, string $stock, string $ProductType) {
        $this->idProduct = $idProduct;
        $this->name = $name;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->ProductType = $ProductType;
    }    
    public function getidProduct():?int{
        return $this->idProduct;   
    }
    public function getName():string{
        return $this->name;
    }
    public function getDescription():string{
        return $this->description;
    }
    public function getPrix():float{
        return $this->prix;
    }
    public function getStock():string{
        return $this->stock;
    }
    public function getProductType():string{
        return $this->ProductType;
    }
    public function setidProduct(?int $idProduct):voidProduct{
        $this-> idProduct = $idProduct;
    }
    public function setName(string $name):voidProduct{
        $this-> name = $name;
    }
    public function setDescription(string $description):voidProduct{
        $this-> description = $description;
    }
    public function setPrix(string $prix):voidProduct{
        $this-> prix = $prix;
    }
    public function setStock(string $stock):voidProduct{
        $this-> stock = $stock;
    }
    public function setProductType(string $ProductType):voidProduct{
        $this-> ProductType= $ProductType;
    }
}
