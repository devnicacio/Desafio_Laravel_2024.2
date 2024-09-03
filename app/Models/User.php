<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'account',
        'manager',
        'address',
        'photo',
        'phoneNumber',
        'birthdate',
        'cpf'
    ];

    protected $casts = [
        'birthdate' => 'date'
    ];

    public $timestamps = false;

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function address()
    {
        return $this->belongsTo(Account::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
