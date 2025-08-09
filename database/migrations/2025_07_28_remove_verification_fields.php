<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remove verification-related columns from users table
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('users', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
        });

        // Drop user_verifications table
        Schema::dropIfExists('user_verifications');
    }

    public function down(): void
    {
        // Recreate user_verifications table
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('id_document_path');
            $table->string('verification_status')->default('pending');
            $table->date('date_of_birth');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        // Add back verification columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->boolean('is_verified')->default(false)->after('date_of_birth');
            $table->timestamp('last_notification_check')->nullable()->after('country');
        });
    }
};