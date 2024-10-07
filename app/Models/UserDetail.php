<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'user_detail';
    protected $primaryKey = 'nik';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'nik',
        'username',
        'fullname',
        'position',
    ];
    public function userAuth()
    {
        return $this->belongsTo(UserAuth::class, 'username', 'username');
    }
}
