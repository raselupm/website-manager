@if(count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please fix these errors.
        @if($errors->any())
            <ul>
                {!! implode('', $errors->all('<li>:message</li>')) !!}
            </ul>
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
