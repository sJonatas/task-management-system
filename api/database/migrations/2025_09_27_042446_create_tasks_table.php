<?php

use App\Enum\PriorityEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\StatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false);
            $table->string('description', 500)->nullable();
            $table->enum('status', StatusEnum::cases())->default(StatusEnum::Pending)->nullable(false);
            $table->enum('priority', PriorityEnum::cases())->default(PriorityEnum::Low)->nullable(false);
            $table->datetime('dueDate')->nullable(false)->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
