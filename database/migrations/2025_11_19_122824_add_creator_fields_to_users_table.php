<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('slug')->unique()->nullable();
        $table->string('public_name')->nullable();
        $table->string('avatar')->nullable();
        $table->text('bio')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['slug', 'public_name', 'avatar', 'bio']);
    });
}

};
