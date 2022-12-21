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
        Schema::create('indications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->string('ma_trend');
            $table->string('ma_crossover');
            $table->string('psar_trend');
            $table->string('psar_reversal');
            $table->string('stochastic_trend');
            $table->string('stochastic_crossover');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indications');
    }
};
