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
        Schema::create('allocation_rules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('allocation_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->decimal('percentage', 5, 2);

            $table->foreignId('target_account_id')
                ->constrained('accounts')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocation_rules');
    }
};
