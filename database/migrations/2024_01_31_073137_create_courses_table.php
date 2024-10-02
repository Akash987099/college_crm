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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('college_id');
            $table->string('name');
            $table->string('fees');
            $table->string('sheat');
            $table->string('admission');
            $table->string('eligibility');
            $table->string('fee_pdf');
            $table->string('admission_pdf');
            $table->string('eligibility_pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
