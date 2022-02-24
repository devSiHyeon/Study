<?php require_once ("/home/se/public_html/pdo/db.php");

$idx        = $_POST['board_idx'];     // 게시판 본문 idx
$content    = $_POST['reply'];       // 댓글 내용
$user_id    = $_SESSION['user_id'];    // 댓글 작성자 id

$sql = $db->prepare('INSERT INTO reply(`detail_idx`, `reply_idx`,`reply_no`, `user_id`, `content`, `created_time`) VALUES(?,?,?,?,?, NOW())');

if($sql -> execute(array($idx, 0, 0,$user_id,$content))){ 
    $last = $db->lastInsertId();
    $sql_b = $db->prepare('SELECT detail_idx FROM reply WHERE idx = ?');
    $sql_b -> execute(array($last));
    $row_b = $sql_b->fetch(PDO:: FETCH_ASSOC);
    echo '<script>alert ("댓글 작성 완료");location.href=\'../view/member.php?idx='.$row_b['detail_idx'].'\';</script>';
} else {
    echo '<script>alert ("댓글 작성 오류");history.back();</script><br>';
}
?>