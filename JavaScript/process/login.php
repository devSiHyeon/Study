<?php
    session_start();
    // error_reporting( E_ALL );
    // ini_set( "display_errors", 1 );

    function json($result){
        $res['result'] = $result;
        return exit(json_encode($res));
    }

    $id = $_POST['id'];
    $pw = $_POST['pw'];

    // 아이디, 비밀번호 자리수 확인
    if (strlen ($id) < 4 ) return json(id);
    if (strlen ($pw) < 8 ) return json(pw);
    
    // DB 연결 확인
    if (false === ($db = mysqli_connect('localhost','se','sesedb79!!','se'))) return json(0);
    
    // sql query 확인
    $sql        = 'SELECT idx, user_id, user_pw FROM member WHERE user_id = \''.$id.'\'';
    if (false === ($result = mysqli_query($db, $sql))) return json(2);
    $row        = mysqli_fetch_assoc($result) ;
    $idx        = $row['idx'] ;
    $user_id    = $row['user_id'];
    $user_pw    = $row['user_pw'];

    // 비밀번호 확인
    if ($id == $user_id && password_verify($pw, $user_pw)){
        $_SESSION['user_id']   = $id;             
        $_SESSION['idx']       = $idx;   
        return json(1);
    } else {
        return json(2);
    }

?>
