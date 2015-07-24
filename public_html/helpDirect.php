<?php
session_start();

// index map for context sensitive help
$addUserEM = 1;
$addEvent = 2;
$updateEvent = 3;
$applyAct = 4;
$allocate = 5;
$updateUser = 6;

//get the help context index captured by the users last page
$h = $_SESSION['HC'];
if ($h == $addUserEM) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Add_a_Manager/_Administrator");
} else if ($h == $addEvent) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Add_An_Event/Activity");
} else if ($h == $updateEvent) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Update_a_Event/Activity");
} else if ($h == $applyAct) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Apply_For_An_Activity");
} else if ($h == $allocate) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Allocate/De-allocate_a_volunteer");
} else if ($h == $updateUser) {
    header("Location: http://utsems.wikia.com/wiki/How_to:_Update_User_Details");
} else {
    header("Location: http://utsems.wikia.com/wiki/UTS:_Event_Management_System_Support_Wiki");
}







?>