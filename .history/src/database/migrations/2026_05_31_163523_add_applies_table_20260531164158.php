<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->time('work_total')->nullable();
            $table->time('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->dropColumn('work_total');
            $table->dropColumn('duration');  
        });
    }
}
