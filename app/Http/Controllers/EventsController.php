<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events, 200);
    }

    public function activeEvents()
    {
        $events = Event::where('startAt', '<=', now())->where('endAt', '>=', now())->get();
        return response()->json($events, 200);
    }

    public function showEvent($id)
    {
        $event = Event::find($id);
        if ($event) {
            return response()->json($event, 200);
        } else {
            return response()->json(["status" => 404, "message" => "event not found"], 404);
        }
    }

    public function createEvent(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->slug = str_replace(' ', '-', $request->name);
        $event->createdAt = Carbon::now();
        $event->updatedAt = Carbon::now();
        $event->startAt = $request->startAt;
        $event->endAt = $request->endAt;
        $event->save();
        return response()->json(["status" => 201, "message" => "event created", "id" => $event->id], 201);
    }

    public function putEvent(Request $request, $id){
        $event = Event::find($id);
        if ($event) {
            $event->name = $request->name;
            $event->slug = str_replace(' ', '-', $request->name);
            $event->updatedAt = Carbon::now();
            $event->startAt = $request->startAt;
            $event->endAt = $request->endAt;
            $event->save();
            return response()->json(["status" => 200, "message" => "event updated"], 200);
        } else {
            $event = new Event();
            $event->id = $id;
            $event->name = $request->name;
            $event->slug = str_replace(' ', '-', $request->name);
            $event->createdAt = Carbon::now();
            $event->updatedAt = Carbon::now();
            $event->startAt = $request->startAt;
            $event->endAt = $request->endAt;
            $event->save();
            return response()->json(["status" => 201, "message" => "event created", "id" => $event->id], 201);
        }
    }

    public function patchEvent(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event) {
            if ($request->name) {
                $event->name = $request->name;
                $event->slug = str_replace(' ', '-', $request->name);
            }
            if ($request->startAt) {
                $event->startAt = $request->startAt;
            }
            if ($request->endAt) {
                $event->endAt = $request->endAt;
            }
            $event->updatedAt = Carbon::now();
            $event->save();
            return response()->json(["status" => 200, "message" => "event updated"], 200);
        } else {
            return response()->json(["status" => 404, "message" => "event not found"], 404);
        }
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return response()->json(["status" => 200, "message" => "event deleted"], 200);
        } else {
            return response()->json(["status" => 404, "message" => "event not found"], 404);
        }
    }
}
