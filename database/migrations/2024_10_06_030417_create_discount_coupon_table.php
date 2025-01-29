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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            //code
            $table->string('code');
            //human readable code name
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            //maximum uses
            $table->integer('max_uses')->nullable();
            //maximum uses by a customer
            $table->integer('max_uses_user')->nullable();
            //percent or any amount discount
            $table->enum('type',['percent','fixed'])->default('fixed');
            //amount of discount based on type
            $table->double('discount_amount',10,2)->nullable();
            //Minimum Amount
            $table->double('min_amount',10,2)->nullable();
            //active or unactive
            $table->integer('status')->default(1);
            //coupon begins time
            $table->timestamp('starts_at')->nullable();
            //coupon expire
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupon');
    }
};
