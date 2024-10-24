<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus'; // Nama tabel jika tidak mengikuti konvensi
    protected $fillable = [
        'menu',
        'info',
        'alias',
    ];

    // Relasi: Menu memiliki banyak SubMenu
    public function subMenus()
    {
        return $this->hasMany(SubMenu::class, 'idMenu', 'id');
    }

    public function superSubMenus()
    {
        return $this->hasManyThrough(SuperSubMenu::class, SubMenu::class, 'idMenu', 'idSubMenu', 'id', 'id');
    }

    // Relasi ke user_access_menus
    public function userAccessMenus()
    {
        return $this->hasMany(UserAccessMenu::class, 'menuId', 'id');
    }
}
