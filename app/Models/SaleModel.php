<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleModel extends Model
{
    protected $table = 'venta';

    use SoftDeletes;

    protected $fillable = ['email', 'total', 'sale_date'];

    protected $hidden = [
        'createdd_at',
        'updated_at',
        'deleted_at'
    ];

    public function concepts()
    {
        return $this->hasMany(ConceptModel::class);
    }
}
