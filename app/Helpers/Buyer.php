<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use App\Models\Buyer as BuyerModel;

Class Buyer {

    private $publicKey;
    private $privateKey;
    private $apiUrl;

    private $buyer;

    public function __construct()
    {
        $this->publicKey = Config::get('pagopar.public_key');
        $this->privateKey = Config::get('pagopar.private_key');
        $this->apiUrl = Config::get('pagopar.url');

        $this->buyer->ruc = null;
        $this->buyer->email = null;
        $this->buyer->city = 1;
        $this->buyer->name = null;
        $this->buyer->phone = null;
        $this->buyer->dir = null;
        $this->buyer->ci = null;
        $this->buyer->coord = null;
        $this->buyer->doc = "CI";
        $this->buyer->ref = null;
    }

    public function setBuyer($ruc = null, $email, $city = 1, $name, $phone, $dir, $ci, $coord, $doc="CI", $ref = null) {

        $this->buyer->ruc = $ruc;
        $this->buyer->email = $email;
        $this->buyer->city = $city;
        $this->buyer->name = $name;
        $this->buyer->phone = $phone;
        $this->buyer->dir = $dir;
        $this->buyer->ci = $ci;
        $this->buyer->coord = $coord;
        $this->buyer->doc = $doc;
        $this->buyer->ref = $ref;

    }

    public function getBuyer() {
        return $this->buyer;
    }

    public static function getBuyerArray($ruc = null, $email, $city = 1, $name, $phone, $dir, $ci, $coord, $doc="CI", $ref = null) {
        $comprador = [
            "ruc" => $ruc,
            "email"=> $email,
            "ciudad"=> $city,
            "nombre"=> $name,
            "telefono"=> $phone,
            "direccion"=> $dir,
            "documento"=> $ci,
            "coordenadas"=> $coord,
            "razon_social"=> $name,
            "tipo_documento"=> $doc,
            "direccion_referencia"=> $ref
        ];
    }

    public static function getStaticBuyer(array $array) {
        if(isset($array) && !empty($array)) {
            if(isset($array) && array_key_exists('id', $array)) {
                return BuyerModel::find($array['id']);
            }

            if(isset($array) && array_key_exists('phone', $array) && array_key_exists('email', $array) && array_key_exists('documento', $array)) {
                $buyer = self::getBuyerArray($array['ruc'], $array['email'], 1, $array['name'], $array['phone'], $array['dir'], $array['ci'], $array['coord'], 'CI', $array['ref']);
            }
        }

        return self::$buyer;
    }
}
