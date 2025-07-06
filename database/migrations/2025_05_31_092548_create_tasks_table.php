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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->date('deadline')->nullable();
        $table->string('priority_color')->nullable();
        $table->unsignedBigInteger('column_id');
        $table->integer('order')->default(0);
        $table->timestamps();

        $table->foreign('column_id')->references('id')->on('columns')->onDelete('cascade');
    });
}

};
