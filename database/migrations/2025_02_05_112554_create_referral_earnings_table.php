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
        Schema::create('referral_earnings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); 
                $table->unsignedBigInteger('referred_user_id');
                $table->unsignedBigInteger('investment_id');
                $table->decimal('commission_amount', 10, 2);
                $table->integer('level');
                $table->timestamps();
        
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('referred_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');
    }
};
