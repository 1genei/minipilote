<?php

namespace App\Http\Livewire\Notes;

use Livewire\Component;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NotesList extends Component
{
    public $contact_id;
    public $note_content;
    public $edit_content;
    public $edit_note_id;
    public $notes;
    public $editing_note_id = null;

    protected $rules = [
        'note_content' => 'required|min:3',
        'edit_content' => 'required|min:3'
    ];

    protected $messages = [
        'note_content.required' => 'Le contenu de la note est requis',
        'note_content.min' => 'La note doit contenir au moins 3 caractères',
        'edit_content.required' => 'Le contenu de la note est requis',
        'edit_content.min' => 'La note doit contenir au moins 3 caractères'
    ];

    protected $listeners = ['setNoteData'];

    public function mount($contact_id)
    {
        $this->contact_id = $contact_id;
        $this->loadNotes();
    }

    public function loadNotes()
    {
        $this->notes = Note::where('contact_id', $this->contact_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function addNote()
    {
        $this->validate([
            'note_content' => 'required|min:3'
        ]);

        Note::create([
            'contact_id' => $this->contact_id,
            'user_id' => Auth::id(),
            'note' => $this->note_content,
            'type' => 'contact'
        ]);

        $this->note_content = '';
        $this->loadNotes();
        $this->emit('noteAdded');
    }

    public function deleteNote($note_id)
    {
        $note = Note::find($note_id);
        if ($note && $note->user_id === Auth::id()) {
            $note->delete();
            $this->loadNotes();
            $this->emit('noteDeleted');
        }
    }

    public function editNote($note_id)
    {
        $note = Note::find($note_id);
        if ($note && $note->user_id === Auth::id()) {
            $this->editing_note_id = $note_id;
            $this->note_content = $note->note;
            $this->dispatchBrowserEvent('openEditModal');
        }
    }

    public function setNoteData($noteId, $content)
    {
        $this->edit_note_id = $noteId;
        $this->edit_content = $content;
    }

    public function updateNote()
    {
        $this->validate([
            'edit_content' => 'required|min:3'
        ]);

        $note = Note::find($this->edit_note_id);
        if ($note && $note->user_id === Auth::id()) {
            $note->update([
                'note' => $this->edit_content
            ]);

            $this->edit_note_id = null;
            $this->edit_content = '';
            $this->loadNotes();
            $this->emit('noteUpdated');
        }
    }

    public function render()
    {
        return view('livewire.notes.notes-list');
    }
} 