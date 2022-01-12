
<?php       
    require_once "./header.php";
    if( isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0){
        echo $_SESSION['user_id']."님 환영합니다";
?>

        <a href="./logout.php">로그아웃</a>  <br>
        <a href="./board_list.php">회원목록</a>         
        
<?php    } else { ?>

    <h3>회원가입</h3>
    <form action="./joinProcess.php" method="POST">                
        <input type="text" name="user_name" value="" placeholder="이름" required>    
        <input type="text" id="user_id" name="user_id" value="" class="id_width" placeholder="아이디 : 8~20자 첫글자는 영어로 작성해주세요" required>
        <input type="password" name="user_pw" value="" placeholder="비밀번호" required>    
        <input type="text" name="user_phone" value="" placeholder="연락처 : 숫자만 입력하세요" required>    
        <input type="submit" value="회원가입">            
    </form>

    <h3>로그인</h3>
    <form action="./loginProcess.php" method="POST">
        아이디 : <input type="text" name="user_id" value="" required>
        비밀번호 : <input type="password" name="user_pw" value="" required>
        <input type="submit" value="로그인">
    </form>
<?php } 
    require_once "./footer.php";
?>
