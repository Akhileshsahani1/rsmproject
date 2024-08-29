<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "admin_notifications";

    protected $fillable = [
        'type',
        'sender',
        'sender_id',
        'receiver',
        'receiver_id',
        'model_id',
        'model',
        'message',
        'seen'
    ];
}
