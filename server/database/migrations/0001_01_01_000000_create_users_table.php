<?php

use App\Models\Position;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->foreignIdFor(Position::class, 'position_id');
            $table->string('photo')->comment('URL to the user photo');
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('users');
    }
};
