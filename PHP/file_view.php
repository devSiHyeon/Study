<?php require_once ("./DB.php");?>
<!DOCTYPE html>
<html>
<head>
    <title>게시판</title>
</head> 
<body> 
<h3>게시판</h3>
<h4>보기</h4>
    <?php
    
    $idx    = $_GET['idx'];
    $sql    = "SELECT * FROM board AS a LEFT JOIN board_file AS b ON a.idx = b.board_idx WHERE a.idx = '$idx'";
    $result = mysqli_query($db, $sql);
    $arr    = array();

    while( $row    = mysqli_fetch_assoc($result) ) {
        $arr[] = $row;
    }
    ?>
    <!-- 게시글 -->
    <form action="update.php?idx=<?=$idx?>" method="POST" enctype="multipart/form-data">
        작성자 : <?=$arr[0]['writer'];?> <br>
        제목 : <input name="title" value="<?= $arr[0]['title'];?>"> <br>
        내용 : <textarea name="content"><?= $arr[0]['content'];?></textarea> <br>
      
    <!-- 첨부파일 -->
    <?php
        $file1  = $arr[0]['file_name'];
        $file2  = $arr[1]['file_name'];
        $path_1 = "./images/$file1";
        $path_2 = "./images/$file2";
    ?>
        파일1 : <input type="file" name="file_1" value="<?= $arr[0]['file_name'];?>">
        <?php 
            if(!empty($file1)) {                                    // DB file 있는가?
                if (file_exists($path_1)){                          // ftp file 있는가?
                    echo"<a href='./images/$file1' download>$file1</a>";
                }
            }
        ?>  <br>
        파일2 : <input type="file" name="file_2" value="<?= $arr[0]['file_name'];?>">
        <?php 
            if(!empty($file2)) {                                    // DB file 있는가?
                if (file_exists($path_2)){                          // ftp file 있는가?
                    echo"<a href='./images/$file2' download>$file2</a>";
                }
            }
        ?> <br>
        <input type="submit" value="수정" style="margin-left:200px; margin-top:20px;";>
    </form>


</body>
</html>
