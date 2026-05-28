<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN type ENUM('1','2','3') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN type ENUM('robot','agv','vip') NOT NULL");
    }
};