<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Buyer;
use illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Helpers\Geo;
use Exception;

Class OrderHelper {

    use Geo;

    private $publicKey;
    private $privateKey;
    private $apiUrl;

    private $orderType;
    private $description;
    private $buyer;
    private $detail;

    public function __construct(Buyer $buyer, $detail, string $orderType = "Venta-Comercio", string $description)
    {
        $this->publicKey = Config::get('pagopar.public_key');
        $this->privateKey = Config::get('pagopar.private_key');
        $this->apiUrl = Config::get('pagopar.url');

        $this->orderType = $orderType;
        $this->description = $description;

        if(is_array($detail)){
            $this->detail = collect($detail);
        }

        $this->buyer = $buyer;
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
            $pedido = Order::where('numero_pedido', $orderNumber)->first();
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

    public function setOrderType(string $orderType):void{
        $this->orderType = $orderType;
    }

    public function getOrderType():string{
        return $this->orderType;
    }

    public function setDescription(string $description):void{
        $this->description = $description;
    }

    public function getDescription():string{
        return $this->description;
    }

    public function setDetail($detail):void{
        if(is_array($detail)){
            $detail = collect($detail);
        }
        $this->detail = $detail;
    }

    public function getDetail(){
        return $this->detail;
    }

    public function setBuyer(Buyer $buyer):void{
        $this->buyer = $buyer;
    }

    public function getBuyer():Buyer{
        return $this->buyer;
    }
}
