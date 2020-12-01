<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Band.php';

Class RepBand
{
    // Public Methods {{{
    public static function GetList()
    {
        $conn=getConn();      
        if (!($res = $conn->query("CALL BandGetList()"))) {
            throw new Exception(
                "CALL failed: (" . $conn->errno . ") " . $conn->error
            );
        }
        $ret=array();
        while ($bandRow = $res->fetch_assoc()) {
            $ret[]=self::_bandFromRow($bandRow);
        }
        return $ret;
    }

    public static function getById($id)
    {
        $conn=getConn();
        $sel=$conn->prepare("CALL BandGetById(?)");
        $sel->bind_param('i', $id);
        $sel->execute();
        $res=$sel->get_result();
        if ($res->num_rows>0) {
            $loc=$res->fetch_assoc();
            return self::_bandFromRow($loc); 
        }
        return null;
    }

    public static function getByFbId($fbId)
    {
        $conn=getConn();
        $sel=$conn->prepare("CALL BandGetByFbId(?)");
        $sel->bind_param('i', $fbId);
        $sel->execute();
        $res=$sel->get_result();
        if ($res!=null && $res->num_rows>0) {
            $loc=$res->fetch_assoc();
            return self::_bandFromRow($loc); 
        }
        return null;
    }

    public static function getByName($name)
    {
        $conn=getConn();
        $sel=$conn->prepare("CALL BandGetByName(?)");
        $sel->bind_param('s', $name);
        $sel->execute();
        $res=$sel->get_result();
        if ($res->num_rows>0) {
            $loc=$res->fetch_assoc();
            return self::_bandFromRow($loc); 
        }
        return null;
    }

    public static function add($band)
    {
        $conn=getConn();      
        $ins=$conn->prepare("CALL BandAdd(?,?,?,?,?,?,?,?,@newId)");
        $ins->bind_param(
            'dsisssssss', 
            $band->fbId,
            $band->name,
            $band->fbPage,
            $band->website,
            $band->logo,
            $band->picture,
            $band->description,
            $band->email
        );
        $ins->execute();

        $sel=$conn->query('SELECT @newId');
        $newId=$sel->fetch_assoc();
        return $newId["@newId"];
    }

    public static function mod()
    {
        throw new Exception("Not implemented.");
    }
    // }}}

    // Private Methods {{{
    private static function _bandFromRow($row)
    {
        $ret = new Band();
        $ret->id=$row["id"];
        $ret->fbId=$row["fb_id"];
        $ret->name=$row["name"];
        $ret->fbPage=$row["fb_page"];
        $ret->website=$row["website"];
        $ret->logo=$row["logo"];
        $ret->picture=$row["picture"];
        $ret->description=$row["description"];
        $ret->email=$row["email"];
        return $ret;
    }
    // }}}
}
?>
