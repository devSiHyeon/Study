<?php
require_once ("./DB.php");


    // view : 첨부파일 삭제 
    if (isset($_GET['file_idx'])) {
        $file_idx   = $_GET['file_idx'];
        $sql    = "SELECT file_name, save, type from board_file WHERE idx = '$file_idx'";
        $result = mysqli_query($db, $sql);
        $row    = mysqli_fetch_assoc($result);
        
        $f_name = "$row[file_name]";
        $f_save = "$row[save]/$f_name"; 

        if (file_exists($f_save)) {
            unlink($f_save);
            if (!file_exists($f_save)){
                $sql    = "DELETE FROM board_file WHERE file_name = '$f_name'";
                $result = mysqli_query($db,$sql);
                echo " $f_name / 삭제완료";
            } 
        } else {
            echo " $f_name = file_ 없음";
        }
    } else {

        // 게시글 값 받아오기
        $idx        = $_GET['idx'];
        
        // idx 일치하는 file_name 찾기
        $sql    = "SELECT file_name, save, type from board_file WHERE board_idx = '$idx'";
        $result = mysqli_query($db, $sql);
        
        while($row    = mysqli_fetch_assoc($result) ) {
            $arr[] = $row;
        }
        $f1         = $arr[0];
        $f1_name    = "$f1[file_name]";
        $f1_save    = "$f1[save]/$f1_name"; 
        
        $f2         = $arr[1];
        $f2_name    = "$f2[file_name]";
        $f2_save    = "$f2[save]/$f2_name"; 

        // file delete
            if (file_exists($f1_save)) {
                unlink($f1_save);
                if (!file_exists($f1_save)){
                    $sql    = "DELETE FROM board_file WHERE file_name = '$f1_name'";
                    $result = mysqli_query($db,$sql);
                    echo " $f1_name / 삭제완료";
                } 
            } else {
                echo " $f1_name = file_1 없음";
            }
            
            if (file_exists($f2_save)) {            
                unlink($f2_save);
                if (!file_exists($f2_save)){
                    $sql    = "DELETE FROM board_file WHERE file_name = '$f2_name'";
                    $result = mysqli_query($db,$sql);
                    echo " $f2_name / 삭제완료";
                }
            } else {
                echo " $f2_name = file_2 없음";
            }

        // sql 삭제
            $sql    = "DELETE FROM board WHERE idx = '$idx'";
            $result = mysqli_query($db,$sql);
            echo ($result == true) ?  "DB 파일 삭제 완료" :  "DB 파일 없음";
        
    }
?>
