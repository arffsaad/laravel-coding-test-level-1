@extends('layouts.app')

@section('content')
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">{{$event->name}}</p>
    <table class="table table-light table-striped table-bordered border-dark">
        <tr>
            <th scope="col" width="15%">Event ID</th>
            <td>{{$event->id}}</td>
        </tr>
        <tr>
            <th scope="col" width="15%">Event Name</th>
            <td>{{$event->name}}</td>
        </tr>
        <tr>
            <th scope="col" width="15%">Starting Date</th>
            <td>{{$event->startAt}}</td>
        </tr>
        <tr>
            <th scope="col" width="15%">Ending Date</th>
            <td>{{$event->endAt}}</td>
        </tr>
        <tr>
            <th scope="col" width="15%">Active</th>
            <td>
                @if (($event->startAt <= now() && ($event->endAt >= now())))
                <span class="badge bg-success">Active</span>
                @else
                <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
    </table>
    <a href="/events"><button type="button" class="btn btn-secondary">Back</button></a>
</div>
@endsection