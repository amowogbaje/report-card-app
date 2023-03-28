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

    public function generateRandomPhoneNo() {
        $numbers = ['0','1','2','3','4', '5', '6', '7', '8', '9'];
        $numbers = array_merge($numbers, ['01','02','03','04', '05', '06', '07', '08', '09']);
        $numbers = array_merge($numbers, ['10','12','13','14', '15', '16', '17', '18', '19']);
        $numbers = array_merge($numbers, ['20','21','23','24', '25', '26', '27', '28', '29']);
        $numbers = array_merge($numbers, ['30','31','33','34', '35', '36', '37', '38', '39']);
        $numbers = array_merge($numbers, ['40','41','42','43', '45', '46', '47', '48', '49']);
        $numbers = array_merge($numbers, ['50','51','53','54','52', '56', '57', '58', '59']);
        $numbers = array_merge($numbers, ['60','61','62','63','64', '65', '67', '68', '69']);
        $numbers = array_merge($numbers, ['70','71','72','73','74', '75', '76', '78', '79']);
        $colors = ['brown', 'purple', 'green', 'brown', 'green', 'purple'];
        $colors = array_merge($colors, ['brown', 'purple', 'green', 'brown', 'green', 'purple']);
        $colors = array_merge($colors, ['brown', 'purple', 'purple', 'brown', 'green']);
        $content =[];
        $line = "";
        // return "dd";
        foreach ($numbers as $number) {
            for($i = 0; $i<17;$i++) {
                $line = $line.$number;
                // $content[] = "<span style='color:".$colors[$i].";'>$line</span>";
                $content[] = "F234".$line;
            }
            $line ="";
        }
        

        // return "<p style='text-align: justify; font-size:12px; font-family: tahoma'>".implode(" ", $content)."</p>";
        return implode("<br>", $content);
    }
}
