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
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('機能');
            $table->integer('num')->nullable()->comment('何回？');
            $table->string('interval')->nullable()->comment('1回目/1回目');
            $table->string('interval1')->nullable()->comment('1回目/2回目');
            $table->string('interval2')->nullable()->comment('1回目/2回目');
            $table->string('intervalday')->nullable()->comment('日数で設定');
            $table->string('intervalhour')->nullable()->comment('時間で設定');
            $table->string('conditions')->nullable()->comment('削除日数');
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
        Schema::dropIfExists('schedulers');
    }
};
