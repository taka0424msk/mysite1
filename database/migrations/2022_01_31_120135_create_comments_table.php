<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');//post_idとすることでlaravelがpost tableと紐づいているのだなと判断してくれる
            $table->string('body');
            $table->timestamps();
            $table // 主テーブルであるpostでidが消されたらこのテーブルの紐づいているコメントも消すためには外部キーを設定する必要がある。この形で覚えてしまおう
                ->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
