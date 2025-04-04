<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptModel extends Model
{
    protected $table = 'concepts';
    protected $fillable = ['quantity', 'price', 'product_id', 'sale_id'];

    public function sale()
    {
        return $this->belongsTo(SaleModel::class);
    }
}
