<?php
require "/Users/samueltinevra/Documents/school/Programming L/pl-labs/php/c4/src/vendor/autoload.php";
//initializing DB
Parse\ParseClient::initialize( "myAppId", null, "myMasterKey");
Parse\ParseClient::setServerURL('https://c4plserver.herokuapp.com/','parse');

$strategy = $_GET['strategy'];
$pid = uniqid();
$strategies = array("Smart", "Random"); //supported strategies


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

$array = [];


$player["slot"] = 0;
$player["isWin"] = false;
$player["isDraw"] = false;
$player["row"]  = $array;

$ack_move = json_encode($player);
$move = json_encode($player);

if (storeState()){
    $gameInfo = new Parse\ParseObject("GameSession");
    $gameInfo->set("pid", $pid);
    $gameInfo->set("strategy", $strategy);
    $gameInfo->set("ack_move",$ack_move);
    $gameInfo->set("move",$move);
    $gameInfo->set("board", $board);
    $gameInfo->save();
   echo json_encode(array("response" => true, "pid" => $pid));
} else {
   echo createResponse("Failed to store game data");
}

function storeState(){
    return true;
}

?>