<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'code',
        'facility',
        'document',
        'percentage',
        'created_by',
        'updated_by'
    ];
    public $timestamps = true;
    public $incrementing = false;
    public $keyType = 'string';
}
