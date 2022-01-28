<?php 
    require_once "./header.php";
    $idx    = $_GET['idx'];
    $sql    = "SELECT `user_id`, `user_name`, `user_phone` FROM member_detail INNER JOIN member ON member_detail.member_idx=member.idx WHERE member_idx = $idx";
    $result = mysqli_query($db, $sql);
    $row    = mysqli_fetch_assoc($result);
    if ( NULL == $row ) {
        echo "<script>location.href='./board_list_3.php'</script>";
    }
?>
<h3>▶ 회원정보</h3>
<?php if($_SESSION['user_id']){?>
    <a href="./logout.php" style="margin-left:400px;">로그아웃</a>
    <?php }?>
<table border="1px">
    <tr>
        <td>아이디</td>
        <td><?=$row['user_id'];?></td>
    </tr>
    <tr>
        <td>이름</td> 
        <td><?=$row['user_name'];?></td>
    </tr>
    <tr>
        <td>연락처</td>
        <td><?=$row['user_phone'];?></td>
    </tr>
</table>

<input type="button" onclick="history.back()" value="이전">
<a href="./b_modify.php?idx=<?=$idx?>">수정</a>


<h3>▶ 댓글</h3>
    <?php if($_SESSION['user_id']){?>
    <form name='reply' action='reply.php' method='POST'>
        <input type="hidden" name = "board_idx" value="<?=$idx?>">
        <label name="user_id"><?=$_SESSION['user_id'];?></label>
        <textarea name="reply" style="width:200px;height:20px;"></textarea>
        <input type="submit" value="작성">
    </form>
    <?php } else { echo '<div style="width:300px;font-size:13px;border:solid 1px gray;text-align:center;">댓글 작성은 <a href="./">로그인</a> 후에 작성됩니다 </div><br>';}?>
    <h4>▶ 댓글목록</h4>
    <ul>
    <?php
        $NO     = 1;
        
        // 최상위 댓글
        $sql    = "SELECT idx,detail_idx,`user_id`, content FROM reply WHERE reply_no = '0' AND detail_idx = '$idx'";
        $result = mysqli_query($db, $sql);
        $replyArr = array();
        
        while ($row = mysqli_fetch_assoc($result)){
    ?>
            <li>
                <?=$NO++;?> ||
                <?=$row['user_id'];?> ||
                <?=$row['content'];?> || 
                <a href="./r_create.php?idx=<?=$row['idx'];?> ">댓글</a>
                <a href="./r_update.php?idx=<?=$row['idx'];?>">수정</a>
                <a href="./r_delete.php?idx=<?=$row['idx'];?>">삭제</a>
            </li>
        <?php 
        // 대댓글 
            $sql    = 'SELECT * FROM reply WHERE reply_idx = \''.$row['idx'].'\'';
            $result2 = mysqli_query($db, $sql);
            while ($row = mysqli_fetch_assoc($result2)){
                $replyArr_2[]= $row;
    ?>
         <li>
            <label style="margin-left:20px;"></label> → <?=$NO++;?> ||
            <?=$row['user_id'];?> ||
            <?=$row['content'];?> || 
            <a href="./r_update.php?idx=<?=$row['idx'];?>">수정</a>
            <a href="./r_delete.php?idx=<?=$row['idx'];?> ">삭제</a>
        </li>
    <?php
            }
        }
?>
       
    
    </ul>
<?php include "./function.php";?>
