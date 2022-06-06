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
        Schema::create('emp', function (Blueprint $table) {
            $table->string('id',20);
            $table->string('password',100);
            $table->string('email',100);
            $table->integer('empno');
            $table->string('ename',20);
            $table->string('job',20);
            $table->integer('mgr');
            $table->string('hiredate');
            $table->integer('sal');
            $table->integer('comm');
            $table->integer('deptno');
            $table->string('img1');
            $table->string('img2');
            $table->string('role',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emp');
    }
};
