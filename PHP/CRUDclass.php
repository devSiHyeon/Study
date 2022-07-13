<?php
include_once(_LIB_ . '/S3.php');

class Board 
{
    private $year;
    private $mimeAll;
    private $mimeImg;
    private $result;
    private $S3;

    public function __construct()               // 싱글톤일 때 8버전 부터는 private 작성해야함
    {
        $this->mimeAll = array('image/jpeg', 'image/jpg', 'image/png', 'application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip');
        $this->mimeImg = array('image/jpeg', 'image/jpg', 'image/png');
        $this->year = date('Y');
        $this->result = array(
             'error' => true
            ,'msg' => ''
            ,'data' => array()
        );
        $this->S3 = new S3(false);
    }

    public function strlenCheck($text)
    {
        if (strlen($text) < 1) return false;
    }
    
    public function fileDir($f_saved, $board_name)
    {
        
        foreach ($f_saved as $key => $item) {

            $name = $f_saved[$key]['name'];
            $tmp_name = $f_saved[$key]['tmp_name'];
            $mime = $f_saved[$key]['mime'];
            $size = $f_saved[$key]['size'];
            $rand_name = $f_saved[$key]['rand_name'];       
            $path = 'board/'.$board_name.'/'.$this->year.'/'.$mime.'/';
             
            // 파일 upload
            if (true === $this->S3->uploadFile($tmp_name, $path.$rand_name)) {
                $insert_f[] = array('name' => $name, 'rand' => $rand_name, 'extension' => $mime, 'size' => $size, 'path' => $path);
            }

        }

        if (isset($insert_f)) return $insert_f;        
        return;
    } // end fileDir    

    private function msg($msg) 
    {
        $error = array(
            'uploaded' =>  0, 
            'error' => array('message' => $msg)
        );
        exit(json_encode($error));
    }   
    
    //write.ajax.php
    public function insert($board_name, $member_sql, $password, $secret_use, $notice_use, $attach, $in_data, $placeholder)     
    { 
        $in_key =  implode(', ', array_keys($in_data));
        $pl = implode('), (', $placeholder);
        
        if (isset($attach) && count($attach > 0) && is_array($attach)) $insert_f = $this->fileDir($attach, $board_name);
    
        $sql_i = $db->prepare('INSERT INTO '.$board_name.' ('.$in_key.') VALUES ('.$pl.')');
        $insert = array_values($in_data);
      
        if (false === ($result_i = $sql_i->execute($insert))) return false;
        $last_idx = $db->lastInsertId();

        if (isset($insert_f) && count($insert_f) > 0) {

            $values = $place = array();
            foreach ($insert_f as $item_f) {
                $values[] = $last_idx;
                $values[] = $board_name;
                $values[] = $item_f['name'];
                $values[] = $item_f['rand'];
                $values[] = $item_f['extension'];
                $values[] = $item_f['size'];
                $values[] = $item_f['path']; 
                $values[] = ip2long($_SERVER['REMOTE_ADDR']); 
 
                $place[] = '?,?,?,?,?,?,?,?';

            }   
            $sql_f = $db->prepare('INSERT INTO board_file (board_no, board_name, name, rand_name, ext, size, path, ip) VALUES (' . implode('), (', $place). ')');
            if (false === ($sql_i->execute($values))) return false;
        }

        return true;
    } // end write

