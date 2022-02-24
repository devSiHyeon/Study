<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/db.php');

$idx        = $_POST['reply_idx'];     // 메인 댓글 본문 idx
$content    = $_POST['content'];             // 댓글 내용
$user_id    = $_SESSION['user_id'];        // 댓글 작성자 id

// 본문 게시판 번호 가져오기
$sql = $db -> prepare('SELECT detail_idx FROM reply WHERE idx = ?');
$sql -> execute(array($idx));
$row = $sql -> fetch (PDO:: FETCH_ASSOC);

// 댓글 내용 수정
$sql_u = $db -> prepare('UPDATE reply SET `content`=?, `updated_time`= NOW() WHERE idx = ?');

if($sql_u -> execute(array($content,$idx))){
    //echo "<script>alert('수정 완료 되었습니다.');history.go(-2);</script>";
    echo '<script>alert(\'수정 완료 되었습니다.\');location.href=\'../view/member.php?idx='.$row['detail_idx'].'\';</script>';
} else {
    echo "<script>alert('수정 오류');history.back();</script>";
}

?>