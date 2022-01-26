<body>
<form name="process_2" action="./process_2.php" method="POST" enctype="multipart/form-data">
        작성자 : <input type="text" name="writer" required> <br>
        제 목 : <input type="text" name="title" required> <br>
        내 용 : <textarea name="content" required></textarea> <br>
        파 일 : <input type="file" name="upload[]" value=""> <br>
        파 일 : <input type="file" name="upload[]" value=""> <br>
        
      <label style="color:#ff6f00; font-size:11px;"> * 1MB 미만 파일만 업로드 가능합니다.</label><br>
      <input type="submit">
  </form>
</body>

<?php require_once ("./DB.php");

    // 게시글 값 받아오기
    $writer     = $_POST['writer'];
    $title      = $_POST['title'];
    $content    = $_POST['content'];

    $files = $_FILES['upload'];
    
    $mime = array('jpg','gif','png','txt');

    // file array
    foreach($files['error'] as $ikey => $item) {
        $name = $files['name'][$ikey];     $type = $files['type'][$ikey];      $tmp_name = $files['tmp_name'][$ikey];      $size = $files['size'][$ikey];
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        // type 확인
        switch($extension){
            case "jpg": case "jpeg":    $save = "images";   break;
            case "gif":                 $save = "gif";      break;
            case "png":                 $save = "png";      break;
            case "txt":                 $save = "txt";      break;
            default:                    $save = '';
        }   // end type switch
        if ($item == 0 &&  1048576 > $size && $size> 0 && in_array($extension, $mime)) {     // 파일 유무, 용량, 타입 확인
            $rand_name = md5($item['name'][$ikey] . time() . uniqid() ).'.'. $extension;    // directory에 저장할 랜덤 이름
            // 디렉토리 생성
            if (!file_exists('./'.$save)) {
                mkdir($save, 0777, true);             
            } 
            // 파일 upload
            if (true === move_uploaded_file($tmp_name,'./'.$save.'/'.$rand_name)) {
                $insert[] = array('rand' => $rand_name, 'sysn' => $name, 'tmp' => $tmp_name, 'save' => $save, 'extension' => $extension);
            }
        }

    } // end file array

    // board content insert
    $sql ='INSERT INTO board (`title`, `writer`, `content`, `upload_time`) VALUE (\''.$title.'\',\''.$writer.'\', \''.$content.'\', NOW())';
    // board insert true
    if (mysqli_query($db, $sql)) {
        $last_idx = mysqli_insert_id($db);
        // if(count($insert)> 0){
        if(isset($insert)){             // $insert 유무 
            // board_file insert
            $ip         = $_SERVER["REMOTE_ADDR"];
            foreach ($insert as $values) {
                //pre($insert);
                $sql_file = 'INSERT INTO board_file (`board_idx`, `file_name`, `rand_name`, `tmp_name`, `save`, `type`, `ip_address`, `upload_time`) 
                    VALUES (\''.$last_idx.'\', \''.$values['sysn'].'\', \''.$values['rand'].'\', \''.$values['tmp'].'\', \'./'.$values['save'].'\',\''.$values['extension'].'\',\''.$ip.'\', NOW())';
                $result = mysqli_query($db, $sql_file);
            }
        }
        echo "<a href='./'>작성 완료</a> ";
    }

?>
