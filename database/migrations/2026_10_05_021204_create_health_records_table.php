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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // create foreign key(user_id)
            $table->float('weight')->nullable();         // body weight (e.g. 65.5)
            $table->integer('systolic_bp')->nullable();   // systolic blood preasure (e.g. 120)
            $table->integer('diastolic_bp')->nullable();  // diastolic blood pressure (e.g. 80)
            $table->date('recorded_at');             
            $table->timestamps();

            $table->unique(['user_id', 'recorded_at']); //only once a day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
