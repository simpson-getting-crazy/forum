@props(['resources' => ""])

@if (session()->has('errors'))
    <div class="row">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <h5 class="alert-heading">{{ 'Something Went Wrong With '.$resources }}</h5>
            <ul class="mx-5" style="list-style-type: circle">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
