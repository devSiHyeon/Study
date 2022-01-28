<?php require_once ('./DB.php');
    $idx    = $_GET['idx'];

    // 로그인 확인 sql
    $sql_m    = "SELECT `user_id`, detail_idx FROM reply WHERE idx = '$idx'";
    $result_m = mysqli_query($db, $sql_m);
    $row_m    = mysqli_fetch_assoc($result_m);

    // 로그인 확인
    if(!$_SESSION['user_id']){
        echo '<div style="width:300px;font-size:13px;border:solid 1px gray;text-align:center;"><a href="./">로그인</a>이 필요한 항목입니다.</div><br>';
    }

    // 로그인 아이디 == 댓글 아이디 일치 여부
    if($_SESSION['user_id'] != $row_m['user_id']){
        echo '<script>alert ("삭제할 권한이 없습니다");history.back();</script><br>';
    } else {
        // 댓글에 대댓글 있는지 확인 sql
        $sql    = "SELECT idx, `user_id` FROM reply WHERE reply_idx = '$idx'";
        $result = mysqli_query($db, $sql);
        $row    = mysqli_fetch_assoc($result);
        
        if($row){
            echo "하위 댓글로 인하여 삭제 할 수 없습니다";
        } else {
            $sql_d      = "DELETE FROM reply WHERE idx = '$idx'";
            $result_d   = mysqli_query($db, $sql_d);
            if($result_d){
                echo '<script>alert ("삭제 완료");location.href=\'./b_view.php?idx='.$row_m['detail_idx'].'\';</script>';
            } else {
                echo '<script>alert ("삭제 오류");history.back();</script><br>';
            }
        }
    }
?>
