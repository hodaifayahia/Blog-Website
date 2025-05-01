<?php

use App\Models\User;
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
            $table->string('title',2048);
            $table->string('slug',2048);
            $table->longText('body');
            $table->string('thumbnail')->nullable();
            // $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Foreign key for author
            $table->boolean('active')->default(true); // Default active to true
            $table->dateTime('published_at')->nullable(); // Nullable published_at
            $table->foreignIdFor(User::class, 'user_id'); // Foreign key for user_id (e.g., if it's a creator of the post)
            $table->timestamps(); // This will create created_at and updated_at
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
