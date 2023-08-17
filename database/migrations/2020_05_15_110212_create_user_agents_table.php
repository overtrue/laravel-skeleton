<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('user_agents', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->comment('用户ID');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('agent');
            $table->timestamp('last_used_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_agents');
    }
};
