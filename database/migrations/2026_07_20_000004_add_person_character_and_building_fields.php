<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('vine_id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->boolean('is_player_character')->default(false)->after('name');
            $table->foreignId('primary_building_id')
                ->nullable()
                ->after('is_player_character')
                ->constrained('buildings')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['primary_building_id']);
            $table->dropColumn([
                'first_name',
                'last_name',
                'is_player_character',
                'primary_building_id',
            ]);
        });
    }
};
