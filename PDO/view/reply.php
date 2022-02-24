<?php  require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');
    $idx    = $_GET['idx'];            // 댓글의 idx 
    $sql    = $db->prepare('SELECT * FROM reply WHERE idx = ?');
    $sql->execute(array($idx));
    $row    = $sql->fetch(PDO::FETCH_ASSOC);
    
    if($_SESSION['user_id']){       // 대댓글 작성할 user_id
?>     
    <h3>댓글 내용</h3>
        작성자 : <label name="reply_id"><?=$row['user_id'];?></label><br>
        댓글 내용 : <label name="content"><?=$row['content'];?></label>
    <h3>작성</h3>
    <form name='create_process' action='../create/reply2.php' method='POST'>
        <input type="hidden" name = "reply_idx" value="<?=$idx?>">
        <label name="user_id"><?=$_SESSION['user_id'];?></label>
        <textarea name="reply" style="width:200px;height:20px;"></textarea>
        <input type="submit" value="작성">
    </form>
<?php 
    } else {
        echo '<script>alert(\'로그인 후 사용 가능합니다\');history.back();</script>';
    }   
    require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php');
?>

