<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');
    include ('./function/paging.php');
           
    if (isset($_GET['page'])){
        $page = $_GET['page'] == 0 ? 1 : (int)$_GET['page'];
    } else {
        $page = 1;
    } 
    
    $total_sql = $db->prepare('SELECT COUNT(idx) FROM member_detail');
    $total_sql ->execute();
    $row = $total_sql ->fetch();
    $total_row      = $row[0];
    $page_list      = 5; 
    
    $page_total     = ceil($total_row / $page_list);
    
    // 페이지 예외 숫자 작성시 (page > 최대 페이지 ? 참일 경우 = 최대페이지 : 아닐 경우 (0보다 작은 숫자 일 경우 참 = 1 거짓 = 페이지 번호))
    $page           = $page > $page_total ? $page = $page_total : ($page < 0 ? $page = 1 : $page);
    $list_start     = ($page-1) * $page_list;   // 순차적인 글 목록

    $list_sql   = $db->prepare('SELECT `member_idx`, `user_name`, `user_id`, `user_phone` 
             FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx 
             ORDER BY user_name ASC, user_id ASC  LIMIT ?,?');
    $list_sql -> execute(array($list_start, $page_list));     

    $s_id = $_SESSION['user_id'];
    $s_idx= $_SESSION['idx'];
    $m_sql= $db->prepare('SELECT `user_id`, `user_name`, `user_phone` FROM member_detail AS d INNER JOIN member AS m ON d.member_idx = m.idx WHERE user_id = ?');
    $m_sql->execute(array($s_id));
    $m_row= $m_sql->fetch(PDO::FETCH_ASSOC);

    // 번호 역순으로
    $No     = $total_row-(($page -1 ) *$page_list);
    
    if ($_SESSION['user_id'] != "admin001"){
        if ($_SESSION['user_id'] == $m_row['user_id']) {
?>
    <h3>회원정보</h3>
    <table>
        <tr>
            <td>아이디</td>
            <td><?=$m_row['user_id'];?></td>
        </tr>
        <tr>
            <td>이름</td> 
            <td><?=$m_row['user_name'];?></td>
        </tr>
        <tr>
            <td>연락처</td>
            <td><?=$m_row['user_phone'];?></td>
        </tr>
    </table>        
    <input type="button" onclick="history.back()" value="이전">
    <a href="./modify/member.php?idx=<?=$s_idx?>">수정</a>
<?php
        } 

    } else {

?>    

<a href="./index.php">메인</a>
<h3>회원목록</h3>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>아이디</td>
                <td>이름</td>
                <td>연락처</td>
                <td>삭제</td>
            </tr>
        </thead>
    <?php     while ($list_row= $m_sql->fetch()) {   ?> 
        <tbody>
            <tr>
                <td><?= $No--?></td>
                <td><a href= "b_view.php?idx=<?= $list_row['member_idx'];?>"><?= $list_row['user_id'];?></a></td>
                <td><?= $list_row['user_name'];?></td>
                <td><?= $list_row['user_phone'];?></td>
                <td><?= $list_row['member_idx'];?></td>
                <td><a href="b_delete.php?idx=<?= $list_row['member_idx'];?>">삭제</a></td>
            </tr>
        </tbody>
    <?php    } ?>
    </table>

<?php 
        // 페이징 (함수 적용)
        echo paging($page, $page_list, 3, $total_row);
              // 현재페이지, 페이지수,블록수,  전체 게시글 수
    }
    require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php');
?>    