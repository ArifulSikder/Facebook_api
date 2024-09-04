
@if ($parent->parent)
    @include('backend.pages.user.role_and_permission.childreen', ['parent' => $parent->parent]) 
@endif
<span> ( {{ $parent->name }} )  <i class="fas fa-caret-right"></i></span>
