<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers_list';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'address', 'created_by', 'updated_by'];
    public $timestamps = true;
    public $incrementing = false;
    public $keyType = 'string';
}
