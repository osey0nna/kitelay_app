<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perlombaans', function (Blueprint $table) {
            $table->timestamp('results_released_at')->nullable()->after('results_published_at');
        });

        DB::table('perlombaans')
            ->whereNotNull('results_published_at')
            ->update([
                'results_released_at' => DB::raw('results_published_at'),
            ]);
    }

    public function down(): void
    {
        Schema::table('perlombaans', function (Blueprint $table) {
            $table->dropColumn('results_released_at');
        });
    }
};
