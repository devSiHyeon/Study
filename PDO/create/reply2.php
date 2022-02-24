<?php require_once ("/home/se/public_html/pdo/db.php");

// "대댓글";
$idx     = $_POST['reply_idx'];      // 최상단 댓글 내용 idx
$content = $_POST['reply'];          // 대댓글 내용
$user_id = $_SESSION['user_id'];     // 대댓글 작성자 id

$sql_reply= $db->prepare('SELECT detail_idx, reply_no FROM reply WHERE idx = ?');
$sql_reply->execute(array($idx));
$row   =$sql_reply->fetch(PDO::FETCH_ASSOC);
$d_idx = $row['detail_idx'];
$r_no  = $row['reply_no'] + 1;

$sql    = $db->prepare('INSERT INTO reply(`detail_idx`, `reply_idx`, `reply_no`, `user_id`, `content`, `created_time`) VALUES(?,?,?,?,?,NOW())');

if($sql -> execute(array($d_idx, $idx, $r_no,$user_id,$content))){
    $last = $db->lastInsertId();
    $sql_r = $db ->prepare('SELECT detail_idx FROM reply WHERE idx = ?');
    $sql_r -> execute(array($last));
    $row_r = $sql_r -> fetch(PDO::FETCH_ASSOC);
    echo '<script>alert ("댓글 작성 완료");location.href=\'../view/member.php?idx='.$row_r['detail_idx'].'\';</script>';
} else {
    echo '<script>alert ("댓글 작성 오류");</script><br>';
}
?>