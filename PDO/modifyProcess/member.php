<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/db.php');

$idx     = $_POST['idx'];
$check_pw= $_POST['check_pw'];
$session = $_SESSION['user_id'];

$pw         = $_POST['user_pw'];
$user_name  = $_POST['user_name']; 
$user_phone = $_POST['user_phone'];


// 관리자와 회원 구분하여 비밀번호 체크
    if ($session == 'admin123' && strlen($session > '0')) {
        $sql = $db->prepare('SELECT `user_id`, `user_pw` FROM member WHERE user_id = ?');
        $sql -> execute(array($session));
        $row = $sql ->fetch(PDO::FETCH_ASSOC);
        $pass = $row['user_pw'];
    } else {
        $sql = $db->prepare('SELECT `user_id`, `user_pw` FROM member WHERE idx = ?');
        $sql -> execute(array($idx));
        $row = $sql ->fetch(PDO::FETCH_ASSOC);
        echo ($session == $row['user_id']) ? $pass = $row['user_pw'] : $pass = '';
    }

    // 비밀번호 일치 확인
    if(password_verify ($check_pw, $pass)){
        // 회원정보 수정
        $sql = $db->prepare('UPDATE member_detail SET user_name = ?, user_phone = ?, updated_time = NOW() WHERE member_idx = ?');
        $sql -> execute(array($user_name, $user_phone, $idx));

        if($pw) { 
            // 비밀번호 수정
            $user_pw = password_hash($pw, PASSWORD_DEFAULT);
            $sql_pw  = $db-> prepare('UPDATE member SET user_pw = ?, updated_time = NOW() WHERE idx = ?');
            $sql_pw -> execute(array($user_pw, $idx));
            
        } else {
            echo '비밀번호 없음';
        }
        
        if ($session == 'admin123' && strlen($session > '0')) {
            echo '<script>alert(\'회원정보 수정완료\');location.href=\'../member.php\'</script>';
        } else {
            echo '<script>alert(\'회원정보 수정완료\');location.href=\'../privacy.php\'</script>';
        }

    } else {
            echo '<script>alert(\'회원정보 불일치\');history.back();</script>';
    }
?>