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
        Schema::create('gtk_inpassings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gtk::class)->constrained()->cascadeOnDelete();
            $table->string('sk_number')->nullable();
            $table->date('sk_date')->nullable();
            $table->string('rank_group'); // Golongan/Pangkat (misal: III/b)
            $table->integer('credit_score')->nullable();
            $table->date('tmt_inpassing')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtk_inpassings');
    }
};
