<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drivers;

class Omzet extends Model
{
    use HasFactory;
    protected $table = 'omzet';
    protected $fillable = ['user_id', 'date', 'omzet', 'created_by', 'updated_by'];
    protected $primaryKey = 'id';
    // public $timestamps = false;
    public function drivers()
    {
        return $this->belongsTo(Drivers::class, 'user_id', 'id');
    }
}
