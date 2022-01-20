<?php
require_once ("./DB.php");
// 게시글 작성 (file 2개 제한 업로드)

    // 게시글 값 받아오기
    $idx        = $_GET['idx'];
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
    
    // DB에 저장된 첨부파일 이름 
    $sql    = "SELECT file_name FROM board AS a LEFT JOIN board_file AS b ON a.idx = b.board_idx WHERE a.idx = '$idx'";
    $result = mysqli_query($db, $sql);
    $arr    = array();
    
    while( $row    = mysqli_fetch_assoc($result) ) {
        $arr[] = $row;
    }
    $file_old_1 = $arr[0];
    $file_old_2 = $arr[1];

    // ftp 내용 수정
    $old_1 = "./images/$file_old_1[file_name]";         // 파일 변경 전 이름1
    $new_1 = "./images/$f1_name";                       // 파일 변경 후 이름1
    $old_2 = "./images/$file_old_2[file_name]";         // 파일 변경 전 이름2
    $new_2 = "./images/$f2_name";                       // 파일 변경 후 이름2

    // 첨부파일 확인
    $type   = array ("image/jpg", "image/jpeg", "image/png", "image/gif", "text/plain");
    $size   = "1048576";
    
    // 첨부파일_1 
    // if (isset($_FILES['file_1']) && strlen($f1_name) > 0){
    //     if (isset($_FILES['file_1'])) {
    //         if ($f1_size > $size) { // 용량확인
    //             echo "1. 용량 확인<button onclick='history.back()'>이전</button>";
    //             return;
    //         }
    //         if (!in_array($f1_type, $type)){    // 확장자 검사
    //             echo "1 jpg, png, gif, text 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
    //             return;
    //         } 
    //         if (file_exists($new_1)) { // 디렉토리 파일명 확인
    //             echo $new_1 ." = file명 중복";
    //             return;
    //         }
    //     } 
    // }
    // // 첨부파일_2
    // if(isset($_FILES['file_2']) && strlen($f2_name) > 0){
    //     if (empty($f1_name)) {
    //         echo "파일1부터 첨부하세요. <button onclick='history.back()'>이전</button>";
    //         return;
    //     } else {
    //         if (isset($_FILES['file_2'])) { // 용량확인
    //             if ($f2_size > $size) {
    //                 echo "2. 용량 확인<button onclick='history.back()'>이전</button>";
    //                 return;
    //             }
    //             if (!in_array($f2_type, $type)){    // 확장자 검사
    //                 echo "2 jpg, png, gif, text 확장자만 가능합니다.<button onclick='history.back()'>이전</button>";
    //                 return;
    //             }
    //             if (file_exists($new_2)) { // 디렉토리 파일명 확인
    //                 echo $new_2 ." = file명 중복";
    //                 return;
    //             }
    //         } 
    //     }
        
    // }

    // 첨부파일 idx
    $name_1     = "$file_old_1[file_name]";
    $sql_idx    = "SELECT file_name FROM board_file WHERE file_name = '$name_1'";
    $result_idx = mysqli_query($db, $sql_idx); 
    $row_1      = mysqli_fetch_assoc($result_idx);

    $name_2     = "$file_old_2[file_name]";
    $sql_idx    = "SELECT file_name FROM board_file WHERE file_name = '$name_2'";
    $result_idx = mysqli_query($db, $sql_idx); 
    $row_2      = mysqli_fetch_assoc($result_idx);

    $ip         = $_SERVER["REMOTE_ADDR"];

    // 첨부파일_1
    if (isset($_FILES['file_1']) && strlen($f1_name) > 0) {
        if (file_exists($old_1)){
            unlink($old_1);
            $upload = move_uploaded_file($f1_t_name,$new_1);
            if($upload == false){
                echo "파일 업로드 실패";
                return;
            }
            $sql_1      = "UPDATE board_file SET `file_name` = '$f1_name', `tmp_name` = '$f1_t_name', `save` = '$new_1', `type` = '$f1_type', `ip_address` = '$ip', `upload_time` = NOW() WHERE file_name = '$row_1[file_name]'";
            $result_1   = mysqli_query($db, $sql_1);
            
            echo "파일1 업로드 및 저장";
        } 
    } 

    // 첨부파일_2
    if (isset($_FILES['file_2']) && strlen($f2_name) > 0) {
        if (file_exists($old_2)){
            unlink($old_2);
            $upload = move_uploaded_file($f2_t_name,$new_2);
            if($upload == false){
                echo "파일 업로드 실패";
                return;
            }
            $sql_2      = "UPDATE board_file SET `file_name` = '$f2_name', `tmp_name` = '$f2_t_name', `save` = '$new_2', `type` = '$f2_type', `ip_address` = '$ip', `upload_time` = NOW() WHERE file_name = '$row_2[file_name]'";
            $result_2   = mysqli_query($db, $sql_2);
            echo "파일2 업로드 및 저장";
        } 
    }
    
    // DB update
    $sql_board  = "UPDATE board SET title = '$title', content = '$content', upload_time = NOW() WHERE idx = $idx";
    $result     = mysqli_query($db, $sql_board); 

?>
