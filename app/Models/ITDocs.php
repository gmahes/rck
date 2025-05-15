<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserDetail;

class ITDocs extends Model
{
    protected $table = 'it-docs'; // Nama tabel
    protected $primaryKey = 'troubleID'; // Primary key
    public $incrementing = false; // Non-incrementing karena menggunakan string sebagai primary key
    protected $keyType = 'string'; // Tipe data primary key
    protected $fillable = [
        'nik',
        'devices',
        'trouble',
        'action',
        'status',
        'photo',
        'created_by',
        'updated_by'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $dateCode = date('ymd');
                $prefix = 'IT-RCK/' . $dateCode . '/';

                $lastKode = self::where('troubleID', 'like', $prefix . '%')
                    ->orderBy('troubleID', 'desc')
                    ->value('troubleID');

                if ($lastKode) {
                    $lastNumber = (int) substr($lastKode, -3);
                    $urut = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $urut = '001';
                }
            } while (self::where('troubleID', $prefix . $urut)->exists());
            $model->troubleID = $prefix . $urut;
        });
    }
    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'nik', 'nik');
    }
}
