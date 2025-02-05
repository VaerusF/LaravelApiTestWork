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
        Schema::create('files', function (Blueprint $table) {
            $table->id('file_id');
            $table->string('file_type');
            $table->string('file_name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('firstname',39);
            $table->string('lastname', 39);
            $table->string('phone');
            $table->unsignedBigInteger('avatar_id')->nullable();
            $table
                ->foreign('avatar_id')
                ->references('file_id')
                ->on('files')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('files');
    }
};
