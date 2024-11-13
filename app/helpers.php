
<?php
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\SchoolInfo;
    if(! function_exists('active_session')) {
        function active_session() {
            if(Session::get('dynamic_session_id') == null) {
                $sessionYear = SessionYear::where('active', 1)->first();
            }
            else {
                 $sessionYear = SessionYear::where('id', Session::get('dynamic_session_id'))->first();
            }
            

            return $sessionYear;
        }
    }

    if(! function_exists('active_term')) {
        function active_term() {
            if(Session::get('dynamic_term_id') == null) {
                $term = Term::where('active', 1)->first();
            }
            else {
                 $term = Term::where('id', Session::get('dynamic_term_id'))->first();
            }

            return $term;
        }
    }
    
    if(! function_exists('get_current_session')) {
        function get_current_session() {
            $sessionYear = SessionYear::where('active', 1)->first();
            return $sessionYear;
        }
    }

    if(! function_exists('get_current_term')) {
        function get_current_term() {
            
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
      
      $string = trim($string);
      if($string == "") {
          return "";
      }
      else {
          $stringArray = explode("_", $string);
          foreach ($stringArray as $key => $stringValue) {
            $stringArray[$key] = ucfirst($stringValue);
          }
          $camelCase = implode($stringArray, " ");
          return $camelCase;
      }
      
  }
}
if(! function_exists('abbreviate')) {
  function abbreviate($string) {
      
      $string = trim($string);
      return $string[0].".";
      
  }
}

if(! function_exists('removeLastCharacter')) {
  function removeLastCharacter($string) {
      
      $string = substr($string, 0, -1);
      return $string;
      
  }
}

if(! function_exists('removeUnderScoreAddSpace')) {
  function removeUnderScoreAddSpace($string) {
      
    $string = trim($string);

    $editedString = str_replace("_", " ", $string);
    return $editedString;

      
  }
}
?>