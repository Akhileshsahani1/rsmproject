<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferredClassification extends Model
{
    use HasFactory;

    protected $fillable = [
        'classification',
        'status'
    ];

    public function subclassifications(){

        return $this->hasMany(PreferredSubClassification::class, 'classification_id');
    }
}
