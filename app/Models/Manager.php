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

    public $timestamps = false;

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'manager');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account');
    }

    use HasFactory;
}
