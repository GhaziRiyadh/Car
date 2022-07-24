<?php

use App\Models\AppInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('app_infos', function (Blueprint $table) {
            $table->id();
            $table->text('aboutUs');
            $table->char('phone',50);
            $table->text('address');
            $table->char('email',50);
            $table->timestamps();
        });

        AppInfo::query()->create([
            'aboutUs' => '',
            'phone' => '',
            'address' => '',
            'email' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('app_infos');
    }
};
