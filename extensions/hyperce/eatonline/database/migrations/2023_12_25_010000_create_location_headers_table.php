<?php

namespace Hyperce\EatOnline\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationHeadersTable extends Migration
{
    public function up()
    {
        Schema::create('location_headers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('location_id');
            $table->text('href')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('location_headers');

    }
}
