<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_task;
use App\Models\tb_state;
use App\Models\tb_user;
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
        $user = tb_user:: query()
        ->where('id', $user_id)
        ->exists();

        if(!$user){
            return response() -> json([
                'message' => 'Usuário inválido'
            ], 422);
        }

        $tasks = tb_task:: query()
        ->join('tb_users as TU', 'TU.id', '=', 'tb_tasks.user_id')
        ->join('tb_states as TS', 'TS.id', '=', 'tb_tasks.state_id')
        ->select(
            'tb_tasks.id as task_id',
            'tb_tasks.title as task_title',
            'tb_tasks.description as task_description',
            'tb_tasks.created_at as task_created_at',
            'TU.id as user_id',
            'TU.name as user_name',
            'TS.id as state_id,',
            'TS.name as state_name,'
        )
        ->where('tb_tasks.user_id', $user_id)
        ->orderBy('tb_tasks.updated_at', 'desc')
        ->get();

        if($tasks -> isEmpty()){
            return response() -> json([
                'message' => 'Nenhuma tarefa encontrada'
            ], 404);
        }

        return response() -> json($tasks, 200);
    }

    /**
     * Buscar uma tarefa específia
     */
    public function showTask(string $user_id, string $task_id)
    {
        $user = tb_user:: query()
        ->where('id', $user_id)
        ->exists();

        if(!$user){
            return response() -> json([
                'message' => 'Usuário inválido'
            ], 422);
        }

        $task = tb_task:: query()
        ->join('tb_users as TU', 'TU.id', '=', 'tb_tasks.user_id')
        ->join('tb_states as TS', 'TS.id', '=', 'tb_tasks.state_id')
        ->select(
            'tb_tasks.id as task_id',
            'tb_tasks.title as task_title',
            'tb_tasks.description as task_description',
            'tb_tasks.created_at as task_created_at',
            'TU.id as user_id',
            'TU.name as user_name',
            'TS.id as state_id,',
            'TS.name as state_name,'
        )
        ->where('tb_tasks.id', $task_id)
        ->where('tb_tasks.user_id', $user_id)
        ->first();

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
        $user = tb_user:: query()
        ->where('id', $user_id)
        ->exists();

        if(!$user){
            return response() -> json([
                'message' => 'Usuário inválido'
            ], 422);
        }

        $state = tb_state:: query()
        ->where('id', $state_id)
        ->exists();

        if(!$state){
            return response() -> json([
                'message' => 'Status inválido'
            ], 422);
        }

        $tasks = tb_task:: query()
        ->join('tb_users as TU', 'TU.id', '=', 'tb_tasks.user_id')
        ->join('tb_states as TS', 'TS.id', '=', 'tb_tasks.state_id')
        ->select(
            'tb_tasks.id as task_id',
            'tb_tasks.title as task_title',
            'tb_tasks.description as task_description',
            'tb_tasks.created_at as task_created_at',
            'TU.id as user_id',
            'TU.name as user_name',
            'TS.id as state_id,',
            'TS.name as state_name,'
        )
        ->where('tb_tasks.user_id', $user_id,)
        ->where('tb_tasks.state_id', $state_id)
        ->orderBy('tb_tasks.updated_at', 'desc')
        ->get();

        if($tasks -> isEmpty()){
            return response() -> json([
                'message' => 'Nenhuma tarefa encontrada'
            ], 404);
        }

        return response() -> json($tasks, 200);
    }

    /**
     * Atualizar estado de uma tarefa
     */
    public function updateStateTask(Request $request, string $user_id, string $task_id)
    {
        $user = tb_user:: query()
        ->where('id', $user_id)
        ->exists();

        if(!$user){
            return response() -> json([
                'message' => 'Usuário inválido'
            ], 422);
        }

        $request -> validate([
            'state_id' => [
                'required', 'string',
                Rule::exists('tb_states', 'id')
            ]
        ]);

        $task = tb_task:: query()
        ->where('id', $task_id)
        ->where('user_id', $user_id)
        ->first();

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
    public function deleteTask(string $user_id, string $task_id)
    {
        $user = tb_user:: query()
        ->where('id', $user_id)
        ->exists();

        if(!$user){
            return response() -> json([
                'message' => 'Usuário inválido'
            ], 422);
        }

        $task = tb_task:: query()
        ->where('id', $task_id)
        ->where('user_id', $user_id)
        ->first();

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
