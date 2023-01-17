<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function timetable($classCode = null) {
        $timetable
        $timeframe = array();
        $timeframe['one'] = "8:10am - 9:00am";
        $timeframe['two'] = "9:00am - 9:50am";
        $timeframe['three'] = "9:50am - 10:40am";
        $timeframe['short-break'] = "10:40am - 11:00am";
        $timeframe['four'] = "11:00am - 11:50am";
        $timeframe['five'] = "11:50am - 12:40pm";
        $timeframe['six'] = "12:40pm - 1:30pm";
        $timeframe['long-break'] = "1:30pm - 2:10pm";
        $timeframe['seven'] = "2:10pm - 3:00pm";
        $timeframe['eight'] = "3:00pm - 3:50pm";

        $classTimetable['mon'] = ['English', 'DPT', 'CRS', 'Phy', 'Civic', 'Mathematics', 'Geo', 'Chem']
        $classTimetable['tues'] = ['Mathematics', 'Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic']
        $classTimetable['weds'] = ['Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic', 'Econs']
        $classTimetable['thurs'] = ['Mathematics', 'Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic']
        return view('timetable', compact('classTimetable', 'timeframe'));
    }
}
