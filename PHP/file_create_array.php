<?php require_once ("./DB.php");

    // 게시글 값 받아오기
    $writer     = $_POST['writer'];
    $title      = $_POST['title'];
    $content    = $_POST['content'];

    $files = $_FILES['upload'];
    
    $f1_name    = $files['name'][0];    
    $f1_size    = $files['size'][0];
    $f1_t_name  = $files['tmp_name'][0];
    $f1_type    = pathinfo($f1_name,PATHINFO_EXTENSION);
    $f1_rand_name  = md5($f1_name . time() . uniqid() ). '.'.$f1_type;    // 랜덤 이름
    
    $f2_name    = $files['name'][1];
    $f2_size    = $files['size'][1];
    $f2_t_name  = $files['tmp_name'][1];    
    $f2_type    = pathinfo($f2_name, PATHINFO_EXTENSION );
    $f2_rand_name  = md5($f2_name . time() . uniqid() ). '.'.$f2_type;    // 랜덤 이름
    
    // file 확인
    $type   = array ("jpg", "jpeg", "png", "gif", "txt");
    $size   = "1048576";

// directory 파일 경로
    $images_file    = "./images";
    $gif_file       = "./gif";
    $png_file       = "./png";
    $txt_file       = "./txt";

// file 1 용량, 확장자 확인
if (isset($f1_name) && strlen($f1_name) > 0){
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
if (isset($f2_name) && strlen($f2_name) > 0){     
    if (isset($f2_name)) { 
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

// file 1 directory $ file name
if (isset($f1_name) && strlen($f1_name) > 0){

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
    if (file_exists($save_1.'/'.$f1_rand_name)) { // 파일명 중복 확인
        echo $f1_name ." = file명 중복 <br>";
        return;
    }
}

// file 2 directory $ file name
if (isset($f2_name) && strlen($f2_name) > 0){     

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
    if (file_exists($save_2.'/'.$f2_rand_name)) { 
        echo $f2_name ." = file명 중복 <br>";
        return;
    }
}

// file_1 upload check
if (isset($f1_name) && strlen($f1_name) > 0) {
    $upload = move_uploaded_file($f1_t_name,$save_1.'/'.$f1_rand_name);
    if($upload == false){
        echo "파일 업로드 실패 <br>";
        return;
    }
} 

// file_2 upload check
if (isset($f2_name) && strlen($f2_name) > 0) {
    $upload = move_uploaded_file($f2_t_name,$save_2.'/'.$f2_rand_name);
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
if (isset($f1_name) && strlen($f1_name) > 0){
    $sql_1      = "INSERT INTO board_file (`board_idx`, `file_name`, `rand_name`,`tmp_name`, `save`, `type`, `ip_address`, `upload_time`) 
                VALUES ('$last_idx', '$f1_name','$f1_rand_name','$f1_t_name', '$save_1','$f1_type','$ip', NOW())";
    $result_1   = mysqli_query($db, $sql_1);
}
if (isset($f2_name) && strlen($f2_name) > 0){    
    $sql_2      = "INSERT INTO board_file (`board_idx`, `file_name`, `rand_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) 
                VALUES ('$last_idx', '$f2_name','$f2_rand_name','$f2_t_name', '$save_2','$f2_type','$ip', NOW())"; 
    $result_2   = mysqli_query($db, $sql_2);
}

echo "파일 업로드 및 저장  <a href='./Index.php> 리스트 </a>";
?>
