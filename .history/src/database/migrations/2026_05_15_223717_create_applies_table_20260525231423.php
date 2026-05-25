<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('attendance_record_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('content');
            $table->string('status');
            $table->unique(['user_id', 'date']);
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
        Schema::dropIfExists('applies');
    }
}
