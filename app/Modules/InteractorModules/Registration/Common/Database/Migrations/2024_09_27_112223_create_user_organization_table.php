<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_organization', function (Blueprint $table) {
            $table->uuid('user_id')
                ->constrained('users', 'id')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations', 'id')->noActionOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_organization');
    }
};
