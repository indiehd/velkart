<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_status_id')->index();
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            //$table->unsignedBigInteger('address_id')->index()->nullable();
            //$table->unsignedInteger('order_status_id')->index();

            if (Schema::hasTable(config('velkart.user_table', 'users'))) {
                $table->foreign('customer_id')->references(config(
                    'velkart.user_id_column',
                    'id'
                ))->on(config('velkart.user_table', 'users'));
            }

            //$table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
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
        Schema::dropIfExists('orders');
    }
}
