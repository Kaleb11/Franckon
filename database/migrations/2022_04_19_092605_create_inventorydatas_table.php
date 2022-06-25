<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventorydatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorydatas', function (Blueprint $table) {
            $table->id();
            $table->string('itemType');
            $table->string('measurenment');
            $table->integer('quantity');
            $table->boolean('withPurchase');
            $table->boolean('fromStore');
            $table->string('purchasedCompany')->nullable();
            $table->boolean('bought');
            $table->text('resetImage')->nullable();
            $table->boolean('delivered');
            $table->boolean('undelivered');
            $table->string('orderReason')->nullable();
            $table->string('undeliveredReason')->nullable();
            $table->boolean('urgent');
            $table->string('status');
            $table->string('adminOneApproval')->nullable();
            $table->string('adminTwoApproval')->nullable();
            $table->string('approved')->nullable();
            $table->integer('category_id');
            $table->string('requestUserName');
            $table->integer('requestUserId');
            $table->timestamp('deliveredTime')->nullable();
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
        Schema::dropIfExists('inventorydatas');
    }
}
