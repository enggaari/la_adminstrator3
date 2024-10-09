<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menus'; // Nama tabel jika tidak mengikuti konvensi
    // protected $fillable = ['subMenu', 'idMenu', 'url', 'icon', 'status', 'info', 'alias'];
    protected $fillable = [
        'idMenu',
        'subMenu',
        'url',
        'icon',
        'status',
        'info',
        'alias',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idMenu', 'id');
    }

    public function superSubMenus()
    {
        return $this->hasMany(SuperSubMenu::class, 'idSubMenu', 'id');
    }

    // public function menu()
    // {
    //     return $this->belongsTo(Menu::class, 'idMenu');
    // }

    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'idSubMenu');
    }
}
