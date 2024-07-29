<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Pagopar extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagopar';

    protected $fillable = [
        "order_id",
        "payed",
        "payment_method",
        "payment_date",
        "amount",
        "maximum_payment_date",
        "order_hash",
        "order_number",
        "cancelled",
        "payment_method_identifier",
        "token",
        "payment_result_message"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeConfirmed(Builder $query) {
        return $query->where('payed', 1);
    }

    public function getMensajeAttribute()
    {
        return json_decode($this->mensaje_resultado_pago);
    }

}
