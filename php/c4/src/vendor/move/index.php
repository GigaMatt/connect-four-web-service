<?php
require "/Users/samueltinevra/Documents/school/Programming L/pl-labs/php/c4/src/vendor/autoload.php";
//initializing DB
Parse\ParseClient::initialize( "myAppId", null, "myMasterKey");
Parse\ParseClient::setServerURL('https://c4plserver.herokuapp.com/','parse');

$pid = $_GET['pid'];
$move = $_GET['move'];

$query = new ParseQuery("GameSession");

try {
    $gameInfo = $query->equalTo("pid", $pid);
    //update the board with player move
    $gameInfo->set("row", $move);
    $board = $gameInfo->get('board');

    for ($row = 6; $row >= 0; $row--) {
        if($board[$row][$move] == ""){
            $board[$row][$move] = "B";
        }
    }
    //check if player won
    checker("B",$board);

    //call the move of the AI
    //update the board with AI move
    for ($row = 6; $row >= 0; $row--) {
        if($board[$row][3] == ""){
            $board[$row][3] = "R";
        }
    }
    //check if AI won
    checker("R",$board);

    $gameInfo->add("row", 3);
    $gameInfo->get('move');
    $gameInfo -> save();
  } catch (ParseException $ex) {
    echo 'error';
  }
$data = $query->find();
//==============================================================
function winner($board){
    if(lineChecker($row,$col)){
        return true;
    }
    if(lineChecker($row,$col)){

    }
    if(vertChecker){

    }
}


function checker($player,$board){

    // horizontalCheck 
    for ($j = 0; $j<6-3 ; $j++ ){
        for ($i = 0; $i<7; $i++){
            if ($board[$i][$j] == $player && $board[$i][$j+1] == $player && $board[$i][$j+2] == $player && $board[$i][$j+3] == $player){
                return true;
            }           
        }
    }
    // verticalCheck
    for ($i = 0; $i<7-3 ; $i++ ){
        for ($j = 0; $j<6; $j++){
            if ($board[$i][$j] == $player && $board[$i+1][$j] == $player && $board[$i+2][$j] == $player && $board[$i+3][$j] == $player){
                return true;
            }           
        }
    }
    // ascendingDiagonalCheck 
    for ($i=3; $i<7; $i++){
        for ($j=0; $j<6-3; $j++){
            if ($board[$i][$j] == $player && $board[$i-1][$j+1] == $player && $board[$i-2][$j+2] == $player && $board[$i-3][$j+3] == $player){
                return true;
            }
        }
    }
    // descendingDiagonalCheck
    for ($i=3; $i<7; $i++){
        for ($j=3; $j<6; $j++){
            if ($board[$i][$j] == $player && $board[$i-1][$j-1] == $player && $board[$i-2][$j-2] == $player && $board[$i-3][$j-3] == $player)
                return true;
        }
    }
    return false;
}

?>