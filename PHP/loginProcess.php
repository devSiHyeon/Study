<?php
    require_once "./DB.php";
    //print_r ($db);

    $id   = $_POST['user_id'];
    $pw   = $_POST['user_pw'];

    if ($id && $pw) {

        // password 
        $sql        = "SELECT idx, user_id, user_pw FROM member WHERE user_id = '$id'";
        $result     = $db_2 -> query($sql);
        $user_row   = $result -> fetch_array(MYSQLI_ASSOC);
        $member_idx = $user_row['idx'];
        $user_id    = $user_row['user_id'];
        $user_pw    = $user_row['user_pw'];
        
                
        // login result
        if($id == $user_id && password_verify ($pw, $user_pw)){

            echo $_SESSION['user_id']   = $id;             
            echo $_SESSION['idx']       = $member_idx;             
            echo "<script> alert('로그인 완료'); </script>";
            
        } else {
            echo "<script> alert('회원정보 오류'); </script>";
        }
    }
    echo "<script> location.href='./index.php'; </script>";

?> 
