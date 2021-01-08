
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <user-index-component :user_id="{{ Auth::user()->id }}"></user-index-component>
</div>
@endsection
