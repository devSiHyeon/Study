<?php require_once ("./DB.php");

echo "대댓글";
$idx        = $_POST['reply_idx'];      // 최상단 댓글 내용 idx
$content    = $_POST['reply'];          // 대댓글 내용
$user_id    = $_SESSION['user_id'];     // 대댓글 작성자 id

$sql_reply      = "SELECT detail_idx, reply_no FROM reply WHERE idx = '$idx'";
$result_reply   = mysqli_query($db, $sql_reply);
$row            = mysqli_fetch_assoc($result_reply);
$d_idx          = $row['detail_idx'];
$r_no           = $row['reply_no'] + 1;

// pre($row);

$sql    = "INSERT INTO reply(`detail_idx`, `reply_idx`, `reply_no`, `user_id`, `content`, `created_time`) 
VALUES('$d_idx', '$idx', '$r_no','$user_id','$content', NOW())";
$result = mysqli_query($db, $sql);

?>
