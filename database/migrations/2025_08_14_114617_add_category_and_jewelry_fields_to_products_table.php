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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('material')->nullable(); // Gold, Silver, Platinum, etc.
            $table->string('brand')->nullable();
            $table->string('size')->nullable(); // Ring size, watch size, etc.
            $table->string('color')->nullable();
            $table->string('weight')->nullable(); // For jewelry weight
            $table->string('gender')->nullable(); // Men, Women, Unisex
            $table->json('features')->nullable(); // Additional features as JSON
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('sku')->nullable()->unique(); // Stock Keeping Unit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'category_id',
                'description',
                'material',
                'brand',
                'size',
                'color',
                'weight',
                'gender',
                'features',
                'is_featured',
                'is_active',
                'sku'
            ]);
        });
    }
};
