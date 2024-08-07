<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagopar Public Key
    |--------------------------------------------------------------------------
    |
    | PAGOPAR PUBLIC KEY
    |
    */

    'public_key' => env('PAGOPAR_PUBLIC_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Pagopar Private Key
    |--------------------------------------------------------------------------
    |
    | PAGOPAR PRIVATE KEY
    |
    */

    'private_key' => env('PAGOPAR_PRIVATE_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar URL
    |--------------------------------------------------------------------------
    |
    | PAGOPAR URL
    |
    */

    'url'               => env('PAGOPAR_URL', 'https://api.pagopar.com'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Parameter
    |--------------------------------------------------------------------------
    |
    | PAGOPAR PARAM
    |
    */

    'param'             => env('PAGOPAR_PARAM', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Buy
    |--------------------------------------------------------------------------
    |
    | PAGOPAR BUY
    |
    */

    'buy'               => env('PAGOPAR_BUY', 'comercios/2.0/iniciar-transaccion'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Payment Method
    |--------------------------------------------------------------------------
    |
    | PAGOPAR BUY
    |
    */

    'payment_method'    => env('PAGOPAR_PAYMENT_METHOD', 'forma-pago/1.1/traer'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar ORDER Method
    |--------------------------------------------------------------------------
    |
    | PAGOPAR ORDER
    |
    */

    'orders'            => env('PAGOPAR_ORDER_METHOD', 'pedidos/1.1/traer'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Return Url
    |--------------------------------------------------------------------------
    |
    | PAGOPAR RETURN URL
    |
    */

    'return_url'        => env('PAGOPAR_RETURN_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Constant
    |--------------------------------------------------------------------------
    |
    | PAGOPAR CONSTANT
    |
    */

    'order_type'    => 'VENTA-COMERCIO',

    'payment_method' => 9,

    'order_detail_category' => 909,

    'payment_confirmed' => true,

    'unconfirmed_payment' => false,

    'maximum_payment_date' => 2,

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Buyer Information
    |--------------------------------------------------------------------------
    |
    | PAGOPAR BUYER INFO
    |
    */

    'buyer_city'    => 1,
    'buyer_dir'     => null,
    'buyer_coord'   => null,
    'buyer_biz'     => null,
    'buyer_ref'     => null,

    /*
    |--------------------------------------------------------------------------
    | Default Pagopar Seller Information
    |--------------------------------------------------------------------------
    |
    | PAGOPAR SELLER INFO
    |
    */

    'seller_phone'  => env('PAGOPAR_SELLER_PHONE', null),

    'seller_coord'  => env('PAGOPAR_SELLER_COORD', null),

    'seller_dir'    => env('PAGOPAR_SELLER_DIR', null),

    'seller_ref'    => env('PAGOPAR_SELLER_REF', null),

    'seller_ruc'    => env('PAGOPAR_SELLER_RUC', null),

];
