<?php

use Illuminate\Http\Request;
use App\Http\Controllers\task_controller;
use Illuminate\Support\Facades\Route;

Route::get("/view-state", [state_controller::class, "viewState"]);

Route::post("/add-task", [task_controller::class, "addTask"]);
Route::get("/view-task/{user_id}", [task_controller::class, "viewTask"]);
Route::get("/show-task/{user_id}/{task_id}", [task_controller::class, "showTask"]);
Route::get("/filter-task/{user_id}/{state_id}", [task_controller::class, "filterTask"]);
Route::delete("/delete-task/{user_id}/{task_id}", [task_controller::class, "deleteTask"]);
Route::patch("/update-state-task/{user_id}/{state_id}", [task_controller::class, "updateStateTask"]);
