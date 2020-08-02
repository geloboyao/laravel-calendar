<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon as Carbon;

// models
use App\Models\Event as Event;

use App\Http\Controllers\Controller as Controller;

class CalendarController extends Controller
{
    public function index()
    {
        $month = date('F', strtotime('2020-08-01'));
        $year = date('Y', strtotime('2020-08-01'));

        return view('calendar')
            ->with('month', $month)
            ->with('year', $year);
    }

    public function create()
    {}

    public function store(Request $request)
    {}

    public function show()
    {
        $event = Event::where('id', 1)->first();
        $count = $event->count();

        $start = Carbon::createFromDate('2020-08-01');
        $dates = [];

        $event_day = json_decode($event->day, true);

        for ($i = 1; $i <= $start->daysInMonth; $i++)
        {
            $temp = array();
            $temp['id'] = $i - 1;
            $temp['date'] = $i;
            $temp['day'] = Carbon::createFromDate($start->year, $start->month, $i)->format('l');

            $day = Carbon::createFromDate($start->year . '-' . $start->month . '-' . $i);

            if ($count > 0)
            {
                if (
                    $day->gte(Carbon::createFromDate($event->from)->format('Y-m-d'))
                    && (
                        $day->lt(Carbon::createFromDate($event->to)->format('Y-m-d'))
                        || $day->format('Y-m-d') == Carbon::createFromDate($event->to)->format('Y-m-d')
                    )
                    && in_array(Carbon::createFromDate($start->year, $start->month, $i)->format('w'), $event_day)
                ) {
                    $temp['is_event'] = true;
                    $temp['event_name'] = $event->name;
                }
                else
                {
                    $temp['is_event'] = false;
                    $temp['event_name'] = '';
                }
            }
            else
            {
                $temp['is_event'] = false;
                $temp['event_name'] = '';
            }

            $dates[] = $temp;
        }

        echo json_encode([
            'dates' => $dates,
            'event_name' => $event->name,
            'event_from' => $event->from,
            'event_to' => $event->to,
            'event_day' => $event_day
        ]);

        exit;
    }

    public function edit($id)
    {}

    public function update($id, Request $request)
    {
        $event = Event::findOrFail($id);

        $days = json_decode($request->days, true);

        sort($days);

        $days = json_encode($days);

        $event->name = $request->event_name;
        $event->day = $days;
        $event->from = date('Y-m-d', strtotime($request->event_from));
        $event->to = date('Y-m-d', strtotime($request->event_to));
        $event->save();
    }

    public function destroy(Request $request)
    {}
}
