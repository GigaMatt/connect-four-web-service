<!-- "new" will make a new game  -->
<?php
$strategy = $_GET['strategy'];
$game= new Game($strategy);
$pid = uniqid();
$file = DATA_DIR . $pid . DATA_EXT;
define('STRATEGY', 'strategy'); // constant
$strategies = array("Smart", "Random"); // supported strategies


// $strategy = new $strategies[$strategy]($board); 

if (storeState($file, json_encode($game))){
   echo json_encode(array("response" => true, PID => $pid));
} else {
   echo createResponse("Failed to store game data");
}

function storeState($file,$game){
    // echo "fuck";
    return true;
}



class Game {
    public $board;
    public $strategy;
    static function fromJsonString($json) {
       $obj = json_decode($json); // instance of stdClass
       $strategy = $obj->{'strategy'};
       $board = $obj->{'board'};
       $game = new Game();
       $game->board = Board::fromJson($board);
       $name = $strategy->{'name'};
       $game->strategy = $name::fromJson($strategy);
       $game->strategy->board = $game->board;
       return $game;
    }
}
 

// $info = new GameInfo(WIDTH,HEIGHT, array_keys($strategies));

// class GameInfo {
//     public $width;
//     public $height;
//     public $strategies;
//     function __construct($width, $height, $strategies) {
//        $this->width= $width;
//        $this->height= $height;
//        $this->strategies= $strategies;
//     }   
// }

 
// abstract class MoveStrategy {
//     var $board;
 
//     function __construct(Board $board = null) {
//        $this->board = $board;
//     }
 
//     abstract function pickSlot();
 
//     function toJason() {
//        return array(‘name’ => get_class($this));
//     }
 
//     static function fromJson($obj) {
//         $strategy = new self();
//         return $strategy;
//     }
// }
 
 


// $new = new \stdClass();
// $new->response = true;
// $new->pid = uniqid();
// echo(json_encode($new));




// if (array_key_exists(STRATEGY, $_GET)) { 
//     /* write code here */ 
//     // echo "fuck1";
//     $strategy = $_GET[STRATEGY];
//     if($strategy == $strategies[0]||$strategy == $strategies[1]){
//         $new->response = true;
//         $new->pid = uniqid();
//         echo(json_encode($new));
//     }
//     exit; 
// }
// else{
//     $new->reason = "Unknown strategy";
//     //echo(json_encode($new));
//     echo "fuck2";


// }

// while (true) {
//     visit http://<c4-home>/play?pid=p&move=x
//     if (ack_move.isWin) {
//         break; // player won
//     } else if (ack_move.isDraw) {
//         break; // draw
//     } else if (move.isWin) {
//         break; // computer won
//     } else if (move.isDraw) {
//         break; // draw
//     }
//  }
?>