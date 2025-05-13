<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('national_code')->nullable()->after('email');
            $table->enum('role', ['employee', 'hr', 'finance', 'super_admin'])->default('employee')->after('password');
            $table->string('iban')->nullable()->after('role');
            $table->string('bank_name')->nullable()->after('iban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['national_code', 'role', 'iban', 'bank_name']);
        });
    }
};
