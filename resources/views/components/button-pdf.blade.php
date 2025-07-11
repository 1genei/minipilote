<span id="tooltip-edit">
    @if ($permission)
        <a href="{{ $route }}" data-bs-container="#tooltip-edit" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ $tooltip }}" class="action-icon pdf-contact text-danger"> <i
                class="mdi mdi-file-download"></i>
        </a>
    @endif
</span>
