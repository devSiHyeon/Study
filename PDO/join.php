<?php 
    require_once "../db.php";
    
    // 값 가져오기
    $user_id    = $_POST['user_id'];
    $pw         = $_POST['user_pw'];
    $user_name  = $_POST['user_name'];
    $user_phone = $_POST['user_phone'];

    $user_pw    = password_hash( $pw, PASSWORD_DEFAULT);

    // 회원정보 insert 
    $sql = $db->prepare('INSERT INTO member ( user_id,user_pw, created_time) VALUES (?,?,NOW())');
    $sql->execute(array($user_id,$user_pw));
    $last_idx = $db->lastInsertId();

    // 회원정보 detail insert
    $sql_detail = $db->prepare('INSERT INTO member_detail (member_idx, user_name, user_phone, created_time) VALUES (?,?,?,NOW())');          
    $sql_detail->execute(array($last_idx,$user_name,$user_phone));
    
    $count=$sql_detail->rowCount();

    // 결과값 안내
    if($count>0){
        echo "<script> alert('회원가입 완료');</script>";
    } else {
        echo "<script> alert('회원가입 오류');</script>";
    }
    echo "<script> location.href='../index.php'; </script>";
?> 
