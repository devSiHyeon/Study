<?php
require_once ("./DB.php");
// 게시글 작성 (file 2개 제한 업로드)

    // 게시글 값 받아오기
    $writer     = $_POST['writer'];
    $title      = $_POST['title'];
    $content    = $_POST['content'];

    $f1_name    = $_FILES['file_1']['name'];
    $f1_type    = $_FILES['file_1']['type'];
    $f1_size    = $_FILES['file_1']['size'];
    $f1_t_name  = $_FILES['file_1']['tmp_name'];
    
    $f2_name    = $_FILES['file_2']['name'];
    $f2_type    = $_FILES['file_2']['type'];
    $f2_size    = $_FILES['file_2']['size'];
    $f2_t_name  = $_FILES['file_2']['tmp_name'];

    // 첨부파일 확인
    $type   = array ("image/jpg", "image/jpeg", "image/png", "image/gif", "text/plain");
    $size   = "1048576";

    // 업로드한 파일을 저장할 디렉토리
    $image_save1 = "./images/$f1_name";
    $image_save2 = "./images/$f2_name";

    // 첨부파일_1 
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0){
        if (isset($_FILES['file_1'])) {
            if ($f1_size > $size) { // 용량확인
                echo "1. 용량 확인<button onclick='history.back()'>이전</button>";
                return;
            }
            if (!in_array($f1_type, $type)){    // 확장자 검사
                echo "1 jpg, png, gif, text 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
                return;
            } 
            if (file_exists($image_save1)) { // 디렉토리 파일명 확인
                echo $f1_name ." = file명 중복";
                return;
            }
        } 
    }
    // 첨부파일_2
    if(isset($_FILES['file_2']) && strlen($f2_name) > 0){
        if (empty($f1_name)) {
            echo "파일1부터 첨부하세요. <button onclick='history.back()'>이전</button>";
            return;
        } else {
            if (isset($_FILES['file_2'])) { // 용량확인
                if ($f2_size > $size) {
                    echo "2. 용량 확인<button onclick='history.back()'>이전</button>";
                    return;
                }
                if (!in_array($f2_type, $type)){    // 확장자 검사
                    echo "2 jpg, png, gif, text 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
                    return;
                }
                if (file_exists($image_save2)) { // 디렉토리 파일명 확인
                    echo $f2_name ." = file명 중복";
                    return;
                }
            } 
        }
    }
    
    // 디렉토리 생성
    $images_file    = "./images";
    
    if (!file_exists($images_file)) {
        //umask(0);                       // 권한 0으로 바꿔줌 (위험부담 있음)
        mkdir($images_file, 0777, true);       // 디렉토리 생성
        echo "directory Add success";
    }

    // 첨부파일_1
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0) {
        if()
        $upload = move_uploaded_file($f1_t_name,$image_save1);
        if($upload == false){
            echo "파일 업로드 실패";
            return;
        }
    } 
    
    // 첨부파일_2
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0) {
        $upload = move_uploaded_file($f2_t_name,$image_save2);
        if($upload == false){
            echo "파일 업로드 실패";
            return;
        }
    }

    // DB insert
    $sql_board  = "INSERT INTO board (`title`, `writer`, `content`, `upload_time`) VALUE ('$title', '$writer', '$content', NOW())";
    $result     = mysqli_query($db, $sql_board); 
    $last_idx   = mysqli_insert_id($db);

    $ip         = $_SERVER["REMOTE_ADDR"];

    $sql_1      = "INSERT INTO board_file (`board_idx`, `file_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) VALUES ('$last_idx', '$f1_name','$f1_t_name', '$image_save1','$f1_type','$ip', NOW())";
    $result_1   = mysqli_query($db, $sql_1);
    
    $sql_2      = "INSERT INTO board_file (`board_idx`, `file_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) VALUES ('$last_idx', '$f2_name','$f2_t_name', '$image_save2','$f2_type','$ip', NOW())"; 
    $result_2   = mysqli_query($db, $sql_2);
    echo "파일2 업로드 및 저장";
?>
