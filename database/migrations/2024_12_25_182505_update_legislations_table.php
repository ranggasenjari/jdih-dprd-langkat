<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('legislations', function (Blueprint $table) {
            $table->dropForeign(['institute_id']); // Hapus foreign key lama
            $table->foreign('institute_id')
                  ->references('id')->on('institutes')
                  ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('legislations', function (Blueprint $table) {
            $table->dropForeign(['institute_id']); // Hapus foreign key baru
            $table->foreign('institute_id')
                  ->references('id')->on('institutes');
        });
    }
    
};
