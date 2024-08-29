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

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function admins(){
        return $this->hasMany(Admin::class, 'admin');
    }

    public function managers(){
        return $this->hasMany(Manager::class, 'admin');
    }
}
