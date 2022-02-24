<?php
    session_start();
    $_SESSION['user_id']    = '';
    $_SESSION['idx']        = '';
    // session_destroy();

    echo "<script>location.href='../index.php';</script>";
?>