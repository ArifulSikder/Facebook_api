
@if (isset($edit))
<a href="{{ $edit }}" class="p-2"><i class="fas fa-edit fa-lg text-primary"></i></a>
@endif

@if (isset($delete))
<a id="delete" href="{{ $delete }}" class="p-2"><i class="fas fa-trash fa-lg text-danger"></i></a>
@endif
