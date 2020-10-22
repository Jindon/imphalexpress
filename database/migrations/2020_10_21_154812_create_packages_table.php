<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses');
            $table->foreignId('location_id')->constrained('locations');
            $table->string('tracking_id')->unique();
            $table->string('delivery_address');
            $table->string('delivery_contact')->nullable();
            $table->string('delivery_note')->nullable();
            $table->string('collected_on');
            $table->string('deliver_by');
            $table->string('status')->comment('processing, received, dispatched, delivered');
            $table->string('delivered_on')->nullable();
            $table->string('out_for_delivery_on')->nullable();
            $table->string('reached_location_on')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
