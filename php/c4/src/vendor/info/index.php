<?php
$info = new \stdClass();
$info->width = 7;
$info->height = 6;
$info->strategies = [                            //another way to do it
    "Smart","Random"
];
echo json_encode($info); 
?> 
