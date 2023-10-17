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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('remark');
            $table->unsignedBigInteger('task_id');
            $table->boolean('read')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
    
            // Define the foreign key constraint
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }
};