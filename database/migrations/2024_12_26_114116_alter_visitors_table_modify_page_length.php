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
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('page', 2048)->change(); // Atur panjang maksimal URL hingga 2048 karakter
        });
    }
    
    public function down()
    {
        
    }
    
};
