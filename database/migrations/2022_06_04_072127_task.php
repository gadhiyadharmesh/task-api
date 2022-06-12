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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description');
            $table->datetime('start_date')->nullable()->default(null);
            $table->datetime('end_date')->nullable()->default(null);
            $table->enum('status', ['New', 'Incomplete', 'Complete'])->default('New');
            $table->enum('priority', ['None', 'High', 'Medium', 'Low'])->default('None');
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
        Schema::dropIfExists('task');
    }
};
