<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('reference')->unique()->index();
            //$table->unsignedInteger('courier_id')->index();
            //$table->foreign('courier_id')->references('id')->on('couriers');
            $table->unsignedBigInteger('customer_id')->index()->nullable();

            if (Schema::hasTable(config('user_table'))) {
                $table->foreign('customer_id')->references(config('user_id_column',
                    'id'))->on(config('user_table', 'users'));
            }

            $table->unsignedBigInteger('address_id')->index()->nullable();
            //$table->foreign('address_id')->references('id')->on('addresses');
            //$table->unsignedInteger('order_status_id')->index();
            //$table->foreign('order_status_id')->references('id')->on('order_statuses');
            #$table->string('payment');
            #$table->decimal('discounts')->default(0.00);
            #$table->decimal('total_products');
            #$table->decimal('tax')->default(0.00);
            #$table->decimal('total');
            #$table->decimal('total_paid')->default(0.00);
            #$table->string('invoice')->nullable();
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
