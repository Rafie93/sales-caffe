<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events\Event;
use App\Http\Resources\Events\EventList as ListResource;
use Carbon\Carbon;

class EventController extends Controller
{
     public function index(Request $request)
    {
        $events = Event::orderBy('date_end','desc')
                    ->where('date_end','>',Carbon::now())
                    ->get();

        return new ListResource($events);
    }
}
