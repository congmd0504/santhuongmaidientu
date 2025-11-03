<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdđColumnContentSeoToCategoryPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_posts', function (Blueprint $table) {
            //
            $table->string("description",255)->nullable();
            $table->longText("content")->nullable();

            $table->string("description_seo",255)->nullable();
            $table->string("title_seo",255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_posts', function (Blueprint $table) {
            //
            $table->dropColumn("description");
            $table->dropColumn("content");

            $table->dropColumn("description_seo");
            $table->dropColumn("title_seo");
        });
    }
}
