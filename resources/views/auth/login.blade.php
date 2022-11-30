@extends('layouts.app')

@section('content')
@error('username')
    <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
        <strong>Error!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">Login</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label text-light">Username</label>
            <input type="text" class="form-control" id="userame" name="username" placeholder="Userame">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-light">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="mb-3 form-check">
            <input type="hidden" name="remember" value="0">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label text-light" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection