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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->text('description');
            $table->date('project_start_data');
            $table->date('project_delivery_data');
            $table->integer('project_cost');
            $table->string('project_technology');
            $table->string('project_members');
            $table->enum('project_status',['in process','completed','notworking','working'])->default('in process');
            $table->enum('is_active',['yes','no'])->default('no');
            $table->unsignedBigInteger('project_head');
            $table->foreign('project_head')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('projects');
    }
};
