<?php require_once ("./DB.php");


    // 게시글 값 받아오기
    $writer     = $_POST['writer'];
    $title      = $_POST['title'];
    $content    = $_POST['content'];

    $files = $_FILES['upload'];
    
    // DB insert 게시글
    $sql_board  = "INSERT INTO board (`title`, `writer`, `content`, `upload_time`) VALUE ('$title', '$writer', '$content', NOW())";
    $result     = mysqli_query($db, $sql_board); 
    $last_idx   = mysqli_insert_id($db);
    
    if (is_array($files['name']) ) {
        foreach ($files['name'] as $key => $value) {           // $key (배열 번호)   $value (값)
            // 배열 정리
            $file_name = $files['name'][$key];
            $file_type = $files['type'][$key];
            $file_tmp  = $files['tmp_name'][$key];
            $file_size = $files['size'][$key];
            
            if ( 1 > strlen($value) ) continue;
            if($file_size < 1048576) {      // 용량 확인
                // 확장자 확인
                if(in_array($file_type, array('image/png', 'image/gif', 'image/jpg', 'image/jpeg','text/plain'))){
                    $rand_name  = md5($file_name . time() . uniqid() ). '.'.pathinfo($file_name)['extension'];    // 랜덤 이름
                    $extension  = pathinfo($file_name)['extension'];         // 확장자별 파일 분리
                        switch($extension){
                            case "jpg" : case "jpeg":
                                $save       = "./images";
                                $save_name  = "images";
                                break;
                            case "gif":
                                $save = "./gif";
                                $save_name = "gif";
                                break;
                            case "png":
                                $save = "./png";
                                $save_name = "png";
                                break;
                            case "txt":
                                $save = "./txt";
                                $save_name = "txt";
                                break;
                            default:
                                $save = '';
                                $save_name = '';
                        }   // end type switch
                    // directory insert
                    if (!file_exists($save)) {
                        mkdir($save_name, 0777, true);                 // 디렉토리 생성
                        echo "directory Add success <br>";
                    } 
                    // 파일명 중복 확인 및 업로드
                    if (file_exists($save.'/'.$file_name)) { 
                        echo $file_name ." = file명 중복 <br>";
                    } else {
                        // file_1 upload check
                        if ( move_uploaded_file($files['tmp_name'][$key], $save.'/'.$rand_name)){
                        // DB insert 첨부파일
                            $ip         = $_SERVER["REMOTE_ADDR"];
                            $sql_1      = "INSERT INTO board_file (`board_idx`, `file_name`, `rand_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) VALUES ('$last_idx', '$file_name', '$rand_name', '$file_tmp', '$save','$file_type','$ip', NOW())";
                            $result_1   = mysqli_query($db, $sql_1);
                        }   // end file upload (ftp & sql)
                    }
                } else  { echo "$file_name 업로드 실패 : 확장자 확인 <br>"; }  // end type check
            }   else    { echo "$file_name 업로드 실패 : 용량 확인 <br>"; }    // end size check
        }   
    }  // end file 
    echo "업로드 완료 <a href='./'>리스트</a>";
    
   
?>
