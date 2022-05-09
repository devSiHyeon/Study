<?php

function _msg($msg)
{
    $error = array(
        'uploaded' =>  0, 
        'error' => array('message' => $msg)
    );
    exit(json_encode($error));
}

if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0)  exit (_msg('권한이 없습니다.'));

if (isset($_FILES['upload']) || strlen ($_FILES['upload'] > 0)) {
    $files = $_FILES['upload'];
    $check = array('jpg', 'png', 'gif');    
    
    foreach($files as $key => $item){

        if($item == 0 && ($files['size'] > 1048576 || 0 > $files['size'] )) exit (_msg('파일 용량을 확인하세요.'));
        
        if($item == 0 && (!in_array(strtolower(pathinfo($files['name'], PATHINFO_EXTENSION)), $check ))) exit (_msg('jpg, png, gif 파일만 업로드 가능합니다.'));

    } 
    
    foreach($files as $key => $item){
        $name = $files['name'];
        $tmp_name = $files['tmp_name'];
        $type = $files['type'];
        $size = $files['size'];
        $extension = 'ckimg';

        if($item == 0 && 1048576 > $size && $size > 0){
            $rand_name = md5($name.time().uniqid()).'.'.strtolower(pathinfo($name, PATHINFO_EXTENSION));

            // 디렉토리 생성
            if(!file_exists($extension)){
                mkdir($extension, 0777, true);
            }

            // 파일 upload
            if(true === move_uploaded_file($tmp_name,'./'.$extension.'/'.$rand_name)){
                $insert_f[] = array('rand' => $rand_name, 'name' => $name, 'tmp' => $tmp_name, 'extension' => $extension, 'size' => $size);
            } 
        } 

    } // end file array

} // end isset(file)

$path = 파일 경로 작성; 

// 
$ckEditor = array(
                'name' => $insert_f[0]['name'],
                'filename' =>  $insert_f[0]['rand'], 
                'uploaded' =>  1, 
                'url'=> $path,
                'error' => array('message' => '이미지 업로드 성공하였습니다.')
            );

// 방법1 json 형태
exit echo ('{"filename" : "'.$insert_f[0]['rand'].'", "uploaded" : 1, "url":"'.$path.'"}');

// 방법2 json 형태 작성 후 alert 창 띄우기
exit (json_encode($ckEditor));
