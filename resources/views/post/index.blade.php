
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <post-index-component :user_id="{{ Auth::user()->id }}"></post-index-component>
</div>
@endsection
