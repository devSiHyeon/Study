
<?php  require_once "./header.php";
    $idx    = $_GET['idx'];            // 댓글의 idx 
    $sql    = "SELECT * FROM reply WHERE idx = $idx";
    $result = mysqli_query($db, $sql);
    $row    = mysqli_fetch_assoc($result);
    
    if($_SESSION['user_id']){       // 대댓글 작성할 user_id
?>     

    <h3>댓글 내용</h3>
        작성자 : <label name="reply_id"><?=$row['user_id'];?></label><br>
        댓글 내용 : <label name="content"><?=$row['content'];?></label>
    <h3>작성</h3>
    <form name='create_process' action='r_create_process.php' method='POST'>
        <input type="hidden" name = "reply_idx" value="<?=$idx?>">
        <label name="user_id"><?=$_SESSION['user_id'];?></label>
        <textarea name="reply" style="width:200px;height:20px;"></textarea>
        <input type="submit" value="작성">
    </form>
<?php }?>
