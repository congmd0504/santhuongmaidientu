<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->float("total",10,2);
            $table->string("name",255);
            $table->string("phone",255)->nullable();
            $table->string("note",255)->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger("status")->default(1);
            $table->bigInteger("admin_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("city_id")->unsigned()->nullable();
            $table->bigInteger("district_id")->unsigned()->nullable();
            $table->bigInteger("commune_id")->unsigned()->nullable();
            $table->string("address_detail",255)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
