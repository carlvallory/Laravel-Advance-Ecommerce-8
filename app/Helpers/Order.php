<?php

namespace App\Helpers;

use App\Models\Order as OrderModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Helpers\Geo;
use Exception;

Class Order {

    use Geo;

    private $publicKey;
    private $privateKey;
    private $apiUrl;

    public function __construct()
    {
        $this->publicKey = Config::get('pagopar.public_key');
        $this->privateKey = Config::get('pagopar.private_key');
        $this->apiUrl = Config::get('pagopar.url');
    }

    public static function getOrderHash($id = null, $amount = 0, $private_key = null) {
        return sha1($private_key . $id . $amount);
    }

    public static function getOrderArray($city = 1, $name, $quantity, $category, $image, $description, $id, $amount, $phone, $dir, $coords, $ref = null) {
        $compras = [
            "ciudad"=> $city,
            "nombre"=> $name,
            "cantidad"=> $quantity,
            "categoria"=> $category,
            "public_key"=> self::$publicKey,
            "url_imagen"=> $image,
            "descripcion"=> $description,
            "id_producto"=> $id,
            "precio_total"=> $amount,
            "vendedor_telefono"=> $phone,
            "vendedor_direccion"=> $dir,
            "vendedor_direccion_referencia"=> $ref,
            "vendedor_direccion_coordenadas"=> $coords
        ];
    }

    public static function setOrderStatus($orderNumber) {
        try {
            $pedido = OrderModel::where('numero_pedido', $orderNumber)->first();
            $pedido->estado = 'pagado';
            $pedido->save();

            return true;
        }
            catch(Exception $e)
        {
            Log::alert($e);
            return false;
        }
    }

    public function getDistance($latA, $longA, $latB, $longB) {
        return self::calculateDistance($latA, $longA, $latB, $longB);
    }
}
