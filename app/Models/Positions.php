<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];
    public $timestamps = true;
    public $incrementing = true;

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class, 'position_id', 'id');
    }
}
