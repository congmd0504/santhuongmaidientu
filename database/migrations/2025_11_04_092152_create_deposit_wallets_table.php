<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('deposit_wallets', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('user_id');
        $table->bigInteger('product_id')->nullable();
        $table->string('type', 255)->nullable();
        $table->decimal('total_amount', 15, 2);
        $table->decimal('remaining_amount', 15, 2)->default(0);
        $table->decimal('monthly_release', 15, 2)->default(0);
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->enum('status', ['active', 'completed', 'paused'])->default('active');
        $table->timestamps();
    });

    Schema::create('deposit_wallet_logs', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('wallet_id');
        $table->bigInteger('user_id');
        $table->string('type',255)->nullable();
        $table->decimal('amount', 15, 2);
        $table->timestamp('released_at')->nullable();
        $table->enum('status', ['success', 'pending', 'failed'])->default('pending');
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
        Schema::dropIfExists('deposit_wallets');
    }
}
