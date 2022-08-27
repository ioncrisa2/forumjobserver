<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap',32)->index();
            $table->string('username',32)->index();
            $table->integer('nim')->index();
            $table->string('email',64)->unique()->index();
            $table->string('password')->index();
            $table->text('alamat')->nullable();
            $table->bigInteger('telepon')->nullable()->index();
            $table->date('tanggal_lahir')->nullable()->index();
            $table->enum('status',['ALUMNI','ADMIN'])->default('alumni')->index();
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
        Schema::dropIfExists('users');
    }
}
