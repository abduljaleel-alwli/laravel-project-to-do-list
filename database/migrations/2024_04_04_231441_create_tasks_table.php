<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('name'); // Changed from 'task' for clarity
            $table->text('comment')->nullable();
            $table->string('status')->default('New');
            $table->unsignedBigInteger('user_id')->default(0)->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('due_date'); // Changed from 'date' for a specific due date
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
        Schema::dropIfExists('tasks');
    }
}
