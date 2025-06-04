<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\tb_state;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $states = [
            [
                'name' => 'Pendente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'name' => 'Em andamento',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'name' => 'Concluída',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        tb_state::insert($states);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_states');
    }
};
