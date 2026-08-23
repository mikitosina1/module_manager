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
        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->string('module_id')->unique();
            $table->json('settings');
            $table->timestamps();
        });

        DB::table('module_settings')->insert([
            'module_id' => 'module-manager',
            'settings' => json_encode([
                'permissions' => [
                    config('roles.admin') => [
                        'access' => true,
                        'view' => true,
                        'create' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                    config('roles.user') => [
                        'access' => true,
                        'view' => true,
                        'create' => false,
                        'update' => false,
                        'delete' => false,
                    ],
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_settings');
    }
};
