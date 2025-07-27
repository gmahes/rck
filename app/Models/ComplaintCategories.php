<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintCategories extends Model
{
    protected $table = 'complaint_categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'type',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function complaints()
    {
        return $this->hasOne(Complaint::class, 'category_id', 'id');
    }
}
