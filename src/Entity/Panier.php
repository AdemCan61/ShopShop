<?php

declare(strict_types = 1);

namespace MyApp\Entity;

class Panier {
    private ?int $idPanier = null;
    private string $name;
    private float $prix;

    public function __construct(?int $idPanier, string $name, float $prix){
        $this->idPanier = $idPanier;
        $this->name = $name;
        $this->prix = $prix;
    }    
    public function getIdPanier():?int{
        return $this->idPanier;   
    }
    public function getName():string{
        return $this->name;
    }
    public function getPrix():float{
        return $this->prix;
    }
    public function setIdPanier(?int $idPanier):voidPanier{
        $this-> idPanier = $idPanier;
    }
    public function setName(string $NamePanier):voidPanier{
        $this-> name = $name;
    }
    public function setPrix(float $prix):voidPanier{
        $this-> prix = $prix;
    }
}
