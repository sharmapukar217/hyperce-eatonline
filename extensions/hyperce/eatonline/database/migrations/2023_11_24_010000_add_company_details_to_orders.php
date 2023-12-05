<?php

namespace Hyperce\EatOnline\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyDetailsToOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'ebee_vat_id')) {
                $table->string('ebee_vat_id');
            }

            if (!Schema::hasColumn('orders', 'ebee_company_name')) {
                $table->string('ebee_company_name');
            }

        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'ebee_vat_id')) {
                $table->dropColumn('ebee_vat_id');
            }
            if (Schema::hasColumn('orders', 'ebee_company_name')) {
                $table->dropColumn('ebee_company_name');
            }
        });
    }
}
