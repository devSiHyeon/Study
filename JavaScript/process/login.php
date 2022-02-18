<?php
    session_start();
    // error_reporting( E_ALL );
    // ini_set( "display_errors", 1 );

    function json($result){
        $res['success'] = $result;
        return exit(json_encode($res));
    }

    $id = $_POST['id'];
    $pw = $_POST['pw'];

if (false === ($db = mysqli_connect('localhost','se','sesedb79!!','se'))) return json(0);

$sql        = 'SELECT idx, user_id, user_pw FROM memer WHERE user_id = \''.$id.'\'';
$result     = mysqli_query($db, $sql);

if (false === ($result = mysqli_query($db, $sql))) return json(0);

$row        = mysqli_fetch_assoc($result) ;
$idx        = $row['idx'] ;
$user_id    = $row['user_id'];
$user_pw    = $row['user_pw'];

if ($id == $user_id && password_verify($pw, $user_pw)){
    $_SESSION['user_id']   = $id;             
    $_SESSION['idx']       = $idx;                 

    return json(1);
} else {
    return json(2);
}

?>
