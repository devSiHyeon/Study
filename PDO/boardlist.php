<?php  require_once ("/home/se/public_html/pdo/header.php");
    include ($_SERVER['DOCUMENT_ROOT'].'/pdo/function/paging.php');

    if (isset($_GET['page'])){
        $page = $_GET['page'] == 0 ? 1 : (int)$_GET['page'];
    } else {
        $page = 1;
    }

    $total_sql=$db->prepare('SELECT COUNT(idx) FROM board');
    $total_sql->execute();
    $row=$total_sql->fetch();
    $total_row = $row[0];
    $page_list = 10; 

    $page_total = ceil($total_row / $page_list);
    
    // 페이지 예외 숫자 작성시 (page > 최대 페이지 ? 참일 경우 = 최대페이지 : 아닐 경우 (0보다 작은 숫자 일 경우 참 = 1 거짓 = 페이지 번호))
    $page       = $page > $page_total ? $page = $page_total : ($page < 0 ? $page = 1 : $page);
    $list_start = ($page-1) * $page_list;   // 순차적인 글 목록

    $list_sql = $db->prepare('SELECT `title`, `writer`, `idx` FROM board ORDER BY upload_time DESC LIMIT '.$list_start.','. $page_list.'');
    $list_sql->execute(); 

    // 번호 역순으로
    $No = $total_row-(($page -1 ) *$page_list);
?>

▶ 게시판
<h4>▷ 글쓰기</h4>
    <form name="boardcreate" action="./create/board.php" method="POST" enctype="multipart/form-data">
        작성자 : <input type="text" name="writer" required> <br>
        제 목 : <input type="text" name="title" required> <br>
        내 용 : <textarea name="content" required></textarea> <br>
        파 일 : <input type="file" name="upload[]" value=""> <br>
        파 일 : <input type="file" name="upload[]" value=""> <br>
        
        <label style="color:#ff6f00; font-size:11px;"> * 1MB 미만 파일만 업로드 가능합니다.</label><br>
        <input type="submit">
    </form>

<h4>▷ 리스트</h4>
    <table>
        <thead>
            <tr>
                <td>번호</td>
                <td>제목</td>
                <td>작성자</td>
                <td>수정</td>
                <td>삭제</td>
            </tr>
        </thead>
        <?php
            while ($list_row=$list_sql->fetch()){
        ?>
        <tbody>
            <tr>
                <td><?=$No++?></td>
                <td><?=$list_row['title'];?></td>
                <td><?=$list_row['writer'];?></td>
                <td><a href="./view/board.php?idx=<?=$list_row['idx'];?>" class='modify'>수정</a></td>
                <td><a href="./delete/board.php?idx=<?=$list_row['idx']?>" class='delete'>삭제</a></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
    <?php 
        // 페이징 (함수 적용)
        echo paging($page, $page_list, 5, $total_row);
    ?>

    <h4>▷ FTP file 삭제</h4>
    <a href="./process/delete_ftp.php?delete=images";>jpg, jpeg 삭제</a> <br>
    <a href="./process/delete_ftp.php?delete=png";>png 삭제</a> <br>
    <a href="./process/delete_ftp.php?delete=gif";>gif 삭제</a> <br>
    <a href="./process/delete_ftp.php?delete=txt";>txt 삭제</a> <br>
    
<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php'); ?>