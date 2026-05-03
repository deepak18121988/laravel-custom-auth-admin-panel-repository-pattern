@extends('layouts.user')

@section('user-content')

<h3>My Profile</h3>

<p>Name: {{ auth()->user()->name }}</p>
<p>Email: {{ auth()->user()->email }}</p>

@endsection