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
        Schema::create('onfido_credentials', function (Blueprint $table) {
            $table->id();
            $table->json('applicant')->nullable();
            $table->json('workflow')->nullable();
            $table->text('sdk_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onfido_credentials');
    }
};
