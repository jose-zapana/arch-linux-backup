<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->text('extract')->nullable();
            $table->longText('body')->nullable();

            $table->string('file')->nullable();


            $table->enum('status', [1, 2])->default(1);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('blogcategory_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('blogcategory_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

