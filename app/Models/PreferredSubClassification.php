<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferredSubClassification extends Model
{
    use HasFactory;

    protected $fillable = [
        'classification_id',
        'sub_classification',
        'status'
    ];

    public function classification(){

        return $this->belongsTo(PreferredClassification::class, 'classification_id');
    }
}