    //update.ajax.php
    public function modify($idx, $mb_id, $member_sql, $board_name, $attach, $sfile, $secret_use, $notice_use, $up_data, $placeholder) 
    {       
        $up_key =  implode('=?, ', array_keys($up_data));
        $phUpdate = implode('), (', $placeholder);
        
        // 첨부파일 삭제
        $file_idx = array();
        if (!isset($sfile)) $sfile = array();

        $sql = $db -> prepare ('SELECT * FROM board_file WHERE board_no = ?');
        $sql -> execute (array($idx)))) return false;
        if (false === ($result_s = $sql->fetch(PDO::FETCH_ASSOC);

        if (isset($result_s) && count($result_s) > 0) {
            foreach ($result_s as $key => $value) {
                if (!in_array($value['idx'], $sfile)) {
                    $file_idx[] = $value;
                }
            }

            $delFile = array($idx);
            $phDel = array();
            foreach ($file_idx as $key => $value) {
                
                $save = $value['path'].$value['rand_name'];

                if (true == $this->S3->existObject($save)) {
                    
                    $this->S3->deleteFile($save);
                    
                    if (false == $this->S3->existObject($save)) {
                        $delFile[] = $value['idx'];
                        $phDel[] = '?';
                    }
                }
            }

            if (!empty($phDel)) {
                $sql = $db -> prepare('delete from board_file where board_no = ? and idx in (' . implode(', ', $phDel). ')');
                if (false === ($sql->execute(array($delFile)))) return false;
                
            }
        } // end 첨부파일 삭제
        
        // 새로 추가한 첨부파일        
        if (isset($attach) && count($attach > 0) && is_array($attach)) $insert_f = $this->fileDir($attach, $board_name);        

        // 게시판 update
        $sql = $db ->prepare('UPDATE '.$board_name.' SET '.$up_key.'= ?, update_date = NOW() WHERE idx = ?');
        $update = array_values($up_data);
        array_push($update, $idx);      
        if (false === ($sql ->execute($update))) return false;

        // 첨부파일 insert
        if (isset($insert_f) && count($insert_f) > 0) {           

            $values = $phFile = array();
            foreach ($insert_f as $item_f) {
               $values[] = $idx;
               $values[] = $board_name;
               $values[] = $item_f['name'];
               $values[] = $item_f['rand'];
               $values[] = $item_f['extension'];
               $values[] = $item_f['size'];
               $values[] = $item_f['path']; 
               $values[] = ip2long($_SERVER['REMOTE_ADDR']); 

               $phFile[] = '?,?,?,?,?,?,?,?';
            }

            $sql_f = $db ->prepare('INSERT INTO board_file (board_no, board_name, name, rand_name, ext, size, path, ip) VALUES (' . implode('), (', $phFile). ')');
            if (false === ($sql_f ->execute($values))) return false;

        }
      
        $this->result['data'] = array($idx, $secret_use);
        $this->result['msg'] = '수정 완료 되었습니다';
        $this->result['err'] = false;
        return $this->result;
    } // end update

    //delete.ajax.php (delete)
    public function delete($idx, $board_name) 
    {   
        // 첨부파일 삭제
        $sql = $db ->prepare('SELECT * FROM board_file WHERE board_no = ?');
        $sql ->execute(array($idx);
        if (false === ($result_s = $sql->fetch(PDO::FETCH_ASSOC))) return false;
      
 
        $file_idx = array();
        if (isset($result_s) && count($result_s) > 0) {
            
            foreach ($result_s as $key => $value) {
                $save = $value['path'].$value['rand_name'];

                if (true == $this->S3->existObject($save)) {
                    
                    $this->S3->deleteFile($save);
                    
                    if (false != $this->S3->existObject($save)) return false;
                        
                }                
            }

            $sql = $db ->prepare('DELETE FROM board_file WHERE board_no = ?');
            if (false === ($sql ->execute(array($idx)))) return false;

        }//첨부파일 삭제        
        
        $sql = $db ->prepare('DELETE FROM '.$board_name.' WHERE idx = ?');    
        if (false === ($sql ->execute(array($idx)))) return false;


        return true;
    } // end delete

    //delete.ajax.php (display_none)
    public function delete_none($idx, $board_name, $up_data='')
    {   
        $up_key =  implode('=?, ', array_keys($up_data));
        
        $sql = $db ->prepare('UPDATE '.$board_name.' SET '.$up_key.'= ?, del_date = NOW() WHERE idx = ?');
        $update = array_values($up_data);
        array_push($update, $idx);      
        if (false === ($sql ->execute($update))) return false;

        return true;
    } // end delete
}//end class
