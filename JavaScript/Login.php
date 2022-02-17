<?php
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    session_start();
?>

<!DOCTYPE html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="./Login.js"></script>
    <script type="text/javascript" src="./Logout.js"></script>
</head>
<body>
    <?php 
    
        if (isset($_SESSION['user_id']) && strlen($_SESSION['user_id'] == '0')) echo $_SESSION['user_id'] = '';
        if (isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0) {
    ?>
        <?= $_SESSION['user_id']?> 님 환영합니다.
        <form name="logout_form" action="./Logout.php" method="POST">
            <button type="button" name='logout_btn'>로그아웃 </button>
        <form>
    <?php            
        } else {
    ?>
    ▶ 로그인<br>
    <form name="login_form" action="./Login.php" method="POST">
        id <input type="text" name="user_id" value="">
        pw <input type="password" name="user_pw" value="">
        <input type="button" name='login_btn' value="Login">
    </form>
    
    <?php            
        } 
    ?>
     
</body>
</html>
