<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->string('alias');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('state_code')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->unsignedInteger('country_id')->index();

            if (Schema::hasTable(config('velkart.user_table', 'users'))) {
                $table->foreign('customer_id')->references(config(
                    'velkart.user_id_column',
                    'id'
                ))->on(config('velkart.user_table', 'users'));
            }

            $table->integer('status')->default(0);

            $table->foreign('country_id')->references('id')->on('countries');
            $table->softDeletes();
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
        Schema::dropIfExists('addresses');
    }
}
