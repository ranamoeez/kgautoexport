<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_transfer', function (Blueprint $table) {
            $table->id();
            $table->integer("vehicle_id");
            $table->integer("user_id");
            $table->string("amount");
            $table->string("exchange_company");
            $table->string("transfer_no");
            $table->text("comment");
            $table->string("status")->default("waiting");
            $table->string("latest")->default("1");
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
        Schema::dropIfExists('money_transfer');
    }
}
