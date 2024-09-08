<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPendencie extends Model
{
    use HasFactory;

    protected $table = 'user_pendencies';

    protected $fillable = [
        'title',
        'senderAccount',
        'recipientAccount',
        'value',
        'date',
        'manager'
    ];

    public $timestamps = false;
}
