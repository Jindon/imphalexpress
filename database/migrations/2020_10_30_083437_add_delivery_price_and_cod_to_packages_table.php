<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryPriceAndCodToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->bigInteger('delivery_price')->nullable()->default(5000)->after('delivery_note');
            $table->bigInteger('cod_amount')->nullable()->after('delivery_note');
            $table->boolean('cod')->default(false)->after('delivery_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('delivery_price');
            $table->dropColumn('cod_amount');
            $table->dropColumn('cod');
        });
    }
}
