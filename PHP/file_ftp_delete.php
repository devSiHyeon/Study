<?php
// FTP 삭제
    
// 파일 지정 삭제
    // $name = "09_.jpg";
    // $file = "./images/$name";
    // echo file_exists($file) == true ? unlink($file) : "파일 없음";
    // exit; 

    // 폴더 (파일) 삭제    
    $delete = $_GET['delete'];
    $directory   = "/home/se/public_html/board/$delete";
    $handle = opendir($directory);

    $i = 0;
    while ($file = readdir($handle)) {
        if($file != ".." && $file != "."){
            unlink($directory.'/'.$file);
        }

        $i++;

        if ( $i > 1000 ) {
            exit;
        }

    }
    rmdir($directory);
?>
    
