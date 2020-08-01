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

        $start = Carbon::createFromDate(strtotime('2020-08-01'));
        $dates = [];

        for ($i = 1; $i <= $start->daysInMonth; $i++)
        {
            $temp = array();
            $temp['id'] = $i - 1;
            $temp['date'] = $i;
            $temp['day'] = Carbon::createFromDate($start->year, $start->month, $i)->format('l');

            $day = Carbon::createFromDate($start->year, $start->month, $i);

            $event_day = json_decode($event->day, true);

            if ($count > 0)
            {
                if (
                    $day->greaterThanOrEqualTo(Carbon::createFromDate(strtotime($event->from))->format('Y-m-d'))
                    && $day->lessThanOrEqualTo(Carbon::createFromDate(strtotime($event->to))->format('Y-m-d'))
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

        echo json_encode($dates);
        exit;
    }

    public function edit($id)
    {}

    public function update($id, Request $request)
    {}

    public function destroy(Request $request)
    {}
}
