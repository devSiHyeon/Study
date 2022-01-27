<?php require_once ("./DB.php");

$idx        = $_POST['board_idx'];     // 게시판 본문 idx
$content    = $_POST['reply'];       // 댓글 내용
$user_id    = $_SESSION['user_id'];    // 댓글 작성자 id

//$sql    = 'INSERT INTO reply(`detail_idx`, `reply_no`, `user_id`, `created_time`) VALUES(\''.$idx.'\', '0',\''.$user_id.'\',NOW())';
$sql    = "INSERT INTO reply(`detail_idx`, `reply_idx`,`reply_no`, `user_id`, `content`, `created_time`) VALUES('$idx', '0', '0','$user_id','$content', NOW())";
$result = mysqli_query($db, $sql);

?>
