<?php require_once ("./DB.php");?>
<!DOCTYPE html>
<html>
<head>
    <title>게시판</title>
</head> 
<body> 
<h2>게시판</h2>
<h4>▶ 글쓰기</h4>
    <form action="./process_1.php" method="POST" enctype="multipart/form-data">
        작성자 : <input type="text" name="writer" required> <br>
        제 목 : <input type="text" name="title" required> <br>
        내 용 : <textarea name="content" required></textarea> <br>
        파 일1 : <input type="file" name="file_1" value=""> <br>
        파 일2 : <input type="file" name="file_2" value=""> <br>
        <label style="color:#ff6f00; font-size:11px;">* 1MB 미만 파일만 업로드 가능합니다.</label><br>
        <input type="submit">
    </form>

<h4>▶ 리스트</h4>
    <table border="1">
        <thead>
            <tr>
                <td>번호</td>
                <td>제목</td>
                <td>작성자</td>
                <td>삭제</td>
            </tr>
        </thead>
        <?php
            $sql    = "SELECT `idx`, `title`, `writer` FROM board";
            $result = mysqli_query($db, $sql);

            $No     = "1";
            while ($row= mysqli_fetch_array($result)){
        ?>
        <tbody>
            <tr>
                <td><?=$No++?></td>
                <td><a href="./view.php?idx=<?=$row['idx'];?>"><?=$row['title'];?></a></td>
                <td><?=$row['writer'];?></td>
                <td><a href="./delete.php?idx=<?=$row['idx']?>";>삭제</a></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>

    <h4>▶ FTP file 삭제</h4>
    <a href="./delete_ftp.php?delete=images";>jpg, jpeg 삭제</a> <br>
    <a href="./delete_ftp.php?delete=png";>png 삭제</a> <br>
    <a href="./delete_ftp.php?delete=gif";>gif 삭제</a> <br>
    <a href="./delete_ftp.php?delete=txt";>txt 삭제</a> <br>
    
</body>
</html>
