<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('itemName');
            $table->integer('itemStock');
            $table->string('unit');
            $table->string('serialNo')->nullable();
            $table->string('golongan');
            $table->string('codeMasterItem');
            $table->string('itemAge');
            $table->string('cabang');
            $table->string('itemState')->default('Available');
            $table->string('description')->nullable();
            $table->string('lastGiven')->nullable();
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
        Schema::dropIfExists('items');
    }
}
