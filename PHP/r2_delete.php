<?php require_once ('./DB.php');
    $idx    = $_GET['idx'];

    // 로그인 확인 sql
    $sql_m    = "SELECT `user_id`, detail_idx FROM reply_2 WHERE idx = '$idx'";
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
        $sql    = "SELECT idx, `user_id`  FROM reply_2 WHERE reply_idx = '$idx'";
        $result = mysqli_query($db, $sql);
        $row    = mysqli_fetch_assoc($result);
        
        if($row){
            echo '<script>alert ("하위 댓글로 인하여 삭제 할 수 없습니다");history.back();</script>';
        } else {
            // 현재 댓글의 순위 찾기
            $sql_s      = 'SELECT reply_rank, detail_idx FROM reply_2 WHERE  idx = \''.$idx.'\'';
            $result_s   = mysqli_query($db, $sql_s);
            $row_s      = mysqli_fetch_assoc($result_s);

            // 현재 댓글 순위보다 큰 값 '-1' 적용
            $sql_u      = 'SELECT idx, reply_rank FROM reply_2 ORDER BY reply_rank ASC';
            $result_u   = mysqli_query($db,$sql_u);

            while($row_u = mysqli_fetch_assoc($result_u)){
                if($row_s['reply_rank'] < $row_u['reply_rank']){
                    $idx_u  = $row_u['idx'];
                    $rank   = $row_u['reply_rank'] -1;
                    $sql_up = 'UPDATE reply_2 SET reply_rank = \''.$rank.'\' WHERE idx = \''.$idx_u.'\'';
                    $result_up = mysqli_query($db, $sql_up);
                }
            }
            $sql_d      = "DELETE FROM reply_2 WHERE idx = '$idx'";
            $result_d   = mysqli_query($db, $sql_d);
            
            if($result_d){
                echo '<script>alert ("삭제 완료");location.href=\'./r2_view.php?idx='.$row_s['detail_idx'].'\';</script>';
            } else {
                echo '<script>alert ("삭제 오류");history.back();</script><br>';
            }
        }
    }
?>
