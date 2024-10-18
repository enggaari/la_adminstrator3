<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessSubmenu extends Model
{
    use HasFactory;

    protected $fillable = ['roleId', 'menuId', 'submenuId'];
}
