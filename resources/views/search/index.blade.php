@extends('layouts.app')

@section('content')
    <div>
        {!! Form::open(['route' => 'microposts.searched'])!!}
            <div class="form-group">
                {!! Form::text('keyword', old('keyword'), ['class' => 'form-control']) !!}
                {!! Form::submit('Search', ['class' => 'btn btn-primary btn-block']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    @include('microposts.microposts', ['microposts' => $microposts])
@endsection