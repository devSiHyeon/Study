<?php 
    require_once "./header.php";
    include "./function.php";

    $idx    = $_GET['idx'];
    $sql    = "SELECT `user_id`, `user_name`, `user_phone` FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx WHERE member_idx = $idx";
    $result = mysqli_query($db, $sql);
    $row    = mysqli_fetch_assoc($result);
    if ( NULL == $row ) {
        echo "<script>location.href='./board_list_3.php'</script>";
    }
?>
<h3>회원수정</h3>
<form action="./b_modifyProcess.php" method="POST">
<input type="hidden" value="<?=$idx?>" name="idx">
    아이디 : <?=$row['user_id'];?><br>
    비밀번호 : <input type="password" name="user_pw"><br>
    이름 : <input type="text" name="user_name" value="<?=$row['user_name'];?>"><br>
    연락처 : <input type="text" name="user_phone" value="<?=$row['user_phone'];?>"><br><br>

    <a href="./board_list_3.php">목록 </a>
    <input type="button" onclick="history.back()" value="이전">
    <input type="submit" value="수정">
</form>
