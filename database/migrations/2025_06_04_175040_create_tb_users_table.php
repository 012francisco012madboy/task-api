<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\tb_user;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });

        $users = [
            [
                'name' => 'Ariel Francisco',
                'email' => 'arielfrancisco690@gmail.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'name' => 'Mônica Fila',
                'email' => 'monicafila@gmail.com',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        tb_user::insert($users);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_users');
    }
};
