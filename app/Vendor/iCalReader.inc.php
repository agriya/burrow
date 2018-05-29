<?php
/**
 * @fileoverview This PHP-Class should only read a iCal-File (*.ics), parse it
 * and give an array with its content.
 *
 * @author: Martin Thoma
 * @version: 1.0
 * @website: http://code.google.com/p/ics-parser/
 * @example
 *     $ical = new ical('MyCal.ics');
 *     print_r( $ical->get_event_array() );
 */

/**
 * This is the iCal-class
 * @param {string} filename The name of the file which should be parsed
 * @constructor
 */

error_reporting(E_ALL);

class ical {
    /* How many ToDos are in this ical? */
    public  /** @type {int} */ $todo_count = 0;

    /* How many events are in this ical? */
    public  /** @type {int} */ $event_count = 0; 

    /* The parsed calendar */
    public /** @type {Array} */ $cal;

    /* Which keyword has been added to cal at last? */
    private /** @type {string} */ $last_keyword;

    public function __construct($filename) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if($lines === false){return false;}
        else if (stristr($lines[0],'BEGIN:VCALENDAR') === false){return false;}
        else {
            foreach ($lines as $line) {
                $line = trim($line);
                $add = $this->split_key_value($line);
                if($add === false){
                    $this->add_to_array($type, false, $line);
                    continue;
                } 

                list($keyword, $value) = $add;

                switch ($line) {
                    // http://www.kanzaki.com/docs/ical/vtodo.html
                    case "BEGIN:VTODO": 
                        $this->todo_count++;
                        $type = "VTODO"; 
                        break; 

                    // http://www.kanzaki.com/docs/ical/vevent.html
                    case "BEGIN:VEVENT": 
                        #echo "vevent gematcht";
                        $this->event_count++;
                        $type = "VEVENT"; 
                        break; 

                    //all other special strings
                    case "BEGIN:VCALENDAR": 
                    case "BEGIN:DAYLIGHT": 

                    // http://www.kanzaki.com/docs/ical/vtimezone.html
                    case "BEGIN:VTIMEZONE": 
                    case "BEGIN:STANDARD": 
                        $type = $value;
                        break; 
                    case "END:VTODO": // end special text - goto VCALENDAR key 
                    case "END:VEVENT": 
                    case "END:VCALENDAR": 
                    case "END:DAYLIGHT": 
                    case "END:VTIMEZONE": 
                    case "END:STANDARD": 
                        $type = "VCALENDAR"; 
                        break; 
                    default:
                        $this->add_to_array($type, $keyword, $value);
                        break; 
                } 
            }
            return $this->cal; 
        }
    }

    /** 
     * Add to $this->ical array one value and key.
     * 
     * @param {string} $type This could be VTODO, VEVENT, VCALENDAR, ... 
     * @param {string} $keyword
     * @param {string} $value 
     */ 
    function add_to_array($type, $keyword, $value) {
        if ($keyword == false) { 
            $keyword = $this->last_keyword; 
            switch ($type) {
              case 'VEVENT': 
                  $value = $this->cal[$type][$this->event_count - 1][$keyword].$value;
                  break;
              case 'VTODO' : 
                  $value = $this->cal[$type][$this->todo_count - 1][$keyword].$value;
                  break;
            }
        }
        
        if (stristr($keyword,"DTSTART") or stristr($keyword,"DTEND")) {
            $keyword = explode(";", $keyword);
            $keyword = $keyword[0];
        }

        switch ($type) { 
            case "VTODO": 
                $this->cal[$type][$this->todo_count - 1][$keyword] = $value;
                #$this->cal[$type][$this->todo_count]['Unix'] = $unixtime;
                break; 
            case "VEVENT": 
                $this->cal[$type][$this->event_count - 1][$keyword] = $value; 
                break; 
            default: 
                $this->cal[$type][$keyword] = $value; 
                break; 
        } 
        $this->last_keyword = $keyword; 
    }

    /**
     * @param {string} $text which is like "VCALENDAR:Begin" or "LOCATION:"
     * @return {Array} array("VCALENDAR", "Begin")
     */
    function split_key_value($text) {
        preg_match("/([^:]+)[:]([\w\W]*)/", $text, $matches);
        if(count($matches) == 0){return false;}
        $matches = array_splice($matches, 1, 2);
        return $matches;
    }

    /** 
     * Return Unix timestamp from ical date time format 
     * 
     * @param {string} $ical_date A Date in the format YYYYMMDD[T]HHMMSS[Z] or
     *                            YYYYMMDD[T]HHMMSS
     * @return {int} 
     */ 
    function ical_date_to_unix_timestamp($ical_date) { 
        $ical_date = str_replace('T', '', $ical_date); 
        $ical_date = str_replace('Z', '', $ical_date); 

        $pattern = '/([0-9]{4})';   # 1: YYYY
        $pattern.= '([0-9]{2})';    # 2: MM
        $pattern.= '([0-9]{2})';    # 3: DD
        $pattern.= '([0-9]{0,2})';  # 4: HH
        $pattern.= '([0-9]{0,2})';  # 5: MM
        $pattern.= '([0-9]{0,2})/'; # 6: SS
        preg_match($pattern, $ical_date, $date); 

        // Unix timestamp can't represent dates before 1970
        if ($date[1] <= 1970) {
            return false;
        } 
        $timestamp = mktime(
                        (int)$date[4], 
                        (int)$date[5], 
                        (int)$date[6], 
                        (int)$date[2],
                        (int)$date[3], 
                        (int)$date[1]
                      );
        return  $timestamp;
    } 

    /**
     * Returns an array of arrays with all events. Every event is an associative
     * array and each property is an element it.
     * @return {array}
     */
    function get_event_array() {
        $array = $this->cal;
        return isset($array['VEVENT'])? $array['VEVENT'] : array();
    } 
} 
?>