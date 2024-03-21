<?php

declare(strict_types = 1);

namespace MyApp\Entity;
use MyApp\Entity\Product;

class Type {
    private ?int $id = null;
    private string $label;

    public function __construct(?int $id, string $label){
        $this-> id = $id;
        $this-> label = $label;
    }

    public function getId():?int{
        return $this->id;
    }
    public function getLabel():string{
        return $this->label;
    }

    public function setId(?int $id):void{
        $this-> id = $id;
    }
    public function setLabel(string $label):void{
        $this-> label = $label;
    }
}
class Product {
    private Type $type;
    private ?Product $product;

    public function __construct(Type $type, ?Product $product = null) {
        $this->type = $type;
        $this->product = $product;
    }
}