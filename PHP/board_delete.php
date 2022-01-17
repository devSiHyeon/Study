<?php 
    require_once "./header.php";

    $idx    = $_GET['idx'];

    // $sql    = "SELECT * FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx WHERE member_idx = $idx";
    $sql    = "DELETE FROM a, b USING member_detail AS a LEFT JOIN member AS b ON a.member_idx = b.idx WHERE b.idx = $idx";
    $result = mysqli_query($db, $sql);
    
    if($result){
        echo "삭제 완료";
    }
?> 
<input type="button" value="이전" onclick="history.back()">


<?php 
    include "./function.php";?>
