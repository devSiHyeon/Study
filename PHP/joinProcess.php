<?php 
    require_once "./DB.php";
    
    // 값 가져오기
    $user_id    = $_POST['user_id'];
    $pw         = $_POST['user_pw'];
    $user_name  = $_POST['user_name'];
    $user_phone = $_POST['user_phone'];

    $user_pw    = password_hash( $pw, PASSWORD_DEFAULT);

    // member insert 
    $sql = "INSERT INTO member ( user_id,user_pw, created_time )
            VALUES ('$user_id', '$user_pw', NOW() )";
    $result = mysqli_query($db, $sql);    
    $last_idx = mysqli_insert_id($db);

    // mmeber detail insert
    $sql_detail = "INSERT INTO member_detail (member_idx, user_name, user_phone, created_time )
                    VALUES ('$last_idx', '$user_name', '$user_phone', NOW() )";          
    
    $result_detail = mysqli_query($db, $sql_detail);

    // result 
    if($result){
        echo "<script> alert('회원가입 완료');  </script>";
    } else {
        echo "<script> alert('회원가입 오류');  </script>";
    }
    echo "<script> location.href='./index.php'; </script>";
?> 
