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
        Schema::create('like_comment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('blogger_id');
            $table->unsignedBigInteger('comment_id');

            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->cascadeOnDelete();

            $table->foreign('blogger_id')
                ->references('id')
                ->on('bloggers')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_comment');
    }
};
