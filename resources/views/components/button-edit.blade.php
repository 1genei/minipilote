<span id="tooltip-edit">
    @if ($permission)
        <a href="{{ $route }}" data-bs-container="#tooltip-edit" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ $tooltip }}" class="action-icon edit-contact text-success"> <i
                class="mdi mdi-square-edit-outline"></i>
        </a>
    @endif
</span>
