<?php

declare(strict_types = 1);

namespace MyApp\Model;

use MyApp\Entity\Type;
use PDO;

class TypeModel{
    private PDO $db;
    public function __construct(PDO $db){
        $this->db = $db;
    }
    public function getAllTypes():array{
        $sql = "SELECT * FROM Type";
        $stmt = $this-> db-> query($sql);
        $types = [];
        
        while($row = $stmt->fetch()){
            $types[] = new Type($row['idType'], $row['label']);  
        }
        return $types;
    }
    public function getOneType(int $idType):?Type{
        $sql = "SELECT * from Type where idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idType", $idType);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
        return null;
        }
    return new Type($row['idType'], $row['label']);
    }
    public function updateType(Type $type):bool {
        $sql = "UPDATE Type SET label = :label WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':label', $type->getLabel(), PDO::PARAM_STR);
        $stmt->bindValue(':idType', $type->getidType(), PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function createType(Type $type): bool {
        $sql = "INSERT INTO Type (label) VALUES (:label)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':label', $type->getLabel(), PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function deleteType(int $idType): bool {
        $sql = "DELETE FROM Type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $idType, PDO::PARAM_INT);
        return $stmt->execute();
    }    
    public function getTypeByidType(int $idType): ?Type
    {
        $sql = "SELECT * FROM Type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $idType);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Type($row['idType'], $row['label']);
    } 
}