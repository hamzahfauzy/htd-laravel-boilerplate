<div class="d-inline-block">
    <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true">
        <i class="icon-base bx bx-dots-vertical-rounded"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
        @foreach($buttons as $button)
        <li>{!! $button !!}</li>
        @endforeach
    </ul>
</div>