<?php 
    require_once "./header.php";
    $idx    = $_GET['idx'];
    $sql    = "SELECT `user_id`, `user_name`, `user_phone` FROM member_detail INNER JOIN member ON member_detail.member_idx=member.idx WHERE member_idx = $idx";
    $result = mysqli_query($db, $sql);
    $row    = mysqli_fetch_assoc($result);
    if ( NULL == $row ) {
        echo "<script>location.href='./board_list_3.php'</script>";
    }
?>
<h3>회원정보</h3>
<table>
    <tr>
        <td>아이디 : </td>
        <td><?=$row['user_id'];?></td>
    </tr>
    <tr>
        <td>이름 : </td> 
        <td><?=$row['user_name'];?></td>
    </tr>
    <tr>
        <td>연락처 : </td>
        <td><?=$row['user_phone'];?></td>
    </tr>

</table>

<input type="button" onclick="history.back()" value="이전">
<a href="./b_modify.php?idx=<?=$idx?>">수정</a>

<?php 
    include "./function.php";?>
