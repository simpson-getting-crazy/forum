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
        Schema::create('threads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreignId('parent_id')
                ->nullable()
                ->references('id')
                ->on('threads')
                ->onDelete('cascade');

            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->enum('visibility', ['all', 'friends']);
            $table->boolean('is_remove_by_admin');

            $table->unsignedInteger('upvote')->default(0);
            $table->unsignedInteger('downvote')->default(0);

            $table->unsignedInteger('replies')->default(0);
            $table->unsignedInteger('views')->default(0);

            $table->timestamps();
            $table->timestamp('last_activity');
        });

        Schema::create('bookmarked_threads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreignId('thread_id')
                ->references('id')
                ->on('threads')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('voted_threads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreignId('thread_id')
                ->references('id')
                ->on('threads')
                ->onDelete('cascade');

            $table->enum('type', ['up', 'down']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
        Schema::dropIfExists('bookmarked_threads');
        Schema::dropIfExists('voted_threads');
    }
};
