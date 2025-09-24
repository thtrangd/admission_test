<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id(); // Khóa chính auto-increment
            $table->string('application_id')->unique(); // APP-YYYY-####
            $table->string('applicant_name');
            $table->string('programme');
            $table->string('intake');
            $table->enum('status', ['Submitted', 'Accepted', 'Rejected'])->default('Submitted');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
