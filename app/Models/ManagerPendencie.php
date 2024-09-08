<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerPendencie extends Model
{
    use HasFactory;

    protected $table = 'manager_pendencies';

    protected $fillable = [
        'title',
        'senderAccount',
        'recipientAccount',
        'value',
        'date',
        'admin'
    ];

    public $timestamps = false;
}
