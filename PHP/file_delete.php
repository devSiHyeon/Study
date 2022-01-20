<?php
require_once ("./DB.php");
    // ftp에서 연습파일 지울 때
    // $name = "16_sunflower-g840e80bfc_640.gif";
    // $file = "./images/$name";
    // echo file_exists($file) == true ? unlink($file) : "파일 없음";
    // exit; 
    
    // 게시글 값 받아오기
    $idx        = $_GET['idx'];
        
    // idx 일치하는 file_name 찾기
    $sql    = "SELECT file_name from board_file WHERE board_idx = '$idx'";
    $result = mysqli_query($db, $sql);
    
    while($row    = mysqli_fetch_assoc($result) ) {
        $arr[] = $row;
    }
    $f1_name = $arr[0];
    $f2_name = $arr[1];

    // ftp 파일 이름
    $file_1 = "./images/$f1_name[file_name]";
    $file_2 = "./images/$f2_name[file_name]";
    $file   = "./images/winter-gd75720e63_1280.png";

    // 첨부파일 delete
        if (file_exists($file_1)) {
            unlink($file_1);
            if (!file_exists($file_1)){
                $sql    = "DELETE FROM board_file WHERE file_name = '$f1_name[file_name]'";
                $result = mysqli_query($db,$sql);
                echo " / 삭제완료";
            } 
        } else {
            echo $file ." = file_1 없음";
        }
        
        if (file_exists($file_2)) {            
            echo $file_2 ." = file_2 있음";
            unlink($file_2);
            if (!file_exists($file_2)){
                $sql    = "DELETE FROM board_file WHERE file_name = '$f2_name[file_name]'";
                $result = mysqli_query($db,$sql);
                echo " / 삭제완료";
            }
        } else {
            echo $file ." = file_2 없음";
         }

    // sql 삭제
        $sql    = "DELETE FROM board WHERE idx = '$idx'";
        $result = mysqli_query($db,$sql);
        echo $sql;
        echo ($result == true) ?  "DB 파일 삭제 완료" :  "DB 파일 없음";
?>
