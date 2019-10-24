<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('demand_id');
            $table->integer('demand_item_id');
            $table->integer('quantity')->default(1);
            $table->bigInteger('price');
            $table->string('desc')->nullable();
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
        Schema::dropIfExists('demand_lists');
    }
}
