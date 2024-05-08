<?php

use App\Enums\Gender;
use App\Models\ClientInfo;
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
        Schema::table(ClientInfo::TABLE, function (Blueprint $table) {
            $table->string('gender')->after('tariff_id')->default(Gender::MALE->value);
            $table->float('weight')->after('gender');
            $table->float('height')->after('weight');
            $table->float('age')->after('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(ClientInfo::TABLE, function (Blueprint $table) {
            $table->dropColumn(['gender', 'weight', 'height', 'age']);
        });
    }
};
