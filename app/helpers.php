
<?php
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\SchoolInfo;
    if(! function_exists('active_session')) {
        function active_session() {
            $sessionYear = SessionYear::where('active', 1)->first();

            return $sessionYear;
        }
    }

    if(! function_exists('active_term')) {
        function active_term() {
            $term = Term::where('active', 1)->first();

            return $term;
        }
    }
    if(! function_exists('school_info')) {
        function school_info() {
            $schoolInfo = SchoolInfo::where('id', Auth::user()->school_info_id)->first();

            return $schoolInfo;
        }
    }

if(! function_exists('camelCase')) {
  function camelCase($string) {
      $stringArray = explode("_", $string);
      foreach ($stringArray as $key => $stringValue) {
        $stringArray[$key] = ucfirst($stringValue);
      }
      $camelCase = implode($stringArray, " ");
      return $camelCase;
  }
}
?>