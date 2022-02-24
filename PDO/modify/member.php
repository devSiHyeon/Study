<?php  require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');

    $idx = $_GET['idx'];
    $sql = $db->prepare('SELECT `user_id`, `user_name`, `user_phone` FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx WHERE member_idx = ?');
    $sql ->execute(array($idx));
    $row = $sql -> fetch(PDO:: FETCH_ASSOC);
    if ( NULL == $row ) {
        echo "<script>location.href='../member.php'</script>";
    }
?>
<h3>회원수정</h3>
<form name='membermodify' action="../modifyProcess/member.php" method="POST">
<input type="hidden" value="<?=$idx?>" name="idx">
    아이디 : <?=$row['user_id'];?><br>
    비밀번호 : <input type="password" name="user_pw" placeholder='변경할 비밀번호'><br>
    이름 : <input type="text" name="user_name" value="<?=$row['user_name'];?>"><br>
    연락처 : <input type="text" name="user_phone" value="<?=$row['user_phone'];?>"><br><br>
    
<?php if ($_SESSION['user_id'] == 'admin123' && strlen($_SESSION['user_id'] > '0')) { ?>
    <label style='color:red;font-size:12px;'>* 회원정보 변경을 위한 관리자 비밀번호를 작성하세요.</label><br>
<?php } else { ?>
    <label style='color:red;font-size:12px;'>* 회원정보 변경하기 위한 기존 비밀번호를 작성하세요.</label><br>
<?php } ?>

    <label style='color:red;font-size:12px;'>비밀번호 확인: </label><input type="password" name="check_pw" require><br><br>
    <a href="../member.php">목록 </a>
    <input type="button" onclick="history.back()" value="이전">
    <input type="submit" value="수정">
</form>