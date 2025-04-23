<?php

namespace App\Http\Livewire\Taches;

use Livewire\Component;
use App\Models\Agenda;

class TasksList extends Component
{
    public $contact_id;
    public $tasks;

    public function mount($contact_id)
    {
        $this->contact_id = $contact_id;
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Agenda::where('contact_id', $this->contact_id)
            ->where('archive', false)
            ->orderBy('date_deb', 'desc')
            ->get();
    }

    public function getStatusColor($task)
    {
        if ($task->est_terminee) {
            return 'success';
        }
        
        if ($task->date_fin < now()->format('Y-m-d')) {
            return 'danger';
        }
        
        return match($task->priorite) {
            'haute' => 'warning',
            'basse' => 'info',
            default => 'primary',
        };
    }

    public function render()
    {
        return view('livewire.taches.tasks-list');
    }
} 