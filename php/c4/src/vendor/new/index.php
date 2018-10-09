<?php
require "/Users/samueltinevra/Documents/school/Programming L/pl-labs/php/c4/src/vendor/autoload.php";
//initializing DB
Parse\ParseClient::initialize( "myAppId", null, "myMasterKey");
Parse\ParseClient::setServerURL('https://c4plserver.herokuapp.com/','parse');



$strategy = $_GET['strategy'];
$pid = uniqid();
$file = DATA_DIR . $pid . DATA_EXT;
define('STRATEGY', 'strategy'); // constant
$strategies = array("Smart", "Random"); //supported strategies


// $myObj->zero = ['','','','','','',''];
// $myObj->one = ['','','','','','',''];
// $myObj->two = ['','','','','','',''];
// $myObj->three=['','','','','','',''];
// $myObj->four =['','','','','','',''];
// $myObj->five =['','','','','','',''];
$myObj = array
  (
  array('','','','','','',''),
  array('','','','','','',''),
  array('','','','','','',''),
  array('','','','','','',''),
  array('','','','','','',''),
  array('','','','','','',''),
  );

$board = json_encode($myObj);

if (storeState()){
    //saving the new game into DB
    $gameInfo = new Parse\ParseObject("GameSession");
    $gameInfo->set("pid", $pid);
    $gameInfo->set("strategy", $strategy);
    $gameInfo->set("board", $board);
    $gameInfo->save();
    //responding to call
    echo json_encode(array("response" => true, PID => $pid));
} else {
   echo createResponse("Failed to store game data");
}

function storeState(){
    // echo "fuck";
    return true;
}

?>