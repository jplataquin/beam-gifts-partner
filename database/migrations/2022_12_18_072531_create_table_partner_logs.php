<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_logs', function (Blueprint $table) {
            $table->id();
            $table->char('status',4);
            $table->bigInteger('order_item_id');
            $table->decimal('amount',10,2);
            $table->json('entry');
            $table->bigInteger('partner_id');
            $table->bigInteger('modified_by');
            $table->dateTime('released_at')->nullable();
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
        Schema::dropIfExists('partner_logs');
    }
};
