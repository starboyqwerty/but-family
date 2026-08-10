<?php
require_once './classes/connect.php';

//Direction table name 
$postid = $_POST['postid'];
//Counter data
$like = $_POST['like'];



if($user_id){
    $query = "SELECT count(likes) FROM `posts` WHERE `postid` = $postid";
    $mark = mysqli_query($connect, $query);
    $mark = mysqli_fetch_row($mark);
}

if($mark[0]){
    $query = "UPDATE `like-counter` SET `like` = $like  WHERE `user_id` = $user_id";
}
else{
    $query = "INSERT INTO `like-counter`(`user_id`, `like`) VALUES($user_id, $like)";
}
//SQL query
mysqli_query($connect, $query);


