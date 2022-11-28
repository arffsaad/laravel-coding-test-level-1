@extends('layouts.app')

@section('content')
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">Edit {{$event->name}}</p>
    <form method="POST" action="">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label text-light">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$event->name}}">
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="mb-3">
                    <label for="startAt" class="form-label text-light">Starting Date</label>
                    <input type="date" class="form-control" id="startAt" name="startAt" value="{{$event->startAt}}">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="endAt" class="form-label text-light">End Date</label>
                    <input type="date" class="form-control" id="endAt" name="endAt" value="{{$event->endAt}}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection