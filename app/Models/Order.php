<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'token',
        'public_token',
        'monto_total',
        'tipo_pedido',
        'comprador_id',
        'descripcion_resumen',
        'fecha_maxima_pago',
        'estado'
    ];

    protected $hidden = [
        'token',
        'public_token'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function division()
    {
        return $this->belongsTo(ShipDivision::class)->withDefault();
    }

    public function district()
    {
        return $this->belongsTo(ShipDistrict::class)->withDefault();
    }

    public function state()
    {
        return $this->belongsTo(ShipState::class)->withDefault();
    }
}
