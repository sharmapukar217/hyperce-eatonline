<?php

namespace Hyperce\EatOnline\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEbeeWebsiteInLocations extends Migration
{
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('ebee_website');
        });
    }

    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('ebee_website');
        });
    }
}
