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
        Schema::create('rekening_nasabahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('works_id');
            $table->foreignId('user_id');
            $table->string('nama_lengkap')->unique();
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->bigInteger('nominal_setor');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('rekening_nasabahs');
    }
};
