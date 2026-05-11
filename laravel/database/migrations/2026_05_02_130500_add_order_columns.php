<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone');
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email');
            }
            if (!Schema::hasColumn('orders', 'product')) {
                $table->string('product');
            }
            if (!Schema::hasColumn('orders', 'size')) {
                $table->string('size');
            }
            if (!Schema::hasColumn('orders', 'material')) {
                $table->string('material');
            }
            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity');
            }
            if (!Schema::hasColumn('orders', 'price')) {
                $table->decimal('price', 10, 2);
            }
            if (!Schema::hasColumn('orders', 'file')) {
                $table->string('file')->nullable();
            }
            if (!Schema::hasColumn('orders', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 移除添加的列（如果需要回滚）
        });
    }
};