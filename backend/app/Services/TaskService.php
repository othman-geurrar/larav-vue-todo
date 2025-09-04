<?php

namespace App\Services;

use App\Events\TaskCreated;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class TaskService
 * 
 * Service responsable de la logique métier des tâches
 * Utilise le Repository Pattern pour l'accès aux données
 * 
 * @package App\Services
 */
class TaskService
{
    /**
     * Repository des tâches
     *
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * TaskService constructor.
     * 
     * Injection de dépendance du TaskRepository
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Récupère toutes les tâches d'un utilisateur
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserTasks(int $userId): Collection
    {
        try {
            Log::info('Service: Récupération des tâches utilisateur', [
                'user_id' => $userId
            ]);

            return $this->taskRepository->getByUserId($userId);
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la récupération des tâches', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Récupère une tâche par son ID si elle appartient à l'utilisateur
     *
     * @param int $taskId
     * @param int $userId
     * @return Task|null
     */
    public function getTaskById(int $taskId, int $userId): ?Task
    {
        try {
            Log::info('Service: Récupération d\'une tâche par ID', [
                'task_id' => $taskId,
                'user_id' => $userId
            ]);

            return $this->taskRepository->findByIdAndUserId($taskId, $userId);
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la récupération de la tâche', [
                'task_id' => $taskId,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Crée une nouvelle tâche pour un utilisateur
     * Déclenche un événement pour la notification en temps réel
     *
     * @param array $data
     * @param int $userId
     * @return Task
     */
    public function createTask(array $data, int $userId): Task
    {
        try {
            Log::info('Service: Création d\'une nouvelle tâche', [
                'user_id' => $userId,
                'data' => $data
            ]);

            // Ajout de l'ID utilisateur aux données
            $data['user_id'] = $userId;
            
            // Valeurs par défaut
            $data['status'] = $data['status'] ?? 'pending';
            $data['priority'] = $data['priority'] ?? 'medium';

            // Création de la tâche via le repository
            $task = $this->taskRepository->create($data);

            // Déclenchement de l'événement pour WebSocket/Pusher
            // event(new TaskCreated($task));

            Log::info('Service: Tâche créée avec succès', [
                'task_id' => $task->id,
                'user_id' => $userId
            ]);

            return $task;
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la création de la tâche', [
                'user_id' => $userId,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Met à jour une tâche existante si elle appartient à l'utilisateur
     *
     * @param int $taskId
     * @param array $data
     * @param int $userId
     * @return Task|null
     */
    public function updateTask(int $taskId, array $data, int $userId): ?Task
    {
        try {
            Log::info('Service: Mise à jour d\'une tâche', [
                'task_id' => $taskId,
                'user_id' => $userId,
                'data' => $data
            ]);

            // Vérifier que la tâche appartient à l'utilisateur
            $task = $this->taskRepository->findByIdAndUserId($taskId, $userId);
            
            if (!$task) {
                Log::warning('Service: Tentative de mise à jour d\'une tâche inexistante ou non autorisée', [
                    'task_id' => $taskId,
                    'user_id' => $userId
                ]);
                
                return null;
            }

            // Mise à jour via le repository
            $updatedTask = $this->taskRepository->update($task, $data);

            Log::info('Service: Tâche mise à jour avec succès', [
                'task_id' => $taskId,
                'user_id' => $userId
            ]);

            return $updatedTask;
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la mise à jour de la tâche', [
                'task_id' => $taskId,
                'user_id' => $userId,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Supprime une tâche si elle appartient à l'utilisateur
     *
     * @param int $taskId
     * @param int $userId
     * @return bool
     */
    public function deleteTask(int $taskId, int $userId): bool
    {
        try {
            Log::info('Service: Suppression d\'une tâche', [
                'task_id' => $taskId,
                'user_id' => $userId
            ]);

            // Vérifier que la tâche appartient à l'utilisateur
            $task = $this->taskRepository->findByIdAndUserId($taskId, $userId);
            
            if (!$task) {
                Log::warning('Service: Tentative de suppression d\'une tâche inexistante ou non autorisée', [
                    'task_id' => $taskId,
                    'user_id' => $userId
                ]);
                
                return false;
            }

            // Suppression via le repository
            $deleted = $this->taskRepository->delete($task);

            if ($deleted) {
                Log::info('Service: Tâche supprimée avec succès', [
                    'task_id' => $taskId,
                    'user_id' => $userId
                ]);
            }

            return $deleted;
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la suppression de la tâche', [
                'task_id' => $taskId,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Marque une tâche comme terminée
     *
     * @param int $taskId
     * @param int $userId
     * @return Task|null
     */
    public function markAsCompleted(int $taskId, int $userId): ?Task
    {
        try {
            Log::info('Service: Marquage d\'une tâche comme terminée', [
                'task_id' => $taskId,
                'user_id' => $userId
            ]);

            return $this->updateTask($taskId, [
                'status' => 'completed',
                'completed_at' => now()
            ], $userId);
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors du marquage comme terminée', [
                'task_id' => $taskId,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Récupère les statistiques des tâches d'un utilisateur
     *
     * @param int $userId
     * @return array
     */
    public function getTaskStatistics(int $userId): array
    {
        try {
            Log::info('Service: Récupération des statistiques', [
                'user_id' => $userId
            ]);

            $tasks = $this->taskRepository->getByUserId($userId);

            $statistics = [
                'total' => $tasks->count(),
                'pending' => $tasks->where('status', 'pending')->count(),
                'in_progress' => $tasks->where('status', 'in_progress')->count(),
                'completed' => $tasks->where('status', 'completed')->count(),
                'overdue' => $tasks->where('due_date', '<', now())
                                 ->whereIn('status', ['pending', 'in_progress'])
                                 ->count(),
                'by_priority' => [
                    'low' => $tasks->where('priority', 'low')->count(),
                    'medium' => $tasks->where('priority', 'medium')->count(),
                    'high' => $tasks->where('priority', 'high')->count(),
                ],
                'completion_rate' => $tasks->count() > 0 
                    ? round(($tasks->where('status', 'completed')->count() / $tasks->count()) * 100, 2) 
                    : 0
            ];

            Log::info('Service: Statistiques calculées', [
                'user_id' => $userId,
                'statistics' => $statistics
            ]);

            return $statistics;
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors du calcul des statistiques', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Récupère les tâches d'un utilisateur avec filtres
     *
     * @param int $userId
     * @param array $filters
     * @return Collection
     */
    public function getFilteredTasks(int $userId, array $filters = []): Collection
    {
        try {
            Log::info('Service: Récupération des tâches avec filtres', [
                'user_id' => $userId,
                'filters' => $filters
            ]);

            return $this->taskRepository->getByUserIdWithFilters($userId, $filters);
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la récupération avec filtres', [
                'user_id' => $userId,
                'filters' => $filters,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Récupère les tâches en retard d'un utilisateur
     *
     * @param int $userId
     * @return Collection
     */
    public function getOverdueTasks(int $userId): Collection
    {
        try {
            Log::info('Service: Récupération des tâches en retard', [
                'user_id' => $userId
            ]);

            return $this->taskRepository->getOverdueByUserId($userId);
            
        } catch (\Exception $e) {
            Log::error('Service: Erreur lors de la récupération des tâches en retard', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
}