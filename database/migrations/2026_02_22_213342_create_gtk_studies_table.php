<?php

use App\Models\Gtk;
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
        Schema::create('gtk_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gtk::class)->constrained()->cascadeOnDelete();
            $table->string('level');
            $table->string('institution');
            $table->string('major')->nullable();
            $table->year('graduation_year');
            $table->string('certificate_number')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtk_studies');
    }
};
