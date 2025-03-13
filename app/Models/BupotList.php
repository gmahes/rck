<?php

namespace App\Models;

use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Model;

class BupotList extends Model
{
    protected $table = 'bupot_list';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'supplier_id',
        'date',
        'docId',
        'dpp',
        'pph',
        'whdate'
    ];
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', 'id');
    }
}
