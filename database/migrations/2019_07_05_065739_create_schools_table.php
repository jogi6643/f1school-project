<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_name');
            $table->string('type');
            $table->string('zone');
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->string('website')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('email')->nullable();
            $table->float('annual_fees')->nullable();
            $table->string('principal_name')->nullable();
            $table->bigInteger('principal_mobile')->nullable();
            $table->string('principal_email')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('schools');
    }
}
