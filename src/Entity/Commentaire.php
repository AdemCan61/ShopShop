<?php

declare(strict_types = 1);

namespace MyApp\Entity;

class Commentaire {
    private ?int $idCommentaire = null;
    private string $NameProduct;
    private string $Commentaire;
    private string $Etoile;

    public function __construct(?int $idCommentaire, string $NameProduct, string $Commentaire, string $Etoile) {
        $this->idCommentaire = $idCommentaire;
        $this->NameProduct = $NameProduct;
        $this->Commentaire = $Commentaire;
        $this->Etoile = $Etoile;
    }    
    public function getidCommentaire():?int{
        return $this->idCommentaire;   
    }
    public function getNameProduct():string{
        return $this->NameProduct;
    }
    public function getCommentaire():string{
        return $this->Commentaire;
    }
    public function getEtoile():string{
        return $this->Etoile;
    }
    public function setidCommentaire(?int $idCommentaire):voidCommentaire{
        $this-> idCommentaire = $idCommentaire;
    }
    public function setNameCommentaire(string $NameCommentaire):voidCommentaire{
        $this-> NameCommentaire = $NameCommentaire;
    }
    public function setCommentaire(string $Commentaire):voidCommentaire{
        $this-> Commentaire = $Commentaire;
    }
    public function setEtoile(string $Etoile):voidCommentaire{
        $this-> Etoile = $Etoile;
    }
}
