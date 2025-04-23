<div>
    {{-- Liste des notes --}}
    <div class="timeline-alt pb-0">
        @forelse($notes as $note)
            <div class="timeline-item">
                <i class="mdi mdi-note-text bg-info-lighten text-info timeline-icon"></i>
                <div class="timeline-item-info">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-0 mb-1">{{ $note->user->name }}</h5>
                        <div>
                            <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                            @if($note->user_id === Auth::id())
                                <a href="#" class="text-success ms-2 edit-note" data-bs-toggle="modal" data-bs-target="#editNoteModal" title="Modifier" data-note-id="{{ $note->id }}" data-note-content="{{ $note->note }}">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="#" class="text-danger ms-2" wire:click.prevent="deleteNote({{ $note->id }})"
                                   data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                                
                            @endif
                        </div>
                    </div>
                    <p class="text-muted mt-2 mb-0">
                        {!! nl2br(e($note->note)) !!}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">
                <i class="mdi mdi-note-outline h3"></i>
                <p>Aucune note pour le moment</p>
            </div>
        @endforelse
    </div>

    {{-- Modal d'ajout de note --}}
    <div wire:ignore.self class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="addNote">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNoteModalLabel">Nouvelle note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="note_content" class="form-label">Contenu de la note</label>
                            <textarea 
                                class="form-control @error('note_content') is-invalid @enderror" 
                                wire:model.defer="note_content"
                                rows="4" 
                                placeholder="Écrivez votre note ici..."
                            ></textarea>
                            @error('note_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-plus-circle me-1"></i> Ajouter la note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal de modification de note --}}
    <div wire:ignore.self class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="updateNote">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNoteModalLabel">Modifier la note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_content" class="form-label">Contenu de la note</label>
                            <input type="hidden" id="edit_note_id" wire:model="edit_note_id">
                            <textarea 
                                class="form-control @error('edit_content') is-invalid @enderror" 
                                wire:model.defer="edit_content"
                                rows="4" 
                                id="edit_content"
                                placeholder="Écrivez votre note ici..."
                            ></textarea>
                            @error('edit_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-pencil me-1"></i> Modifier la note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener('livewire:load', function () {
        // Gestion de l'ajout
        Livewire.on('noteAdded', () => {
            $('#addNoteModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Note ajoutée avec succès',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Gestion de la modification
        Livewire.on('noteUpdated', () => {
            $('#editNoteModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Note modifiée avec succès',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Gestion de la suppression
        Livewire.on('noteDeleted', () => {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Note supprimée avec succès',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Réinitialisation des modales
        $('#addNoteModal').on('hidden.bs.modal', function () {
            @this.set('note_content', '');
        });

        $('#editNoteModal').on('hidden.bs.modal', function () {
            @this.set('edit_content', '');
            @this.set('edit_note_id', null);
        });

        // Gestion du clic sur le bouton d'édition
        $(document).on('click', '.edit-note', function() {
            var noteId = $(this).data('note-id');
            var noteContent = $(this).data('note-content');
            @this.set('edit_note_id', noteId);
            @this.set('edit_content', noteContent);
        });
    });
</script>
@endsection 