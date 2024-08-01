<?php

namespace App\Helpers;

use Barryvdh\DomPDF\PDF;

class PDFs extends PDF {


    public static function loadViews($view, $data = array(), $mergeData = array(), $encoding = null) {
        return PDF::loadView('frontend.order.invoice-download', compact('order','orderItems'))
            ->setPaper('a4')
            ->setOptions([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
    }
}
