<?php
require_once ('../db.php');

    // view : 첨부파일 삭제 
    if (isset($_GET['file_idx'])) {
        $file_idx   = $_GET['file_idx'];
        $sql_1 = $db-> prepare('SELECT file_name, save, rand_name from board_file WHERE idx = ?');
        $sql_1 -> execute(array($file_idx));
        $row = $sql_1->fetch(PDO::FETCH_ASSOC);
        
        $f_name = "$row[file_name]";
        $r_name = "$row[rand_name]";
        $f_save = "../../board/$row[save]/$r_name"; 

        if (file_exists($f_save)) {
            unlink($f_save);
            if (!file_exists($f_save)){
                $sql_2 = $db -> prepare('DELETE FROM board_file WHERE rand_name =?');
                $sql_2->execute(array($r_name));
                // echo " $f_name / 삭제완료";
            } 
        } else {
            // echo " $f_name = file_ 없음";
        }
    } else {

        // 게시글 값 받아오기
        $idx        = $_GET['idx'];
        
        // idx 일치하는 file_name 찾기
        $sql_3 = $db ->prepare('SELECT file_name, save, type from board_file WHERE board_idx = ?');
        $sql_3 ->execute(array($idx));

        while($row = $sql_3->fetch(PDO::FETCH_ASSOC) ) {
                $arr[] = $row;
        }

        // 배열이 비어있는지 확인 (비어 있으면 첨부파일이 없음을 나타냄)
        if(!empty($arr)){
            // file 1
            $f1         = $arr[0];
            $f1_name    = "$f1[file_name]";
            $f1_save    = "../../board/$f1[save]/$f1_name"; 

            // file delete 1
                if (file_exists($f1_save)) {
                    unlink($f1_save);
                    if (!file_exists($f1_save)){
                        $sql_4 =$db->prepare('DELETE FROM board_file WHERE file_name = ?');
                        $sql_4->execute(array($f1_name));
                        // echo " $f1_name / 삭제완료";
                    } 
                } else {
                    echo " $f1_name = file_1 없음";
                }

            // file 2    
            if (count($arr) >1){
                $f2         = $arr[1];
                $f2_name    = "$f2[file_name]";
                $f2_save    = "$f2[save]/$f2_name"; 

                //file delete 2
                if (file_exists($f2_save)) {            
                    unlink($f2_save);
                    if (!file_exists($f2_save)){
                        $sql_5 = $db->prepare('DELETE FROM board_file WHERE file_name = ?');
                        $sql_5 ->execute(array($f2_name));
                        echo " $f2_name / 삭제완료";
                    }
                } else {
                    echo " $f2_name = file_2 없음";
                }
            }
        }             
        // sql 삭제
        $sql_6= $db->prepare('DELETE FROM board WHERE idx = ?');
        $sql_6->execute(array($idx));
        echo ($result == true) ? '<script>alert(\'파일 삭제 완료\');</script>' : '<script>alert(\'삭제 오류 \n 관리자에게 문의하세요.\');</script>';
    }
        
?>
