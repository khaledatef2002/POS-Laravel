<?php

namespace App\Models;

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    protected $appends = ['profit_percent'];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getProfitPercentAttribute()
    {
        $profit = $this->sell_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->sell_price;

        return number_format($profit_percent, 2) . '%';
    }
}
