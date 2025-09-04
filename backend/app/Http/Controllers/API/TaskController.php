<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     * GET /api/tasks
     */
    public function index(): JsonResponse
    {
        $tasks = Task::with('user')->get();

        return response()->json([
            'message' => 'Liste des tâches récupérées avec succès',
            'data' => $tasks,
        ]);
    }

    /**
     * Store a newly created task.
     * POST /api/tasks
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_done'     => 'boolean',
            'deadline'    => 'nullable|date',
            'user_id'     => 'required|exists:users,id',
        ]);

        $task = Task::create($validated);

        

        return response()->json([
            'message' => 'Nouvelle tâche ajoutée avec succès',
            'data' => $task,
        ], 201);
    }

    /**
     * Display the specified task.
     * GET /api/tasks/{id}
     */
    public function show($id): JsonResponse
    {
        $task = Task::with('user')->findOrFail($id);

        return response()->json([
            'message' => 'Détail de la tâche récupéré avec succès',
            'data' => $task,
        ]);
    }

    /**
     * Update the specified task.
     * PUT /api/tasks/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_done'     => 'boolean',
            'deadline'    => 'nullable|date',
            'user_id'     => 'sometimes|required|exists:users,id',
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Tâche modifiée avec succès',
            'data' => $task,
        ]);
    }

    /**
     * Remove the specified task.
     * DELETE /api/tasks/{id}
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Tâche supprimée avec succès',
        ]);
    }
}
