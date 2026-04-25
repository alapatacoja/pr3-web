<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM(
        'bocata',
        'bocata_especial',
        'bocata_dia',
        'bolleria',
        'cafe',
        'bebida',
        'menu_completo',
        'menu_medio',
        'menu_vegetariano',
        'menu_saludable'
    ) NOT NULL");
}

public function down()
{
    DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM(
        'bocata','bolleria','cafe','bebida','menu'
    ) NOT NULL");
}
};
