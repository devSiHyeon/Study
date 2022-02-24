<?php  require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');
    $idx = $_GET['idx'];
    $sql_s = $db->prepare('SELECT `user_id`, `user_name`, `user_phone` FROM member_detail INNER JOIN member ON member_detail.member_idx=member.idx WHERE member_idx = ?');
    $sql_s -> execute(array($idx));
    $row = $sql_s -> fetch(PDO:: FETCH_ASSOC);
    if ( NULL == $row ) {
        echo "<script>location.href='../member.php'</script>";
    }
?>
<h3>▶ 회원정보</h3>
    <table>
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

    <input type="button" onclick="location.href='../member.php'" value="목록">
    <?php if ($_SESSION['user_id'] == 'admin123'){ ?>
        <a href="../modify/member.php?idx=<?=$idx?>" class='modify'>수정</a>
        <a href="../delete/member.php?idx=<?= $list_row['member_idx'];?>" class='delete'>삭제</a>
    <? } ?>

<h3>▶ 댓글</h3>
    <?php if($_SESSION['user_id']){?>
    <form name='reply' action='../create/reply.php' method='POST'>
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
        $reply_NO = 1;
        
        // 최상위 댓글
        $sql_r = $db->prepare('SELECT idx,detail_idx,`user_id`, content FROM reply WHERE reply_no = ? AND detail_idx = ? ORDER BY idx DESC');
        $sql_r -> execute(array(0, $idx));
        
        while ($row = $sql_r -> fetch(PDO::FETCH_ASSOC)){
?>
            <li style="margin-top:10px;">
                <?=$NO++;?>.
                <?=$row['user_id'];?> ||
                <?=$row['content'];?> || 
                <a href="../view/reply.php?idx=<?=$row['idx'];?> ">댓글</a>
                <a href="../modify/reply.php?idx=<?=$row['idx'];?>">수정</a>
                <a href="../delete/reply.php?idx=<?=$row['idx'];?>">삭제</a>
            </li>
<?php 
        // 대댓글 
            $sql_1 = $db->prepare('SELECT * FROM reply WHERE reply_idx = ?');
            $sql_1 -> execute(array($row['idx']));
            while ($row = $sql_1 -> fetch(PDO::FETCH_ASSOC)){
?>
         <li style="font-size:13px;margin-top:10px;">
            <label style="margin-left:20px;"></label> ▶ 
            <?=$row['user_id'];?> ||
            <?=$row['content'];?> || 
            <a href="../create/reply.php?idx=<?=$row['idx'];?> ">댓글</a>
            <a href="../modify/reply.php?idx=<?=$row['idx'];?>">수정</a>
            <a href="../delete/reply.php?idx=<?=$row['idx'];?> ">삭제</a>
        </li>
<?php
            // 대대댓글 
                $sql_2 = $db-> prepare('SELECT * FROM reply WHERE reply_idx = ?');
                $sql_2 -> execute(array($row['idx']));
                while ($row_2 = $sql_2 -> fetch(PDO::FETCH_ASSOC)){
?>
                <li style="font-size:13px;margin-top:10px;">
                <label style="margin-left:40px;"></label> → 
                <?=$row_2['user_id'];?> ||
                <?=$row_2['content'];?> || 
                <a href="./modify/reply.php?idx=<?=$row_2['idx'];?>">수정</a>
                <a href="./delete/reply.php?idx=<?=$row_2['idx'];?> ">삭제</a>
                </li>
<?php
                }   
            }
        }
?>
    </ul>
<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php');?>  
    
