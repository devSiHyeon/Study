<?php require_once ("./DB.php");

$idx        = $_POST['reply_idx'];     // 메인 댓글 본문 idx
$content    = $_POST['content'];             // 댓글 내용
$user_id    = $_SESSION['user_id'];        // 댓글 작성자 id

// 본문 게시판 번호 가져오기
$sql    = "SELECT detail_idx FROM reply_2 WHERE idx = '$idx'";
$result = mysqli_query($db, $sql);
$row    = mysqli_fetch_assoc($result);
// echo $row['detail_idx'];

// 댓글 내용 수정
$sql_u    = "UPDATE reply_2 SET `content`='$content' WHERE idx = '$idx'";
$result_u = mysqli_query($db, $sql_u);

if($result_u){
//    echo "<script>alert('수정 완료 되었습니다.');history.go(-2);</script>";
    echo '<script>location.href=\'./r2_view.php?idx='.$row['detail_idx'].'\';</script>';
} else {
    echo "<script>alert('수정 오류');history.back();</script>";
}

?>
