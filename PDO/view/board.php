<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');?>

<h3>게시판</h3>
    <?php
    
    $idx = $_GET['idx'];
    $sql = $db->prepare('SELECT *, b.idx AS file_idx FROM board AS a LEFT JOIN board_file AS b ON a.idx = b.board_idx WHERE a.idx = ?');
    $sql->execute(array($idx));
    $arr    = array();

    while( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $arr[] = $row;
    }

    // 첨부파일
        // 디렉토리 파일 경로
        $save_1     = $arr[0]['save'];
        $file1      = $arr[0]['rand_name'];
        $F1         = $arr[0]['file_name'];
        $path_1     = "/board/$save_1/$file1";
        
        if(isset($arr[1]) && strlen($arr[1]['file_name']) > 0){  
            $save_2     = $arr[1]['save'];         
            $file2      = $arr[1]['rand_name'];
            $F2         = $arr[1]['file_name'];
            $path_2     = "/board/$save_2/$file2";
        }
    ?>
    
    <!-- 게시글 -->
    <h3>수정 (배열 사용) ▼</h3>
    <form name="update_process" action="../modify/board.php?idx=<?=$idx?>" method="POST" enctype="multipart/form-data" >
        작성자 : <?=$arr[0]['writer'];?><br>
        제목 : <input name="title" value="<?= $arr[0]['title'];?>"> <br>
        내용 : <textarea name="content"><?= $arr[0]['content'];?></textarea> <br>
      
        파일1 : <input type="file" name="upload[]" value="<?= $arr[0]['file_name'];?>">
        <?php 
            if(!empty($file1)) {                                    // DB file 있는가?
                if (file_exists($path_1)){                          // ftp file 있는가?
        ?>
                   <a href='/board/$save_1/$file1' name='file1' download><?=$F1?></a>
                   <input type='hidden' name='DB_file_1' value='<?=$file1?>'>
        <?php
                }
            }
            if(isset($arr[0]) && strlen($arr[0]['file_name']) > 0){  
        ?>  
            <a href="../delete/board.php?idx=<?=$idx?>&file_idx=<?=$arr[0]['file_idx']?>"><?=$F1?> 삭제</a><br>
        <?php }?>

        <br>
        파일2 : <input type="file" name="upload[]" value="<?= $arr[0]['file_name'];?>">
        <?php 
            if(!empty($file2)) {                                    // DB file 있는가?
                if (file_exists($path_2)){                          // ftp file 있는가?
        ?>
                   
                   <a href='/board/$save_2/$file2' name='file2' download><?=$F2?></a>
                   <input type='hidden' name='DB_file_2' value='<?=$file2?>'>
        <?php
                }
            }
            if(isset($arr[1]) && strlen($arr[1]['file_name']) > 0){  
        ?> 
        <a href="../delete/board.php?idx=<?=$idx?>&file_idx=<?=$arr[1]['file_idx']?>"><?=$F2?> 삭제</a>
        <?php } ?>
        <br>
        <div class='btn_modify'>
            <a href='../board.php'>목록</a>
            <input type="submit" value="수정">
        </div>
    </form>
<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php');?>