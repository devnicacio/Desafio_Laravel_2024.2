<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
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

    public function commonUsers()
    {
        return $this->hasMany(CommonUser::class, 'manager');
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    use HasFactory;
}
