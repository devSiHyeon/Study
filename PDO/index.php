<?php  require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/header.php');
    if( isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0){
?>
    <ul>
        <li></li>
        <li><a href="./member.php">회원목록 (관리자 member) </a> : 함수 사용 & 수정 & 삭제 & 댓글</li>
        <li><a href="./privacy.php">회원수정 (개인) </a> : 관리자, 회원 구분</li>
        <li><a href="./boardlist.php">게시판 </a></li> 
    </ul>
<?php    } else { ?>

    <h3>회원가입</h3>
    <form action="./process/join.php" method="POST" onsubmit="return join_check();">                
        <input type="text" name="user_name" value="" placeholder="이름" required>    
        <input type="text" id="user_id" name="user_id" value="" class="id_width" placeholder="아이디 : 8~20자 첫글자는 영어로 작성해주세요" required>
        <input type="password" name="user_pw" value="" placeholder="비밀번호" required>    
        <input type="text" name="user_phone" value="" placeholder="연락처 : 숫자만 입력하세요" required>    
        <input type="submit" value="회원가입">            
    </form>

    <h3>로그인</h3>
    <form action="./process/login.php" method="POST">
        아이디 : <input type="text" name="user_id" value="" required>
        비밀번호 : <input type="password" name="user_pw" value="" required>
        <input type="submit" value="로그인">
    </form>
<?php } 
    require_once ($_SERVER['DOCUMENT_ROOT'].'/pdo/footer.php'); 
?>
