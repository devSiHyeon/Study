<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/db.php');
    $idx    = $_GET['idx'];

    // 로그인 확인 sql
    $sql_m = $db->prepare('SELECT `user_id`, detail_idx FROM reply WHERE idx = ?');
    $sql_m ->execute(array($idx));
    $row_m = $sql_m->fetch(PDO:: FETCH_ASSOC);

    // 로그인 확인
    if(!$_SESSION['user_id']){
        echo '<div style="width:300px;font-size:13px;border:solid 1px gray;text-align:center;"><a href="../index.php">로그인</a>이 필요한 항목입니다.</div><br>';
    }

    // 로그인 아이디 == 댓글 아이디 일치 여부
    if($_SESSION['user_id'] != $row_m['user_id']){
        echo '<script>alert ("삭제할 권한이 없습니다");history.back();</script><br>';
    } else {
        // 댓글에 대댓글 있는지 확인 sql
        $sql = $db->prepare('SELECT idx, `user_id` FROM reply WHERE reply_idx = ?');
        $sql -> execute(array($idx));
        $row = $sql->fetch(PDO:: FETCH_ASSOC);
        
        if($row){
            echo '<script>alert ("하위 댓글로 인하여 삭제 할 수 없습니다");history.back();</script>';
        } else {
            $sql_d = $db-> prepare('DELETE FROM reply WHERE idx = ?');
            if($sql_d -> execute(array($idx))){
                echo '<script>alert ("삭제 완료");location.href=\'../view/member.php?idx='.$row_m['detail_idx'].'\';</script>';
            } else {
                echo '<script>alert ("삭제 오류");history.back();</script><br>';
            }
        }
    }
?>