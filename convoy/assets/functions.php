<?php
    function getAllFutureConvoys(){
        global $db;
        $query = "SELECT `id`, `location`, `server`, `startdate`, `user` FROM `convoys` WHERE `startdate` > now() ORDER BY `startdate`";
        try 
        {   $stmt = $db->prepare($query); 
            $result = $stmt->execute(); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        return $stmt->fetchAll();
    }
    function createConvoy($user, $start, $server, $date, $description){
        global $db;
        $query = " 
            INSERT INTO `convoys` (`location`, `server`, `startdate`, `description`, `user`) VALUES (:start, :server, :date, :description, :user)
        "; 
        $query_params = array( 
            ':start' => $start,
            ':server' => $server,
            ':date' => $date,
            ':description' => $description,
            ':user' => $user
        ); 
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        $insertNum = $db->lastInsertId();
        return $insertNum;			
    }
    function checkConvoyExists($id){
        global $db;
        $query = "SELECT `id` FROM `convoys` WHERE `id` = :id AND `startdate` > now()";
        $query_params = array(":id" => $id);
        try 
        {   $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        $count = $stmt->rowcount();
        if($count == 1){
            return true;
        } else {
            return false;
        }
    }
    function getConvoyInfo($id, $type){
        global $db;
        $query = "SELECT `location`, `server`, `startdate`, `description`, `user` FROM `convoys` WHERE `id` = :id AND `startdate` > now()";
        $query_params = array(":id" => $id);
        try 
        {   $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        $result = $stmt->fetch();
        switch($type){
            case "user":
                return $result['user'];
                break;
            case "server":
                return $result['server'];
                break;
            case "location":
                return $result['location'];
                break;
            case "description":
                return $result['description'];
                break;
            case "startdate":
                return $result['startdate'];
                break;
        }
    }
    function checkUserAccess($ipRestricted){        
        if($ipRestricted){
            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            include("security.php");
            foreach($ipAddresses as $ips){
                if($ip == $ips) {
                    return true;
                } else {
                    continue;
                }
            }
        } else {
            return true;
        }
    }