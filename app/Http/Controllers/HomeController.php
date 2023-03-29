<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function demoTimetable($classCode = null) {
        $timetable;
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

        $classTimetable['mon'] = ['English', 'DPT', 'CRS', 'Phy', 'Civic', 'Mathematics', 'Geo', 'Chem'];
        $classTimetable['tues'] = ['Mathematics', 'Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic'];
        $classTimetable['weds'] = ['Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic', 'Econs'];
        $classTimetable['thurs'] = ['Mathematics', 'Geo', 'Chem', 'English', 'DPT', 'CRS', 'Phy', 'Civic'];
        return view('timetable', compact('classTimetable', 'timeframe'));
    }

    public function generateRandomEmail() {
        $letters = ['a','b','c','d','e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $letters = array_merge($letters, ['aa','ab','ac','ad','ae', 'af', 'ag', 'ah', 'ai', 'aj', 'ak', 'al', 'am', 'an', 'ao', 'ap', 'aq', 'ar', 'as', 'at', 'au', 'av', 'aw', 'ax', 'ay', 'az']);
        $letters = array_merge($letters, ['ba','bb','bc','bd','be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bk', 'bl', 'bm', 'bn', 'bo', 'bp', 'bq', 'br', 'bs', 'bt', 'bu', 'bv', 'bw', 'bx', 'by', 'bz']);
        $colors = ['brown', 'purple', 'green', 'brown', 'green', 'purple'];
        $colors = array_merge($colors, ['brown', 'purple', 'green', 'brown', 'green', 'purple']);
        $colors = array_merge($colors, ['brown', 'purple', 'purple', 'brown', 'green']);
        $content =[];
        $line = "";
        // return "dd";
        foreach ($letters as $letter) {
            for($i = 0; $i<17;$i++) {
                $line = $line.$letter;
                $content[] = "<span style='color:".$colors[$i].";'>$line</span>";
                // $content[] = $line;
            }
            $line ="";
        }
        

        return "<p style='text-align: justify; font-size:6px; font-family: tahoma'>".implode(" ", $content)."</p>";
    }
}
