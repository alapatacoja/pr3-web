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
    Schema::table('products', function (Blueprint $table) {
        $table->string('flexsim_shape')->nullable(); // ej: /Tools/FlowItemBin/Bocata/Bocata
        $table->string('flexsim_spot')->nullable();  // ej: /Rack1
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['flexsim_shape', 'flexsim_spot']);
    });
}
};
