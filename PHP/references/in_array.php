 // file 첨부
if ( ( true == is_array($files) ) && (count($files) > 0) ) {
        foreach ($files['name'] as $key => $value) {
            //key => 0, 1
            $file_name[$key] = $files['name'][$key];
            $file_type[$key] = $files['type'][$key];
            $file_tmp[$key]  = $files['tmp_name'][$key];
            $file_size[$key] = $files['size'][$key];
            //데이터 입력

            //데이터 결과
            $result[$key] = move_uploaded_file();
        }
    }
    
    // 결과 실패한 것 (용량초과, 확장자 오류 등)
    in_array(false,$result) {

    } else {
        //board insert 
          $sql    = 'INSERT INTO 테이블명 (`name`,`type`) VALUE ('.$value.','.$value.')';
          $result = mysqli_query($db, $sql);

        //board_file insert
        foreach ($file_name as $key => $value) {        
            $qr     = 'INSERT INTO 테이블 (`name`,`type`) VALUE ('.$value.','.$value.')';
            $result = mysqli_query($db, $qr);
        }
    }
