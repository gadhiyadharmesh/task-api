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
        Schema::create('notes_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notes_id')->unsigned();
            $table->string('title');
            $table->string('path');
            $table->timestamps();
            $table->foreign('notes_id')->references('id')->on('task_notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes_attachments');
    }
};
