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
        Schema::create('talent_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('username')->unique()->index();
            $table->string('name')->nullable();
            $table->string('job_position')->nullable();
            $table->text('summary_experience')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('talent_profiles_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_profile_id')->constrained()->onDelete('cascade')->index();
            $table->string('client_name');
            $table->string('video_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_profiles');
    }
};
