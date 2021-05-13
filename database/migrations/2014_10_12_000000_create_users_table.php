<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('real_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gender')->default('unknown')->comment('性别：unknown/female/male');
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->default('inactivated')->comment('状态：inactivated/active/frozen');
            $table->json('cache')->nullable()->comment('数据缓存');
            $table->json('extends')->nullable()->comment('扩展信息');
            $table->json('settings')->nullable()->comment('用户设置');
            $table->boolean('is_visible')->default(true)->comment('是否可见');
            $table->boolean('is_admin')->default(false)->comment('是否为公司管理员');
            $table->timestamp('first_active_at')->nullable()->comment('首次活跃时间');
            $table->timestamp('last_active_at')->nullable()->comment('最后活跃时间');
            $table->timestamp('frozen_at')->nullable();
            $table->timestamp('status_remark')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();
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
}
