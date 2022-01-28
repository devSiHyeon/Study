<?php require_once "./header.php";

$idx        = $_GET['idx'];             // 메인 댓글 내용idx

$sql    = "SELECT reply_idx, user_id, content FROM reply WHERE idx = '$idx'";
$result = mysqli_query($db, $sql);
$row    = mysqli_fetch_assoc($result);

// 로그인 확인
if(!$_SESSION['user_id']){
    echo '<div style="width:300px;font-size:13px;border:solid 1px gray;text-align:center;">댓글 작성은 <a href="./">로그인</a> 후에 작성됩니다 </div><br>';
}

// 로그인 아이디 == 댓글 아이디 일치 여부
if($_SESSION['user_id'] != $row['user_id']){
    echo '<script>alert ("수정할 수 없는 댓글입니다");history.back();</script><br>';
} else {
    
    ?>
    <h3>댓글 수정</h3>
    <form name = "reply_update" action="r_update_process.php" method="POST">
        
        <input type="hidden" name="reply_idx" value="<?=$idx?>">
        아이디 : <label name = "user_id"><?=$S_user_id?></label><br>
        내용 : <input name = "content" value="<?=$row['content']?>"><br>
        <input type="submit" value="수정">
        <input type="button" onclick="history.back()" value="이전">
    </form>

<?php
}?>
