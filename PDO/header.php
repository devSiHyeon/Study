<?php   
    require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/db.php');
    if (isset($_SESSION['user_id']) && strlen($_SESSION['user_id'] == '0')) echo $_SESSION['user_id'] = '';
?> 

<!DOCTYPE html>
<html>
<head>
    <title>PDO</title>
    <style>
        .id_width{
            width:300px;
        }
        ul {
            list-style: none;
        }
        a, a:hover{
            color:black;
            text-decoration:none;
        }
        td{
            border:1px solid gray;
        }
        thead{ background-color:#EAEAEA; text-align:center;}
        .modify{ background-color:#D9E5FF; }
        .delete{ background-color:#FFD8D8; }
        #main {
            width:100%;
            height:30px;
            font-size:20px; 
            background-color:#FFE08C;
        }
        .sub1, .sub2{width:50%; float:left;}
        .sub2 {text-align:right;}
        .btn_modify{width:300px; text-align:right;}
    </style>
    
</head> 
<body>
<?php 
    if( isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0){
?>
    <div id='main'>
        <div class='sub1'><a href='/pdo/index.php'>메인화면</a> </div>
        <div class='sub2'><?=$_SESSION['user_id']?>님 / <a href='/pdo/process/logout.php'> 로그아웃</a></div>
    </div>
<?php } ?>