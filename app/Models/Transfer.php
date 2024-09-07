<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'senderAccount',
        'recipientAccount',
        'value',
        'date'
    ];

    public $timestamps = false;

}
