<%@ page language="java" contentType="text/html; charset=UTF-8"%>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>회사</title>
	<link href="./img/woojin.png" rel="icon" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="./css/Index.css">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet"	href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&family=Roboto&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">	

	<!-- 왼쪽화면 -->
	<div class="main_left" >
		
	</div>
	<!-- 오른쪽 화면 (로그인) -->
	<div class="main_right">
		<div class="main_right_sub">
			<form method="post" action="./login.jsp">
				<input type="text" name="user_id" placeholder="  User Id">
				<input type="text" name="passwrod" placeholder="  Password"><br><br>
				<button type="submit" class="main_button btn btn-primary" onclick="location.href='./Woo_Admin.jsp'">Login</button>
				<button type="button" data-toggle="modal" data-target="#JoinModal" class="main_button btn btn-success">Join</button>
			</form>
		</div>
	</div>
	
	
	<!-- Join 모달창 -->
	
		<div class="modal" id="JoinModal" tabindex="-1">
			  <div class="modal-dialog">
				    <div class="modal-content">
   					 <form method="post" action="joinPro.jsp">
				      <div class="modal-header">
					        <h5 class="modal-title">사용자 등록</h5>
				      </div>
					      <div class="modal-body">
						      	<div>
						        	<label>ID</label>
						        	<input type="text" name="user_id" maxlength="15">
						      	</div>
						      	<div>
						        	<label>비밀번호</label>
						        	<input type="password" name="password" minlength="6" maxlength="20">
						      	</div>
						      	<div>
						        	<label>성명</label>
						        	<input type="text" name="user_name" maxlength="30">
						      	</div>
						      	<div>
						        	<label>부서</label>
						        	<select name="dept">	
						        		<option value="임원">임원</option>
						        		<option value="경영지원팀">경영지원팀</option>
						        		<option value="개발부">개발부</option>
						        		<option value="생산부">생산부</option>
						        		<option value="연구소">연구소</option>
						        	</select>
						      	</div>
						      	<div>
						        	<label>직책</label>
						        	<select name="position">
						        		<option value="대표이사">대표이사</option>
						        		<option value="이사">이사</option>
						        		<option value="차장">차장</option>
						        		<option value="과장">과장</option>
						        		<option value="대리">대리</option>
						        		<option value="사원">사원</option>
						        	</select>
						      	</div>
						      	<div>
						        	<label>E-mail</label>
						        	<input type="text" name="e_mail" placeholder=" __ @__ 형식으로 입력하세요">
						      	</div>
						      	<div>
						        	<label>연락처</label>
						        	<input type="text" name="tell" placeholder=" 숫자만 입력하세요" maxlength="20">
						      	</div>
					      </div>
					      <div class="modal-footer">
						        <button type="submit" class="btn btn-info">확인</button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">취소</button>
					      </div>
	</form>
				    </div>
			  </div>
		</div>
	
</div>

<!-- Optional JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script	src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
</body>
</html>