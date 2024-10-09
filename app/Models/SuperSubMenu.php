<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperSubMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'idMenu',
        'idSubMenu',
        'super_sub_menus',
        'url',
        'status',
        'info',
        'alias',
    ];

    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'idSubMenu', 'id');
    }

    function superSubMenu()
    {
        $results = SuperSubMenu::join('sub_menus', 'super_sub_menus.idSubMenu', '=', 'sub_menus.id')
            ->join('menus', 'super_sub_menus.idMenu', '=', 'menus.id')
            ->select('super_sub_menus.*', 'sub_menus.subMenu as sub_menu_name', 'menus.menu as menu_name')
            ->get();

        return $results;
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idMenu', 'id'); // or hasMany(Menu::class) if that's the case
    }
}
