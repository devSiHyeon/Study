<?php  require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/db.php');

    $idx    = $_GET['idx'];

    // $sql    = "SELECT * FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx WHERE member_idx = $idx";

    $delete1 = $db -> prepare('foreign_key_checks = 0');
    $delete1 -> execute();
    
    $sql = $db->prepare('DELETE  a, b FROM member_detail AS a LEFT JOIN member AS b ON a.member_idx = b.idx WHERE b.idx = ?');
    
    if($sql -> execute(array($idx))){
        echo '<script>alert(\'삭제완료\');location.href=\'../member.php\'</script>';

        $delete2 = $db -> prepare('foreign_key_checks = 1');
        $delete2 -> execute();
    }
?>   