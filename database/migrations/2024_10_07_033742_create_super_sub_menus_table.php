<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('super_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->string('idMenu');
            $table->string('idSubMenu');
            $table->string('super_sub_menus');
            $table->string('url');
            $table->boolean('status');
            $table->text('info')->nullable();
            $table->text('alias')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_sub_menus');
    }
};
