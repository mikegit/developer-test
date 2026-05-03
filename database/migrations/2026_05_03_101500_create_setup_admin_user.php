<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('setup.admin_email')],
            [
                'name' => config('setup.admin_name'),
                'email_verified_at' => now(),
                'password' => Hash::make(config('setup.password')),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::query()
            ->where('email', config('setup.admin_email'))
            ->delete();
    }
};
