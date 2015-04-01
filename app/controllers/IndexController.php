<pre>
<?php
/**
 * Created by PhpStorm.
 * User: nextlevelshit
 * Date: 31.03.15
 * Time: 20:13
 */

error_reporting(E_ALL);


//require_once("ApplicationController.php");


class IndexController extends ApplicationController {

    /**
     *
     */

    function showUsers() {
        return $this->getUsers();
    }

    function showUserById($userId) {
        return $this->getUserById($userId);
    }

    function showDailyshitByUserId($userId) {
        return $this->getDailyShitByUserId($userId);

    }
}

$controller = new IndexController();


$output = array();


foreach($controller->getUsers() as $user) {
    $output[] = $controller->getUserById($user['userId']);
//    $controller->showDailyshitByUserId($user['userId']);
}

echo $controller->parseOutput($output);