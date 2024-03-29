<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Venue.php';
require_once __DIR__ . '/RepLocation.php';

Class RepVenue
{
    // Public Methods {{{
    public static function GetList()
    {
        $conn=getConn();      
        if (!($res = $conn->query("CALL VenueGetList()"))) {
            throw new Exception(
                "CALL failed: (" . $conn->errno . ") " . $conn->error
            );
        }
        $ret=array();
        while ($venueRow = $res->fetch_assoc()) {
            $ret[]=self::_venueFromRow($venueRow);
        }
        return $ret;
    }

    public static function getById($id)
    {
        $conn=getConn();
        $sel=$conn->prepare("CALL VenueGetById(?)");
        $sel->bind_param('i', $id);
        $sel->execute();
        $res=$sel->get_result();
        if ($res->num_rows>0) { $loc=$res->fetch_assoc(); return self::_venueFromRow($loc); }
        return null;
    }

    // public static function getByFbLink($query)
    // {
    //     $conn=getConn();
    //     $sel=$conn->prepare("CALL VenueGetByFbLink(?)");
    //     $sel->bind_param('s', $query);
    //     $sel->execute();
    //     $res=$sel->get_result();
    //     if ($res->num_rows>0) {
    //         $loc=$res->fetch_assoc();
    //         return self::_venueFromRow($loc); 
    //     }
    //     return null;
    // }

    public static function getByFbId($fbId)
    {
        $conn=getConn();
        $sel=$conn->prepare("CALL VenueGetByFbId(?)");
        $sel->bind_param('i', $fbId);
        $sel->execute();
        $res=$sel->get_result();
        if ($res->num_rows>0) {
            $loc=$res->fetch_assoc();
            return self::_venueFromRow($loc); 
        }
        return null;
    }

    public static function getByName($name)
    {
        throw new Exception("Not implemented.");
    }

    // public static function add($venue)
    // {
    //     $conn=getConn();      
    //     $ins=$conn->prepare("CALL VenueAdd(?,?,?,?,?,?,?,?,?,?,@newId)");
    //     $ins->bind_param(
    //         'dsisssssss', 
    //         $venue->fbId,
    //         $venue->name,
    //         $venue->location,
    //         $venue->website,
    //         $venue->fbPage,
    //         $venue->logo,
    //         $venue->picture,
    //         $venue->description,
    //         $venue->phone,
    //         $venue->email
    //     );
    //     $ins->execute();
    //
    //     $sel=$conn->query('SELECT @newId');
    //     $newId=$sel->fetch_assoc();
    //     return $newId["@newId"];
    // }

    public static function mod()
    {
        throw new Exception("Not implemented.");
    }
    // }}}

    // Private Methods {{{
    private static function _venueFromRow($row)
    {
        $ret = new Venue();
        $ret->id=$row["id"];
        $ret->fbId=$row["fb_id"];
        $ret->diceId=$row["dice_id"];
        $ret->name=$row["name"];
        $ret->website=$row["website"];
        $ret->logo=$row["logo"];
        $ret->picture=$row["picture"];
        $ret->description=$row["description"];
        $ret->phone=$row["phone"];
        $ret->email=$row["email"];
        $ret->venue_type_id=$row["venue_type_id"];
        if($ret->venue_type_id!=2) :
            $ret->location=RepLocation::getById($row["location_id"]);
        endif;
        $ret->providerId=$row["provider_id"];
        return $ret;
    }
    // }}}
}
?>
