<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'agency',
        'number',
        'balance',
        'transferLimit',
        'password',
    ];

    public function user() {
        return $this->belongsTo(CommonUser::class);
    }

    public $timestamps = false;
}
