<span id="tooltip-archive">
    @if ($permission)
        <a data-href="{{ $route }}" style="cursor: pointer;" class="action-icon {{ $classarchive }} text-warning"
            data-bs-container="#tooltip-archive" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ $tooltip }}">
            <i class="mdi mdi-archive-arrow-down"></i>
        </a>
    @endif
</span>
