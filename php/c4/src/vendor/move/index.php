<?php
require "/Users/samueltinevra/Documents/school/Programming L/pl-labs/php/c4/src/vendor/autoload.php";
//initializing DB
Parse\ParseClient::initialize( "myAppId", null, "myMasterKey");
Parse\ParseClient::setServerURL('https://c4plserver.herokuapp.com/','parse');

$pid = $_GET['pid'];
$move = $_GET['move'];
$query = new ParseQuery("GameSession");

try {
    //query the game Session 
    $gameInfo = $query->equalTo("pid", $pid);

    $board = $gameInfo->get('board');
    $gameInfo->add("row", $move);
    
    //updating the board
    for ($row = 6; $row >= 0; $row--) {
        if($board[$row][$move] == ""){
            $board[$row][$move] = "B";
        }
    }
    $gameInfo -> set('board',$board);
    $gameInfo -> save();
    //check if player won
    if(checker("B",$board)){
        //< {"response":true,
        //"ack_move":{"slot":0,"isWin":true,"isDraw":false,"row":[0,2,0,3,0,4,0,5]}}
        echo("won");
    }

    else{
        //call the move of the AI
        //update the board with AI move
        $random = rand ( 0,6);
        $gameInfo->add("row", $random);
        for ($row = 6; $row >= 0; $row--) {
            if($board[$row][$random] == ""){
                $board[$row][$random] = "R";
            }
        }
    }
    //check if AI won
  

    
  } catch (ParseException $ex) {
    echo 'error';
  }
// $data = $query->find();



function checker($player,$board){
    // horizontalCheck 
    for ($j = 0; $j<3 ; $j++ ){
        for ($i = 0; $i<7; $i++){
            if ($board[$i][$j] == $player && $board[$i][$j+1] == $player && $board[$i][$j+2] == $player && $board[$i][$j+3] == $player){
                return true;
            }           
        }
    }
    // verticalCheck
    for ($i = 0; $i<4 ; $i++ ){
        for ($j = 0; $j<6; $j++){
            if ($board[$i][$j] == $player && $board[$i+1][$j] == $player && $board[$i+2][$j] == $player && $board[$i+3][$j] == $player){
                return true;
            }           
        }
    }
    // ascendingDiagonalCheck 
    for ($i=3; $i<7; $i++){
        for ($j=0; $j<3; $j++){
            if ($board[$i][$j] == $player && $board[$i-1][$j+1] == $player && $board[$i-2][$j+2] == $player && $board[$i-3][$j+3] == $player){
                return true;
            }
        }
    }
    // descendingDiagonalCheck
    for ($i=3; $i<7; $i++){
        for ($j=3; $j<6; $j++){
            if ($board[$i][$j] == $player && $board[$i-1][$j-1] == $player && $board[$i-2][$j-2] == $player && $board[$i-3][$j-3] == $player){
                return true;
            }
        }
    }
    return false;
}

?>