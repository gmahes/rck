<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    use HasFactory;
    protected $table = 'drivers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fullname',
        'vehicle_type',
        'vehicle_number',
        'created_by',
    ];
    public function omzet()
    {
        return $this->hasMany(Omzet::class, 'user_id', 'id');
    }
}
