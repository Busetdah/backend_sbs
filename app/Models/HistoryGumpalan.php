<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('history_gumpalan', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('history_gumpalan');
    }
};
