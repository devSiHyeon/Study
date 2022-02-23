<?php
    require_once "../db.php";

    $id=$_POST['user_id'];
    $pw=$_POST['user_pw'];

    if ($id && $pw) {
        // 비밀번호 가져오기
        $sql=$db->prepare('SELECT idx, user_id, user_pw FROM member WHERE user_id=?');
        $sql->execute(array($id));
        
        $row=$sql->fetch(PDO::FETCH_ASSOC);
        $member_idx = $row['idx'];
        $user_id = $row['user_id'];
        $user_pw = $row['user_pw'];
                
        // 로그인 결과
        if($id == $user_id && password_verify ($pw, $user_pw)){

            echo $_SESSION['user_id']= $id;             
            echo $_SESSION['idx']    = $member_idx;             
            echo "<script> alert('로그인 완료'); </script>";
            
        } else {
            echo "<script> alert('회원정보 오류'); </script>";
        }
    }
    echo "<script> location.href='../index.php'; </script>";

?> 
