<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class OrderDetailHelper {

    private $name;
    private $description;
    private $price;
    private $quantity;
    private $product;

    public function __construct(string $name,string $description,float $price, Model $product,float $quantity = 1){
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->product = $product;
    }

    public function setName(string $name):void{
        $this->name = $name;
    }

    public function getName():string{
        return $this->name;
    }

    public function setDescription(string $description):void{
        $this->description = $description;
    }

    public function getDescription():string{
        return $this->description;
    }

    public function setPrice(float $price){
        $this->price = $price;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setQuantity(float $quantity){
        $this->quantity = $quantity;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function setProduct(Model $product){
        $this->product = $product;
    }

    public function getProduct(){
        return $this->product;
    }
}
