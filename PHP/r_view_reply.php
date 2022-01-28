<?php require_once ("./DB.php");

$idx        = $_POST['board_idx'];     // 게시판 본문 idx
$content    = $_POST['reply'];       // 댓글 내용
$user_id    = $_SESSION['user_id'];    // 댓글 작성자 id

$sql    = "INSERT INTO reply(`detail_idx`, `reply_idx`,`reply_no`, `user_id`, `content`, `created_time`) VALUES('$idx', '0', '0','$user_id','$content', NOW())";
$result = mysqli_query($db, $sql);
$last   = mysqli_insert_id($db);

if($result){
    $sql_b    = "SELECT detail_idx FROM reply WHERE idx = '".$last."'";
    $result_b = mysqli_query($db, $sql_b);
    $row_b    = mysqli_fetch_assoc($result_b);
    echo '<script>alert ("댓글 작성 완료");location.href=\'./b_view.php?idx='.$row_b['detail_idx'].'\';</script>';
} else {
    echo '<script>alert ("댓글 작성 오류");history.back();</script><br>';
}
?>
