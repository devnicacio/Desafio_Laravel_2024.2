<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonUser extends Model
{
    use HasFactory;

    protected $table = 'commonUsers';

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

    public $timestamps = false;

    public function account() {
        return $this->hasOne(Account::class);
    }
}
