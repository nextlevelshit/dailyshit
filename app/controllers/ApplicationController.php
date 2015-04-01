<?php
/**
 * Created by PhpStorm.
 * User: nextlevelshit
 * Date: 30.03.15
 * Time: 20:34
 */

error_reporting(E_ALL);


class ApplicationController {

    var $pdo;

    function __construct() {
        $this->connect();
    }

    function connect() {
//        require_once("../models/ConnectModal.php");
        $db['host']     = "localhost";
        $db['database'] = "dailyshit";
        $db['username'] = "dailyshit";
        $db['password'] = "LTAn5WbhLEDewmFx";

        $this->pdo = new PDO("mysql:host=".$db['hostname'].";dbname=".$db['database'].";charset=utf8", $db['username'], $db['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @param $output
     * @return mixed
     */

    function parseOutput($output) {
        if(is_array($output)) {
//            echo $this->jsonToReadable(json_encode($output));
            return json_encode($output);
        } else {
            return $output;
        }
    }

    /**
     * @description Fetch PDO results
     * @param $statement
     * @return mixed
     */

    function prepareOutput($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function prepareOutputSingle($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    /**
     * @description Parse JSON output readable for humans
     * @param $json
     * @return string
     */

    function jsonToReadable($json){
        $tc = 0;        //tab count
        $r = '';        //result
        $q = false;     //quotes
        $t = "\t";      //tab
        $nl = "\n";     //new line

        for($i=0;$i<strlen($json);$i++){
            $c = $json[$i];
            if($c=='"' && $json[$i-1]!='\\') $q = !$q;
            if($q){
                $r .= $c;
                continue;
            }
            switch($c){
                case '{':
                case '[':
                    $r .= $c . $nl . str_repeat($t, ++$tc);
                    break;
                case '}':
                case ']':
                    $r .= $nl . str_repeat($t, --$tc) . $c;
                    break;
                case ',':
                    $r .= $c;
                    if($json[$i+1]!='{' && $json[$i+1]!='[') $r .= $nl . str_repeat($t, $tc);
                    break;
                case ':':
                    $r .= $c . ' ';
                    break;
                default:
                    $r .= $c;
            }
        }
        return $r;
    }

    /**
     * @param $userId
     * @return mixed
     */

    function getUserById($userId) {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE userId=$userId");
        return $this->prepareOutputSingle($stmt);
    }

    /**
     * @description Get all users sorted by userName ascending
     * @return mixed
     */

    function getUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY userName ASC");
        return $this->prepareOutput($stmt);
    }

    /**
     * @description Get dailyshit be userId
     * @param $userId
     * @return mixed
     */

    function getDailyshitByUserId($userId) {
        $stmt = $this->pdo->query("SELECT * FROM dailyshit WHERE userId=$userId");
        return $this->prepareOutput($stmt);
    }
}