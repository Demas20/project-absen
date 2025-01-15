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
            Schema::create('group_subtasks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained()->onDelete('cascade'); // foreign key ke tabel groups
                $table->foreignId('tugas_detail_id')->constrained('tugas_details')->onDelete('cascade'); // foreign key ke tabel tugas_details
                $table->boolean('is_completed')->default(false); // status selesai atau belum
                $table->string('file')->nullable(); // menyimpan nama file yang diupload
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_subtasks');
    }
};
