<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diskusi', function (Blueprint $table) {
            $table->unsignedBigInteger('tugas_id')->after('id');

            // Menambahkan foreign key jika perlu
            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diskusi', function (Blueprint $table) {
            $table->dropColumn('tugas_id');
        });
    }
};
