<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->nullable()->after('email');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->default('stripe')->after('postal_code');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->default('standard')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('shipping_method');
            }
            if (!Schema::hasColumn('orders', 'design_token')) {
                $table->string('design_token')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'printing_side')) {
                $table->string('printing_side')->default('單面')->after('material');
            }
            if (!Schema::hasColumn('orders', 'binding')) {
                $table->string('binding')->default('無')->after('printing_side');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'address', 'city', 'postal_code',
                'payment_method', 'shipping_method',
                'notes', 'design_token',
                'printing_side', 'binding'
            ]);
        });
    }
};