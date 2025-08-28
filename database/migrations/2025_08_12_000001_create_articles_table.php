<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('kb')->nullable();
            $table->string('title');
            $table->fullText('title');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('author');
            $table->string('author_name');
            $table->unsignedBigInteger('sectionId');
            $table->json('tags')->nullable();
            $table->json('attachments')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedInteger('attachCount')->default(0);
            $table->string('scope')->default('1');
            $table->json('images')->nullable();
            $table->float('rating')->default(0);
            $table->boolean('approved')->default(false);
            $table->boolean('published')->default(true);
            $table->boolean('notify_sent')->default(false);
            $table->date('expires')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
