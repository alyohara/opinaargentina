<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up(): void
{
    // Verificamos si la columna 'two_factor_secret' no existe antes de agregarla
    if (!Schema::hasColumn('users', 'two_factor_secret')) {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();
        });
    }

    // Verificamos si la columna 'two_factor_recovery_codes' no existe antes de agregarla
    if (!Schema::hasColumn('users', 'two_factor_recovery_codes')) {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();
        });
    }

    // Si se confirma la autenticación de dos factores, agregamos 'two_factor_confirmed_at'
    if (Fortify::confirmsTwoFactorAuthentication() && !Schema::hasColumn('users', 'two_factor_confirmed_at')) {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('two_factor_confirmed_at')
                ->after('two_factor_recovery_codes')
                ->nullable();
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                'two_factor_confirmed_at',
            ] : []));
        });
    }
};
