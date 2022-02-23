<?php 
    require_once ("../db.php");

    // 게시글 값 받아오기
    $idx    =$_GET['idx'];
    $title  =$_POST['title'];
    $content=$_POST['content'];
    
    (isset($_POST['DB_file_1'])) ? $old1=$_POST['DB_file_1'] : $old1='';
    (isset($_POST['DB_file_2'])) ? $old2=$_POST['DB_file_2'] : $old2='';
    $old=array($old1,$old2);

    $files = $_FILES['upload'];
    $mime = array('jpg','gif','png','txt');
    
    // file array
    foreach($files['error'] as $ikey => $item) {
        $name = $files['name'][$ikey];     $type = $files['type'][$ikey];      $tmp_name = $files['tmp_name'][$ikey];      $size = $files['size'][$ikey];
        
        // type 확인
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        if ($item == 0 &&  1048576 > $size && $size> 0 && in_array($extension, $mime)) {     // 파일 유무, 용량, 타입 확인
            $rand_name = md5($item['name'][$ikey] . time() . uniqid() ).'.'. $extension;    // directory에 저장할 랜덤 이름
            // 디렉토리 생성
            if (!file_exists('../../board/'.$extension)) {
                mkdir($extension, 0777, true);             
            } 
            // 파일 upload
            if (true === move_uploaded_file($tmp_name,'../../board/'.$extension.'/'.$rand_name)) {
                $insert[] = array('rand' => $rand_name, 'sysn' => $name, 'tmp' => $tmp_name, 'save' => $extension, 'extension' => $extension);
            }
        } else { 
            if(isset($name) && strlen($name) > 0 ){
                $file_false[] = array($name); 
            }
        }

    } // end file array 

    // 확장자, 크기 오류 확인
    if(isset($file_false)){
        foreach ($file_false as $values) {
             echo $values[0].' 업로드 실패 : 확장자 및 용량 확인하세요. ';
             echo'<button onclick="history.back()">이전</button><br>';
         }
    }

    // board content insert
    $sql = $db -> prepare ('UPDATE board SET  `title` = ?, `content` = ?, `upload_time` = NOW() WHERE idx = ?');
    
    //board insert true
    if ($sql -> execute (array($title, $content, $idx))) {

        if(isset($insert)){
            // board_file insert
            $ip = $_SERVER["REMOTE_ADDR"];
            
            foreach ($insert as $key => $values) {  
                foreach($old as $change){   // rand_name 일치하는 정보 update
                        
                }
                    pre($values);
                    echo '</br>';
                    echo $change;
                    echo '</br>';
                    $sql_file = $db -> prepare('UPDATE board_file SET  `file_name` = ?, `rand_name` = ?, `tmp_name` = ?, `save` = ?, `type` = ?, `ip_address` = ?, `upload_time` = NOW() WHERE board_idx = ?');
                    $sql_file -> execute(array($values['sysn'],$values['rand'],$values['tmp'],'./'.$values['save'],$values['extension'],$ip, $change));
                    
                    echo $values['sysn'].' 업로드 완료 </br>';
            }
        }
    }
    //echo '<script>alert(\'업로드 완료했습니다.\');location.href=\'../list1.php\';</script>' ;

?>
