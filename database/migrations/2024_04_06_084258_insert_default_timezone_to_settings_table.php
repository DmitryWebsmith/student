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
        \App\Models\Setting::query()
            ->insert(
                [
                    'name' => 'default_timezone',
                    'value' => 'Asia/Novosibirsk',
                ]
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Setting::query()
            ->where('name', 'default_timezone')
            ->delete();
    }
};
