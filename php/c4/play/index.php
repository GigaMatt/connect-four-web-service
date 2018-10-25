<?php
$URL= dirname(dirname(__FILE__))."/files/";
$pid =  $_GET["pid"];
define('SLOT', $_GET["move"]);
class res{}
$res= new res();
$res->response=false;

if($pid == ""){

    $res->reason = "pid not specified";
    echo json_encode($res);

    exit();
} else if(SLOT == ""){

    $res->reason = "Move not specified";
    echo json_encode($res);
    exit();

} else if(SLOT > 6){

    $res->reason = "Invalid slot, ".SLOT;
    echo json_encode($res);
    exit();

}

$file = file_get_contents($URL.$pid.".txt") or exit(json_encode(array("response"=>false, "reason"=>"Unkown $pid")));

$rec = json_decode($file);

$board = &$rec->board;

arc();

$board_Desc = fopen($URL.$pid.".txt", "w");
$desc = json_encode($rec);
fwrite($board_Desc, $desc);
fclose($board_Desc);
echo json_encode($res);

function placePice($pieces){
    if(empty($pieces)){
        return false;
    }
    global $board;
    for($x=0; $x<count($board[0]); $x++){
        for($y=count($board)-1; $y>=0; $y--){
            if($board[$y][$x]==0){
                return false;
            }
        }
    }
    return true;
}

function play($turn, $slot){
    if($slot==-1){
        return false;
    }
    global $board;
    for ($y = count($board)-1; $y >= 0; $y--) {
        if($board[$y][$slot]==0){
            $board[$y][$slot]= $turn;
            return true;
        }
    }
    return false;
}

function arc(){
    global $rec;
    global $res;
    $res->response= play(1, (int)SLOT);
    $res->ack_move= cheking(1, (int)SLOT);

    $slot;
    if($res->ack_move["isWin"]){
        $slot=-1;
    } else if($rec->strategy=="Smart"){
        $slot= randomAI();
    } else if($rec->strategy=="Random"){
        $slot= randomAI();
    }
    if(!play(2, $slot)){
        $slot= randomAI();
        play(2, $slot);
    }
    $res->move= cheking(2, $slot);
}

function marks($turn){
    global $board;
    for($x=0; $x<count($board[0]); $x++){
        for($y=count($board)-1; $y>=0; $y--){
            if($board[$y][$x]==$turn){
                if(next1($turn, $x-1, $y-1, "UL", 1, "marks")==4){return array($x,$y, $x-1,$y-1, $x-2,$y-2, $x-3,$y-3);
                } else if(next1($turn, $x, $y-1, "U", 1, "marks")==4){return array($x,$y, $x,$y-1, $x,$y-2, $x,$y-3);
                } else if(next1($turn, $x+1, $y-1, "UR", 1, "marks")==4){return array($x,$y, $x+1,$y-1, $x+2,$y-2, $x+3,$y-3);
                } else if(next1($turn, $x+1, $y, "R", 1, "marks")==4){return array($x,$y, $x+1,$y, $x+2,$y, $x+3,$y);
                }
            }
        }
    } return array();
}

function cheking($turn, $slot){
    $pieces = array();

    if($slot != -1){

        $pieces = marks($turn);
    }return array("slot"=> $slot,"isWin"=> (!empty($pieces)), "placePice"=>placePice($pieces), "row"=>$pieces);
}

function randomAI(){
    $rand= rand(0,6);
    global $board;
    while($board[0][$rand]!=0){$rand= rand(0,6);}return $rand;
}

function next1($turn, $x, $y, $dir, $counter, $purpose){
    global $board;
    if($counter==4 || $x==-1 || $y==-1 || $x==7 || $y==6){return $counter;}
    if(($purpose=="block" || $purpose=="win" ) && $counter==3){$turn=0;}
    if($board[$y][$x]==$turn){
        if($dir=="UL"){return next1($turn, $x-1, $y-1, $dir, $counter+1, $purpose);
        } else if($dir=="U"){return next1($turn, $x, $y-1, $dir, $counter+1, $purpose);
        } else if($dir=="UR"){return next1($turn, $x+1, $y-1, $dir, $counter+1, $purpose);
        } else if($dir=="R"){return next1($turn, $x+1, $y, $dir, $counter+1, $purpose);
        } else if($dir=="L"){return next1($turn, $x-1, $y, $dir, $counter+1, $purpose);
        } else if($dir=="DR"){return next1($turn, $x+1, $y+1, $dir, $counter+1, $purpose);
        } else if($dir=="DL"){return next1($turn, $x-1, $y+1, $dir, $counter+1, $purpose);
        }}return $counter;
}




?>