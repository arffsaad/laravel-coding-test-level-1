<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Cache;

class EventsController extends Controller
{   

    // API Functions //

    public function index()
    {
        // if cache has allEvents, return it. Else cache new allEvents for 5 mins.
        if (Cache::has("allEvents")) {
            $events = Cache::get("allEvents");
        }
        else {
            $events = Event::all();
            Cache::put("allEvents", $events, 300);
        }
        return response()->json($events, 200);
    }

    public function activeEvents()
    {
        if (Cache::has("activeEvents")) {
            $events = Cache::get("activeEvents");
        }
        else {
            $events = Event::where('startAt', '<=', now())->where('endAt', '>=', now())->get();
            Cache::put("activeEvents", $events, 300);
        }
        return response()->json($events, 200);
    }

    public function showEvent($id)
    {
        if (Cache::has("event" . $id)) {
            $event = Cache::get("event" . $id);
            return response()->json($event, 200);
        }
        else {
            $event = Event::find($id);
            if ($event) {
                Cache::put("event" . $id, $event, 60);
                return response()->json($event, 200);
            } else {
                return response()->json(["status" => 404, "message" => "event not found"], 404);
            }
            
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

        // cache new event for 1min
        Cache::put("event" . $event->id, $event, 60);
        SendEmail::dispatch($event->id)->onQueue('default');
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

            // cache updated event for 1min
            Cache::put("event" . $event->id, $event, 60);
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

            // cache new event for 1min
            Cache::put("event" . $event->id, $event, 60);
            SendEmail::dispatch($event->id)->onQueue('default');
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

            Cache::put("event" . $event->id, $event, 60);
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

            // delete event from cache
            Cache::forget("event" . $event->id);
            return response()->json(["status" => 200, "message" => "event deleted"], 200);
        } else {
            return response()->json(["status" => 404, "message" => "event not found"], 404);
        }
    }

    // API Functions END //

    // UI Functions //

    public function uiIndex()
    {
        $events = Event::paginate(10);
        return view('events.index', compact('events'));
    }

    public function uiCreate()
    {
        return view('events.create');
    }

    public function uiStore(Request $request){
        $event = new Event();
        $event->name = $request->name;
        $event->slug = str_replace(' ', '-', $request->name);
        $event->createdAt = Carbon::now();
        $event->updatedAt = Carbon::now();
        $event->startAt = $request->startAt;
        $event->endAt = $request->endAt;
        $event->save();

        Cache::put("event" . $event->id, $event, 60);
        SendEmail::dispatch($event->id)->onQueue('default');
        return redirect()->route('events.index')->with('success', 'Event created!');
    }

    public function uiView($id)
    {
        if (Cache::has("event" . $id)) {
            $event = Cache::get("event" . $id);
            return view('events.view', compact('event'));
        }
        else {
            $event = Event::find($id);
            if ($event) {
                Cache::put("event" . $id, $event, 60);
                return view('events.view', compact('event'));
            } else {
                return redirect()->route('events.index')->with('error', 'Event not found!');
            }
            
        }
    }

    public function uiEdit($id)
    {
        if (Cache::has("event" . $id)) {
            $event = Cache::get("event" . $id);
            return view('events.edit', compact('event'));
        }
        else {
            $event = Event::find($id);
            if ($event) {
                Cache::put("event" . $id, $event, 60);
                return view('events.edit', compact('event'));
            } else {
                return redirect()->route('events.index')->with('error', 'Event not found!');
            }
            
        }
    }

    public function uiSave(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event) {
            $event->name = $request->name;
            $event->slug = str_replace(' ', '-', $request->name);
            $event->updatedAt = Carbon::now();
            $event->startAt = $request->startAt;
            $event->endAt = $request->endAt;
            $event->save();

            Cache::put("event" . $event->id, $event, 60);
            return redirect()->route('events.index')->with('success', 'Event updated!');
        } else {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }
    }

    public function uiDelete($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event) {
            Cache::forget("event" . $event->id);
            $event->delete();
            return redirect()->route('events.index')->with('success', 'Event deleted!');
        } else {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }
    }

    // UI Functions END //
}
