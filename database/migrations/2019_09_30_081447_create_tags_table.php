<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->comment('用户ID');
            $table->unsignedInteger('creator_id')->comment('创建者');
            $table->string('name');
            $table->string('color', 10)->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->id('aid');
            $table->unsignedInteger('tag_id')->index();
            $table->morphs('taggable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
};
