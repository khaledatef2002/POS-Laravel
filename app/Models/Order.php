<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client()
    {
        // To Edit: user_id -> client_id
        return $this->belongsTo(Client::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
