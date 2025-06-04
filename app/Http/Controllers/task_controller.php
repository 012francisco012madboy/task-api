<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_task;
use App\Models\tb_state;
use Illuminate\Validation\Rule;

class task_controller extends Controller
{
    /**
     * Criar uma tarefa
     */
    public function addTask(Request $request)
    {
        $request -> validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'user_id' => 'required|string',
            'state_id' => [
                'required', 'string',
                Rule::exists('tb_states', 'id')
            ]
        ]);

        $task = tb_task:: create([
            'title' => $request -> title,
            'description' => $request -> description ?? null,
            'user_id' => $request -> user_id,
            'state_id' => $request -> state_id
        ]);

        return response() -> json([
            'message' => 'Tarefa criada com sucesso'
        ], 201);
    }

    /**
     * Buscar todas tarefas de um usuário
     */
    public function viewTask($user_id)
    {
        $tasks = task:: query()
        ->where('user_id', $user_id)
        ->get();

        if(!$tasks -> isEmpty()){
            return response() -> json([
                'message' => 'Nenhuma tarefa encontrada'
            ], 404);
        }

        return response() -> json($tasks, 200);
    }

    /**
     * Buscar uma tarefa específia
     */
    public function showTask(string $id)
    {
        $task = task:: find($id);

        if(!$task){
            return response() -> json([
                'message' => 'Nenhuma tarefa relacionada'
            ], 404);
        }

        return response() -> json($task, 200);
    }

    /**
     * Filtar tarefas de um usuário
     */
    public function filterTask(string $user_id, string $state_id)
    {
        $state = tb_state:: query()
        ->where('id', $state_id)
        ->exists();

        if(!$state){
            return response() -> json([
                'message' => 'Status inválido'
            ], 422);
        }

        $tasks = task:: query()
        ->where([
            'user_id', $user_id,
            'state_id', $state_id
        ])
        ->get();

        return response() -> json($tasks, 200);
    }

    /**
     * Atualizar estado de uma tarefa
     */
    public function updateStateTask(Request $request, string $id)
    {
        $request -> validate([
            'state_id' => [
                'required', 'string',
                Rule::exists('tb_states', 'id')
            ]
        ]);

        $task = task:: find($id);

        if(!$task){
            return response() -> json([
                'message' => 'Nenhuma tarefa relacionada'
            ], 404);
        }

        $task -> update([
            'state_id' => $request -> state_id
        ]);


        return response() -> json([
            'message' => 'Tarefa atualizada com sucesso'
        ], 200);
    }

    /**
     * Eliminar uma tarefa
     */
    public function destroy(string $id)
    {
        $task = task:: find($id);

        if(!$task){
            return response() -> json([
                'message' => 'Nenhuma tarefa relacionada'
            ], 404);
        }

        $task -> delete();


        return response() -> json([
            'message' => 'Tarefa eliminada com sucesso'
        ], 200);
    }
}
