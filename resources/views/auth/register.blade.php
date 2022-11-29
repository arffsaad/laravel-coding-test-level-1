@extends('layouts.app')

@section('content')
@error('username')
    <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
        <strong>Error!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
@error('password')
    <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
        <strong>Error!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
@error('email')
    <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
        <strong>Error!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">Register</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label text-light">Username</label>
            <input type="text" class="form-control" id="userame" name="username" placeholder="Userame">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-light">E-mail</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="mb-3">
                    <label for="password" class="form-label text-light">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-light">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection