<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "users";
    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'address',
        'phone',
        'role',
    ];
    public function bill() {
        return $this->hasMany('App\Models\BillModel', 'user_id', 'id');
    }
}
