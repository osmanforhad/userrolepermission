@if ($errors->any())
    <div class="alert alert-danger">
        <div>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        <div>
                <li>{{ Session::get('success') }}</li>
        </div>
    </div>
@endif