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
        Schema::table('test_passed', function (Blueprint $table) {
            $table->dropForeign('test_passed_test_id_foreign');
            $table->dropColumn('test_id');

            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_passed', function (Blueprint $table) {
            //
        });
    }
};
