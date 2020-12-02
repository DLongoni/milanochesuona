<?php
require_once __DIR__ . '/../src/REP/RepUserSubmissions.php';
require_once __DIR__ . '/../src/REP/RepVenue.php';
require_once __DIR__ . '/../src/REP/RepEvent.php';
$link =$_REQUEST['link'];
$type =$_REQUEST['type'];

$outcome = 0;
// 0 -> error
// 1 -> success
// 2 -> already submitted
// 3 -> venue in db
// 4 -> event approved in DB
// 5 -> event rejected in DB
// 6 -> event submitted but discarded cause of crawling problems
$type_id = 0;

if ($type=="ev") {
    $type_id = 2;
} elseif ($type=="loc") {
    $type_id = 1;
}

try{
    if ($type_id > 0) {

        $m = preg_match(
            '/facebook\.[\w]{2,3}\/(events\/)?([\w\d-]+)\/?/', 
            $link, 
            $matches
        );
        if ($m==1) {

            $fb_id = $matches[2];
            if ($type_id==1) { // Venue -> do I already have it?
                $V = RepVenue::GetByFbLink($fb_id);
                if ($V!=null) {
                    $outcome=3;
                }
            } else if ($type_id==2) { // Event -> do I already have it?
                $E = RepEvent::GetByFbId($fb_id);
                if ($E!=null) {
                    switch ($E->statusId){
                    case 1: // Loaded
                        $outcome = 2;
                        break;
                    case 2: // Approved
                        $outcome = 4;
                        break;
                    case 3: // Rejected
                        $outcome = 5;
                        break;
                    case 4: // Approved Bandless
                        $outcome = 4;
                        break;
                    }
                }
            } elseif (RepUserSubmissions::exists($fb_id, $type_id, 2)) {
                $outcome=6; // Submitted and discarded for importing problems
            } elseif (RepUserSubmissions::exists($fb_id, $type_id)) {
                $outcome=2;
            }    

            if ($outcome==0) { // If i didn't find the event anywhere I add it
                $n_id = RepUserSubmissions::add($link, $type_id);
                if ($n_id > 0) {
                    $outcome = 1;
                }
            }
        }
    }
}
finally{
    echo $outcome;
}
?>
