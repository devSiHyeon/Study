<?php
require_once ("./DB.php");
// 게시글 작성 (file 2개 제한 업로드)

    // 게시글 값 받아오기
        $writer     = $_POST['writer'];
        $title      = $_POST['title'];
        $content    = $_POST['content'];

        $f1_name    = $_FILES['file_1']['name'];    
        $f1_type  = pathinfo($_FILES['file_1']['name'], PATHINFO_EXTENSION );
        $f1_size    = $_FILES['file_1']['size'];
        $f1_t_name  = $_FILES['file_1']['tmp_name'];
        
        $f2_name    = $_FILES['file_2']['name'];
        $f2_size    = $_FILES['file_2']['size'];
        $f2_t_name  = $_FILES['file_2']['tmp_name'];    
        $f2_type  = pathinfo($_FILES['file_2']['name'], PATHINFO_EXTENSION );

    // file 확인
        $type   = array ("jpg", "jpeg", "png", "gif", "txt");
        $size   = "1048576";
    
    // directory 파일 경로
        $images_file    = "./images";
        $gif_file       = "./gif";
        $png_file       = "./png";
        $txt_file       = "./txt";
    
    // file 1 용량, 확장자 확인
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0){
        if ($f1_size > $size) { 
            echo "1. 용량 확인<button onclick='history.back()'>이전</button>";
            return;
        }
        if (!in_array($f1_type, $type)){    
            echo "1 jpg, png, gif, txt 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
            return;
        } 
    }

    // file 2  용량, 확장자 확인
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0){     
        if (empty($f1_name)) {
            echo "파일1부터 첨부하세요. <button onclick='history.back()'>이전</button>";
            return;
        } else {
            if (isset($_FILES['file_2'])) { 
                if ($f2_size > $size) {     // 용량확인
                    echo "2. 용량 확인<button onclick='history.back()'>이전</button>";
                    return;
                }
                if (!in_array($f2_type, $type)){    // 확장자 검사
                    echo "2 jpg, png, gif, txt 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
                    return;
                }
            }
        }   
    }

    // file 1 directory $ file name
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0){

        // file1 경로
        if(in_array($f1_type, $type)){
            switch($f1_type){
                case "jpg" : case "jpeg":
                    $save_1 = $images_file;
                    break;
                case "gif":
                    $save_1 = $gif_file;
                    break;
                case "png":
                    $save_1 = $png_file;
                    break;
                case "txt":
                    $save_1 = $txt_file;
                    break;
                default:
                    $save_1 = '';
            }
        }
        
        // directory insert
        if (!file_exists($save_1)) {
            //umask(0);                                 // 권한 0으로 바꿔줌 (위험부담 있음)
            mkdir($save_1, 0777, true);                 // 디렉토리 생성
            echo "1 directory Add success <br>";
        }
            
        // 파일명 중복 확인
        if (file_exists($save_1.'/'.$f1_name)) { // 파일명 중복 확인
            echo $f1_name ." = file명 중복 <br>";
            return;
        }
    }

    // file 2 directory $ file name
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0){     

        // file2 경로
        if(in_array($f2_type, $type)){
            switch($f2_type){
                case "jpg" : case "jpeg":
                    $save_2 = $images_file;
                    break;
                case "gif":
                    $save_2 = $gif_file;
                    break;
                case "png":
                    $save_2 = $png_file;
                    break;
                case "txt":
                    $save_2 = $txt_file;
                    break;
                default:
                    $save_2 = '';
            }
        }

        // directory insert
        if (!file_exists($save_2)) {
            //umask(0);                                 // 권한 0으로 바꿔줌 (위험부담 있음)
            mkdir($save_2, 0777, true);                 // 디렉토리 생성
            echo "2 directory Add success <br>";
        }
        // 파일명 중복 확인
        if (file_exists($save_2.'/'.$f2_name)) { 
            echo $f2_name ." = file명 중복 <br>";
            return;
        }
    }
    
    // file_1 upload check
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0) {
        $upload = move_uploaded_file($f1_t_name,$save_1.'/'.$f1_name);
        if($upload == false){
            echo "파일 업로드 실패 <br>";
            return;
        }
    } 
    
    // file_2 upload check
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0) {
        $upload = move_uploaded_file($f2_t_name,$save_2.'/'.$f2_name);
        if($upload == false){
            echo "파일 업로드 실패 <br>";
            return;
        }
    }
    // DB insert
    $sql_board  = "INSERT INTO board (`title`, `writer`, `content`, `upload_time`) VALUE ('$title', '$writer', '$content', NOW())";
    $result     = mysqli_query($db, $sql_board); 
    $last_idx   = mysqli_insert_id($db);
    $ip         = $_SERVER["REMOTE_ADDR"];

    // file 있을 때
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0){
        $sql_1      = "INSERT INTO board_file (`board_idx`, `file_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) 
                    VALUES ('$last_idx', '$f1_name','$f1_t_name', '$save_1','$f1_type','$ip', NOW())";
        $result_1   = mysqli_query($db, $sql_1);
    }
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0){    
        $sql_2      = "INSERT INTO board_file (`board_idx`, `file_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) 
                    VALUES ('$last_idx', '$f2_name','$f2_t_name', '$save_2','$f2_type','$ip', NOW())"; 
        $result_2   = mysqli_query($db, $sql_2);
    }

    echo "파일 업로드 및 저장  <a href='./Index.php> 리스트 </a>";
?>
