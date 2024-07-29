<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

Class Seller {

    private $publicKey;
    private $privateKey;
    private $apiUrl;

    private $seller;

    public function __construct()
    {
        $this->publicKey = Config::get('pagopar.public_key');
        $this->privateKey = Config::get('pagopar.private_key');
        $this->apiUrl = Config::get('pagopar.url');

        $this->seller->phone = Config::get('pagopar.seller_phone');
        $this->seller->coord = Config::get('pagopar.seller_coord');
        $this->seller->dir  = Config::get('pagopar.seller_dir');
        $this->seller->ref  = Config::get('pagopar.seller_ref');
    }

    public static function getSeller() {
        return self::$seller;
    }

}
