<span id="tooltip-show">
    @if ($permission)
        <a href="{{ $route }}" class="action-icon" data-bs-container="#tooltip-show" data-bs-toggle="tooltip"
            data-bs-placement="top" title="{{ $tooltip }}"> <i class="mdi mdi-eye"></i>
        </a>
    @endif
</span>
