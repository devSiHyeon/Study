<?php
    function pre($a){
        echo '<pre>';
        var_dump($a);
        echo '</pre>';
    }
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    session_start();

$db = mysqli_connect('localhost','se','sesedb79!!','se');

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql        = 'SELECT idx, user_id, user_pw FROM member WHERE user_id = \''.$id.'\'';
$result     = mysqli_query($db, $sql);
$row        = mysqli_fetch_assoc($result) ;
$idx        = $row['idx'] ;
$user_id    = $row['user_id'];
$user_pw    = $row['user_pw'];

if ($id == $user_id && password_verify($pw, $user_pw)){
    $_SESSION['user_id']   = $id;             
    $_SESSION['idx']       = $idx;                 

    $res['success']     = true;
} else {

    $res['success']     = false;
}

exit(json_encode($res));

?>
