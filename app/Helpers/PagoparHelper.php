<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Helpers\OrderHelper;
use App\Helpers\BuyerHelper;
use App\Helpers\SellerHelper;
use Illuminate\Http\Client\Response;
use App\Services\OrderService;
use Exception;

class PagoparHelper
{
    const URL_SEPARATOR = '/';

    private static $publicKeyValue;
    private static $privateKeyValue;
    private static $sellerObject;
    private static $buyerObject;

    protected $client;
    private $publicKey;
    private $privateKey;
    protected $apiUrl;
    protected $apiParam;
    protected $apiBuyParam;
    protected $apiBuyUrl;
    protected $apiReturnUrl;

    private $hash;
    private $buyer;
    private $seller;
    private $user;
    private $order;
    private $json;
    private $orderType;
    private $paymentMethod;
    private $paymentConfirm;
    private $maximumPaymentDate;

    private $orderService;

    public $rollback;
    public $result;
    public $message;

    public function __construct()
    {
        self::$publicKeyValue = config('pagopar.public_key');
        self::$privateKeyValue = config('pagopar.private_key');
        self::$sellerObject = SellerHelper::getSeller();
        //self::$buyerObject = Buyer::getBuyer([]);

        $this->publicKey = config('pagopar.public_key');
        $this->privateKey = config('pagopar.private_key');
        $this->apiUrl = config('pagopar.url');
        $this->apiParam = config('pagopar.param');
        $this->apiBuyParam = config('pagopar.buy');
        $this->apiReturnUrl = config('pagopar.return_url');
        $this->orderType = config('pagopar.order_type');
        $this->paymentMethod = config('pagopar.payment_method');
        $this->paymentConfirm = config('pagopar.unconfirmed_payment');
        $this->maximumPaymentDate = config('pagopar.maximum_payment_date');

        $this->apiBuyUrl = $this->apiUrl . self::URL_SEPARATOR . $this->apiParam . self::URL_SEPARATOR . $this->apiBuyParam;

        // $this->buyer    = Buyer::getBuyer();
        $this->seller   = SellerHelper::getSeller();

        $this->rollback = false;
        $this->result   = false;
        $this->message  = null;

        $this->orderService = resolve(OrderService::class);
    }

    public function create(Order $order) {

    }

    public function createPayment($id, $amount, $description, $returnUrl)
    {
        $this->hash = OrderHelper::getOrderHash($id, strval(floatval($amount)), $this->privateKey);
        $this->buyer = BuyerHelper::getBuyerArray($this->user->ruc, $this->user->email, 1, $this->user->name, $this->user->phone, $this->user->dir, $this->user->ci, $this->user->coords, "CI", $this->user->ref);
        $this->order = OrderHelper::getOrderArray($this->user->city, $this->user->name, $this->order->qty, $this->order->category, $this->order->image, $this->order->desc, $this->order->id, $this->order->amount, $this->seller->phone, $this->seller->dir, $this->seller->coord, $this->seller->ref);
        $this->json = $this->getJSonCreateFormat($this->hash, 1, 1, [], $this->publicKey); // TO DO

        $response = Http::post($this->apiUrl, [
            $this->json
        ]);

        if($response->ok()){
            $this->result = $response->object()->respuesta;
            $this->message = $response->object()->resultado;

            if($this->result == true){
                return true;
            }
        }

        return false;
    }

    public function getPaymentMethodAsResponse() : Response {

        $token = self::getPaymentMethodHash($this->privateKey);

        $array = [
            "token"         => $token,
            "token_publico" => $this->publicKey
        ];

        $response = Http::post($this->apiUrl, [
            json_encode($array)
        ]);

        return $response;
    }

    public function verifyPayment($transactionId)
    {
        $response = $this->client->get($this->apiUrl . '/v2/charge/' . $transactionId, [
            'query' => [
                'public_key' => $this->publicKey,
                'private_key' => $this->privateKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public static function getPaymentCreateHash($idOrder, $totalAmount, $private_key = null) {
        return sha1($private_key . $idOrder . strval(floatval($totalAmount)));
    }

    public static function getPaymentMethodHash($private_key = null) {
        return sha1($private_key . "FORMA-PAGO");
    }

    public static function getPaymentResultHash($private_key = null) {
        return sha1($private_key . "CONSULTA");
    }

    public static function getPrivateKey() {
        return self::$privateKeyValue;
    }

    public static function getPublicKey() {
        return self::$publicKeyValue;
    }

    public static function getJSonCreateFormat(string $token, int $idOrder, int $totalAmount, array $data, $publicKey = null) {
        $obj = json_decode (json_encode ($data), false);
        $items = $obj->items;
        $maximum_payment_date = Carbon::now()->addDays(self::$maximumPaymentDate);

        $buyer = self::getJSonBuyerFormat(self::$buyer);
        $items = self::getJSonOrderItemFormat($items, self::$seller);

        // Datos a enviar a la API de Pagopar
        return [
            'token' => $token,
            'comprador' => $buyer,
            'public_key' => $publicKey,
            'monto_total' => $totalAmount,
            'tipo_pedido' => self::$orderType,
            'compras_items' => $items,
            'fecha_maxima_pago' => $maximum_payment_date,
            'id_pedido_comercio' => $idOrder,
            'descripcion_resumen' => 'Ticket virtual a evento Ejemplo 2017', //Desc
            'forma_pago' => self::$paymentMethod
        ];
    }

    private static function getJSonBuyerFormat($buyer) {

        return [
            'ruc' => $buyer->ruc,
            'email' => $buyer->email,
            'ciudad' => $buyer->city,
            'nombre' => $buyer->name,
            'telefono' => $buyer->phone,
            'direccion' => $buyer->dir,
            'documento' => $buyer->ci,
            'coordenadas' => $buyer->coord,
            'razon_social' => $buyer->name,
            'tipo_documento' => $buyer->doc,
            'direccion_referencia' => $buyer->ref
        ];
    }

    private static function getJSonOrderItemFormat(iterable $items, $seller) {

        foreach($items as $n => $item) {
            $array[$n] = [
                'ciudad' => $seller->city,
                'nombre' => $item->name,
                'cantidad' => $item->qty,
                'categoria' => self::$paymentMethod,
                'public_key' => self::$publicKey,
                'url_imagen' => $item->image,
                'descripcion' => $item->description,
                'id_producto' => $item->id,
                'precio_total' => $item->price,
                'vendedor_telefono' => $seller->phone,
                'vendedor_direccion' => $seller->dir,
                'vendedor_direccion_referencia' => $seller->ref,
                'vendedor_direccion_coordenadas' => $seller->coord
            ];
        }

        return $array;
    }

    public static function setBuyer(array $array) {
        try {
            self::$buyer        = BuyerHelper::getStaticBuyer($array);
            self::$buyerObject  = BuyerHelper::getStaticBuyer($array);
        } catch(Exception $e) {
            return false;
        }

        return true;
    }

    public static function getBuyer() {
        return self::$buyerObject;
    }

    public static function getSeller() {
        return self::$sellerObject;
    }

    public static function getPaymentConfirm() {
        return self::$paymentConfirm;
    }

    public static function getPaymentMethod() {
        return self::$paymentMethod;
    }

    public static function getPaymentDate() {
        return Carbon::now();
    }

    public static function getMaximumPaymentDate() {
        return Carbon::now()->addDays(3);
    }

    public static function getCancelled() {
        return false;
    }

}
