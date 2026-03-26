<?php

use App\Models\Ref\TugasTambahan;
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
        Schema::table('gtk', function (Blueprint $table) {
            $table->foreignIdFor(TugasTambahan::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gtk', function (Blueprint $table) {
            $table->dropForeignIdFor(TugasTambahan::class);
        });
    }
};
