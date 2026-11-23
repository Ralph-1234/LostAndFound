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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category'); // Electronics, ID/Cards, Books, Bags, Keys, Clothing, Other
            $table->text('description');
            $table->string('location'); // e.g., Main Library, Engineering Bldg
            $table->date('date_reported');
            $table->enum('type', ['lost', 'found']);
            $table->enum('status', ['open', 'claimed', 'resolved'])->default('open');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
