<?php    
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // 세션 시작 
    session_start();

    // 함수사용  
    $host="localhost";
    $user="se";
    $pass="sesedb79!!";
    $dbName="se";

    false === ($db=new PDO ('mysql:host='.$host.';dbname='.$dbName.'', $user, $pass));
    // echo (false === ($db=new PDO ('mysql:host='.$host.';dbname='.$dbName.'', $user, $pass))) ? 'DB 오류' : 'DB 연결';
    
    function pre ($arr){
        echo "<pre>"; 
        var_dump($arr);
        echo "</pre>"; 
    }        
    // rename('/home/se/public_html/pdo/DB.php');
    // unlink('/home/se/public_html/pdo/db.php');
?>