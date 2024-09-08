<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Manager extends Authenticatable
{
    protected $table = 'managers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'account',
        'admin',
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

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'manager');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address');
    }

    public function pendencies()
    {
        return $this->hasMany(UserPendencie::class, 'manager');
    }

    use HasFactory;
}
