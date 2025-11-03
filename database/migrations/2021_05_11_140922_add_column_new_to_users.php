<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNewToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->date("date_birth")->nullable();
            // hộ khẩu thường trú
            $table->string("hktt",255)->nullable();
            // chứng minh thư
            $table->string("cmt",255)->nullable();
            // số tài khoản
            $table->string("stk",255)->nullable();
            // chủ tài khoản
            $table->string("ctk",255)->nullable();
            // ngân hàng
            $table->bigInteger('bank_id')->unsigned()->nullable();
            // tên chi nhanh ngân hàng
            $table->string("bank_branch",255)->nullable();
            // giới tính
            $table->tinyInteger("sex")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn("date_birth");
            $table->dropColumn("hktt");
            $table->dropColumn("cmt");
            $table->dropColumn("stk");
            $table->dropColumn("ctk");
            $table->dropColumn("bank_id");
            $table->dropColumn("bank_branch");
            $table->dropColumn("sex");
        });
    }
}
