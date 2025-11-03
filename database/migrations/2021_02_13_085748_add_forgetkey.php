<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForgetkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tao lien ket
/*
         Schema::table("products",function($table){
             $table->foreign('category_id')->references('id')->on('category_products')->onDelete('cascade');
             $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
         });
         Schema::table("product_images",function($table){
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
         });
         Schema::table("product_tags",function($table){
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
             $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
         });
         Schema::table("category_products",function($table){
             $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
         });
         Schema::table("role_admins",function($table){
             $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
         });
         Schema::table("role_admins",function($table){
             $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
         });
         Schema::table("permission_roles",function($table){
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
         });
         Schema::table("category_posts",function($table){
             $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
         });
         Schema::table("post_tags",function($table){
             $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
             $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
         });
         Schema::table("orders",function($table){
             $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
         });
         Schema::table("orders",function($table){
             $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
         });
*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
         Schema::table("products",function($table){
             $table->dropForeign(['category_id']);
             $table->dropForeign(['admin_id']);
         });
         Schema::table("product_images",function($table){
             $table->dropForeign(['product_id']);
         });
         Schema::table("product_tags",function($table){
             $table->dropForeign(['product_id']);
             $table->dropForeign(['tag_id']);
         });
         Schema::table("category_products",function($table){
             $table->dropForeign(['admin_id']);
         });
         Schema::table("role_admins",function($table){
             $table->dropForeign(['admin_id']);
             $table->dropForeign(['role_id']);
         });
         Schema::table("role_admins",function($table){
             $table->dropForeign(['admin_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::table("permission_roles",function($table){
             $table->dropForeign(['permission_id']);
             $table->dropForeign(['role_id']);
         });
         Schema::table("category_posts",function($table){
             $table->foreign(['admin_id']);
         });
         Schema::table("post_tags",function($table){
             $table->dropForeign(['post_id']);
             $table->dropForeign(['tag_id']);
         });
         Schema::table("orders",function($table){
             $table->dropForeign(['transaction_id']);
             $table->dropForeign(['product_id']);
         });
         Schema::table("orders",function($table){
             $table->dropForeign(['transaction_id']);
             $table->dropForeign(['product_id']);
         });
          */
    }
}
