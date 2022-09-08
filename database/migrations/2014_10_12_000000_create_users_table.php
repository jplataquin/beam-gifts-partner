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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->char('status',4);

            $table->string('name');

            $table->string('primary_contact_person');
            $table->string('primary_contact_no');
            $table->string('primary_contact_person_position');

            $table->string('secondary_contact_person')->nullable();
            $table->string('secondary_contact_no')->nullable();
            $table->string('secondary_contact_person_position')->nullable();
            
            $table->bigInteger('brand_id');
            $table->text('branch');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->bigInteger('created_by');
            $table->bigInteger('modified_by')->nullable();
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
        Schema::dropIfExists('users');
    }
};
