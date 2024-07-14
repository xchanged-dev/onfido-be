@if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-warning text-center">
        {{ session('error') }}
    </div>
@elseif(session('error-html'))
    {{-- USED IN PROMO CODES --}}
    <div class="alert alert-danger text-center">
        {!! session('error-html') !!}
    </div>
@endif

@if (count($errors))
    <div class="form-group">
        <div class="alert alert-danger text-center">
            <ul style="list-style-type:none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
