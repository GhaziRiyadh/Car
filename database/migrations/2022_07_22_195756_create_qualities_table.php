<?php

use App\Models\Quality;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->timestamps();
        });

        Quality::create(['name' => 'جديد']);
        Quality::create(['name' => 'وكالة']);
        Quality::create(['name' => 'مستعمل']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qulities');
    }
};
