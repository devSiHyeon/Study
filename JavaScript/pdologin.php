<?php
    session_start();
   
    function json($result){
        $res['result'] = $result;
        exit(json_encode($res));
    }

    $id = $_POST['user_id'];
    $pw = $_POST['user_pw'];

    // 아이디, 비밀번호 자리수 확인
    if (strlen ($id) < 4 ) return json('id');
    if (strlen ($pw) < 8 ) return json('pw');
    
    // DB 연결 확인
      $host = 'localhost';
      $name = 'se';
      $user = 'se';
      $pass = 'sesedb79!!'; 
      if (false === ($db = new PDO("mysql:host=$host;dbname=$name",$user,$pass))) return json(0);
    
    // sql query 확인
      $sql = $db -> prepare ('SELECT idx, user_id, user_pw FROM member WHERE user_id = :id');
      $sql -> bindParam(':id', $id);
      $sql -> execute();

    $row = $sql ->fetch(PDO::FETCH_ASSOC) ;    
    $idx = $row['idx'] ;
    $user_id = $row['user_id'];
    $user_pw = $row['user_pw'];
    
    // 비밀번호 확인
    if ($id == $user_id && password_verify($pw, $user_pw)){
        $_SESSION['user_id'] = $id;             
        $_SESSION['idx'] = $idx;   
        return json(1);
    } else {
        return json(2);
    }

?>
