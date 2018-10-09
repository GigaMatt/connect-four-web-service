<?php
require "/Users/samueltinevra/Documents/school/Programming L/pl-labs/php/c4/src/vendor/autoload.php";
//initializing DB
Parse\ParseClient::initialize( "myAppId", null, "myMasterKey");
Parse\ParseClient::setServerURL('https://c4plserver.herokuapp.com/','parse');

$pid = $_GET['pid'];
$move = $_GET['move'];

$query = new Parse\ParseQuery("GameSession");

try {
    $gameScore = $query->equalTo("pid","5bbc398069627");
        $gameInfo = $query->first();
        $board = $gameInfo->get("board");
        echo json_encode($board);

            // //updating the board
            // for ($row = 6; $row >= 0; $row--) {
            //     if($board[$row][$move] == ""){
            //         $board[$row][$move] = "B";
            //     }
            // }
            // $gameInfo -> set('board',$board);
        
            // //saving the board
            // $gameInfo -> save();
        
            // //check if player won
            // if(checker("B",$board)){
            //     $player -> set('isWin',true);
            //     $gameInfo->set('ack_move',$player);
            //     //$gameInfo -> save();
            //     //responding
            //     $res->respose = true;
            //     $res->ack_move = $gameInfo->get('ack_move');
            //     $res->move = $gameInfo->get('move');    
            //     echo(json_encode($res));
            // }
        
            // else{
            //     //update the board with AI move
            //     $random = rand (0,6);
            //     $player2 = $gameInfo->get('move');
               
        
            //     $gameInfo->add("row", $random);
            //     for ($row = 6; $row >= 0; $row--) {
            //         if($board[$row][$random] == ""){
            //             $board[$row][$random] = "R";
            //         }
            //     }
            //     if(checker("R",$board)){
            //         $player2 -> set('isWin',true);
            //         $gameInfo->set('move',$player2);
            //         $gameInfo -> save();
            //         //responding
            //         $res->respose = true;
            //         $res->ack_move = $gameInfo->get('ack_move');
            //         $res->move = $gameInfo->get('move');    
            //         echo(json_encode($res));
            //     }
            // }

} catch (ParseException $ex) {echo"error";}

// try {
//     $gameInfo = $query->equalTo("pid",$pid);
//     $object = $query->first();
//     //$board = $object->get("board");
 
//     //getting the board
//     // $board = $gameInfo->get('move');
//     // echo (json_encode($board));


//     $player = $gameInfo->get('ack_move');
//     $player -> set('slot',$move);
//     $gameInfo -> set('ack_move',$player);
    
//     //updating the board
//     for ($row = 6; $row >= 0; $row--) {
//         if($board[$row][$move] == ""){
//             $board[$row][$move] = "B";
//         }
//     }
//     $gameInfo -> set('board',$board);

//     //saving the board
//     $gameInfo -> save();

//     //check if player won
//     if(checker("B",$board)){
//         $player -> set('isWin',true);
//         $gameInfo->set('ack_move',$player);
//         $gameInfo -> save();
//         //responding
//         $res->respose = true;
//         $res->ack_move = $gameInfo->get('ack_move');
//         $res->move = $gameInfo->get('move');    
//         echo(json_encode($res));
//     }

//     else{
//         //update the board with AI move
//         $random = rand (0,6);
//         $player2 = $gameInfo->get('move');
//         $player2 -> set('slot',$random);

//         $gameInfo->add("row", $random);
//         for ($row = 6; $row >= 0; $row--) {
//             if($board[$row][$random] == ""){
//                 $board[$row][$random] = "R";
//             }
//         }
//         if(checker("R",$board)){
//             $player2 -> set('isWin',true);
//             $gameInfo->set('move',$player2);
//             $gameInfo -> save();
//             //responding
//             $res->respose = true;
//             $res->ack_move = $gameInfo->get('ack_move');
//             $res->move = $gameInfo->get('move');    
//             echo(json_encode($res));
//         }
//     }
//   } catch (ParseException $ex) {
//     echo 'error';
//   }
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