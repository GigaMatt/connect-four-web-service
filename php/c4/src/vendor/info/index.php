<?php

/** CS 3360: Programming Languages
 * Programming Assignment 1: PHP
 * @author Samuel Tinevra
 * @author Matthew S Montoya
 * @author Yoonsik Cheon
 * Purpose: To practice 
 * Last Modified: 4 October 2018
*/



$info = new \stdClass();
$info->width = 7;
$info->height = 6;
$info->strategies = [                            //another way to do it
    "Smart","Random"
];
echo json_encode($info); 
?> 
