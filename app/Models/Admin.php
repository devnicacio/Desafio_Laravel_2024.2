<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
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

    public function admins(){
        return $this->hasMany(Admin::class);
    }

    public function managers(){
        return $this->hasMany(Manager::class);
    }
}
