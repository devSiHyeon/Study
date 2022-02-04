<?php require_once ("./DB.php");
// 대댓글
$idx        = $_POST['reply_idx'];      // 최상단 댓글 내용 idx
$content    = $_POST['reply'];          // 대댓글 내용
$user_id    = $_SESSION['user_id'];     // 대댓글 작성자 id

// 댓글의 순위
    // 최상단 댓글의 하위 댓글 있는지 확인
    $sql_c      = 'SELECT MAX(reply_rank) FROM reply_2  WHERE idx = \''.$idx.'\' OR reply_idx = \''.$idx.'\'';
    $result_c   = mysqli_query($db, $sql_c);
    $row_c      = mysqli_fetch_assoc($result_c);
    $rank_c     = $row_c['MAX(reply_rank)'];

    // 댓글과 하위 댓글 중 가장 뒤에 있는 숫자
    $sql_r      = 'SELECT idx, detail_idx, reply_no, reply_rank FROM reply_2 WHERE reply_rank = \''.$rank_c.'\'';
    $result_r   = mysqli_query($db, $sql_r);
    $row_r      = mysqli_fetch_assoc($result_r);
    
    // 순위 +1
    $sql    = 'SELECT idx, reply_rank FROM reply_2 ORDER BY reply_rank ASC';
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)){
        
        if($rank_c < $row['reply_rank']) {       // 댓글의 순위 < 나머지 댓글들
            $idx_u  = $row['idx'];
            $rank   = $row['reply_rank'] + 1;
            $sql_up    = 'UPDATE reply_2 SET reply_rank = \''.$rank.'\' WHERE idx = \''.$idx_u.'\'';
            $result_up = mysqli_query($db, $sql_up);
        }
    }
// 게시글 번호, 댓글 위치
    $r_idx      = $row_r['detail_idx'];             // 게시글 번호 
    $r_rank     = $row_r['reply_rank'] + 1;         // 댓글 순위
    $r_no       = $row_r['reply_no'] + 1;           // 댓글 위치
    $sql    = "INSERT INTO reply_2 (`detail_idx`, `reply_idx`, `reply_no`, `user_id`, `reply_rank`, `content`) 
    VALUES('$r_idx', '$idx', '$r_no','$user_id','$r_rank ','$content')";
    $result = mysqli_query($db, $sql);

if($result){
    echo '<script>alert ("댓글 작성 완료");location.href=\'./r2_view.php?idx='.$row_r['detail_idx'].'\';</script>';
} else {
    echo '<script>alert ("댓글 작성 오류");history.back();</script><br>';
}
?>
