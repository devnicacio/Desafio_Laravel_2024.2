<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phoneNumber',
        'birthdate',
        'cpf',
        'photo',
        'admin'
    ];

    public $timestamps = false;

    protected $casts = [
        'birthdate' => 'date'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin');
    }

    public function admins(){
        return $this->hasMany(Admin::class, 'admin');
    }

    public function managers(){
        return $this->hasMany(Manager::class, 'admin');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address');
    }

    public function pendencies()
    {
        return $this->hasMany(ManagerPendencie::class, 'admin');
    }
}
