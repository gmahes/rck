<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;

class UserAuth extends Authenticable
{
    use HasFactory;
    protected $table = 'user_auth';
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'username',
        'password',
        'remember_token',
        'frp',
        'role',
        'created_by',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // protected $with = ['userDetail'];
    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'username', 'username');
    }
}
