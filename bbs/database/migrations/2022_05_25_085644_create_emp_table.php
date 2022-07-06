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
            $table->string('id',20)->unique();
            $table->string('password',100);
            $table->string('remember_token',100);
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at');
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
            $table->integer('role',20);
            $table->integer('post_code');
            $table->string('address1',100);
            $table->string('address2',100);
            $table->integer('phone_number');
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
