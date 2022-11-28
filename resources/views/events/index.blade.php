@extends('layouts.app')

@section('content')
<div class="mx-auto" style="width:800px">
    <p class="fs-1 mt-4 text-light">Events List</p>
    <table class="table table-light table-striped">
        <thead class="table-info">
            <tr>
                <th scope="col" width="15%">Event Name</th>
                <th scope="col" width="10%">Starting Date</th>
                <th scope="col" width="10%">End Date</th>
                <th scope="col" width="5%">Active</th>
                <th scope="col" width="5%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <th scope="row"><a href="{{'events/' . $event->id}}">{{$event->name}}</a></th>
                <td>{{$event->startAt}}</td>
                <td>{{$event->endAt}}</td>
                <td>
                    @if (($event->startAt <= now() && ($event->endAt >= now())))
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href={{"events/". $event->id ."/edit"}}><button type="button" class="btn"><i class="bi bi-pen-fill"></i></button></a>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target={{"#deleteEvent" . $event->id}}><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
            {{-- modal for deletion --}}
            <div class="modal fade" id={{"deleteEvent" . $event->id}} tabindex="-1" aria-labelledby="deleteEventLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteEventLabel">Delete Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this event?</p><br>
                            <p class="fs-5">{{$event->name}}</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action={{"events/" . $event->id . "/delete"}} method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>


            @endforeach
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection