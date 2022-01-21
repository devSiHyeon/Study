<?php
require_once ("./DB.php");
    // 게시글 값 받아오기
    $idx        = $_GET['idx'];
        
    // idx 일치하는 file_name 찾기
    $sql    = "SELECT file_name, save, type from board_file WHERE board_idx = '$idx'";
    $result = mysqli_query($db, $sql);
    
    while($row    = mysqli_fetch_assoc($result) ) {
        $arr[] = $row;
    }
    $f1         = $arr[0];
    $f2         = $arr[1];

    $f1_name    = "$f1[file_name]";
    $f1_save    = "$f1[save]/$f1_name"; 

    $f2_name    = "$f2[file_name]";
    $f2_save    = "$f2[save]/$f2_name"; 

    // 첨부파일 delete
        if (file_exists($f1_save)) {
            unlink($f1_save);
            if (!file_exists($f1_save)){
                $sql    = "DELETE FROM board_file WHERE file_name = '$f1_name'";
                $result = mysqli_query($db,$sql);
                echo " / 삭제완료";
            } 
        } else {
            echo $f1_name ." = file_1 없음";
        }
        
        if (file_exists($f2_save)) {            
            unlink($f2_save);
            if (!file_exists($f2_save)){
                $sql    = "DELETE FROM board_file WHERE file_name = '$f2_name'";
                $result = mysqli_query($db,$sql);
                echo " / 삭제완료";
            }
        } else {
            echo $f2_name ." = file_2 없음";
         }

    // sql 삭제
        $sql    = "DELETE FROM board WHERE idx = '$idx'";
        $result = mysqli_query($db,$sql);
        echo ($result == true) ?  "DB 파일 삭제 완료" :  "DB 파일 없음";
?>
