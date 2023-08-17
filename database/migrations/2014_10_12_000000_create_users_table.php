<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->comment('用户ID');
            $table->string('username')->unique();
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gender')->default('unknown')->comment('性别：unknown/female/male');
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('password')->nullable();
            $table->json('settings')->nullable()->comment('用户设置');
            $table->boolean('is_admin')->default(false)->comment('是否为公司管理员');
            $table->string('system_remark')->nullable();
            $table->string('banned_reason')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamp('first_active_at')->nullable()->comment('首次活跃时间');
            $table->timestamp('last_active_at')->nullable()->comment('最后活跃时间');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
