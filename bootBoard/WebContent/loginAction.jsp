<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
 <%@ page import="user.UserDAO, javax.naming.*"%>
 <% request.setCharacterEncoding("UTF-8"); %>
 <jsp:useBean id="user" class="user.User" scope="page"/>
 <jsp:setProperty name="user" property="userId"/>
 <jsp:setProperty name="user" property="userPassword"/>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>로그인 데이터 처리</title>
</head>
<body>
<%
	UserDAO userDAO=new UserDAO();
	int result = userDAO.login(user.getUserId(), user.getUserPassword());
	userDAO.connClose();
	if(result == 1) {
		session.setAttribute("userId", user.getUserId()); 	//세션 아이디 저장
		out.println("<script>");
		out.println("location.href='main.jsp'");
		out.println("</script>");
	} else if(result == 0) {
		out.println("<script>");
		out.println("alert('비밀번호가 틀립니다.')");
		out.println("history.back()");
		out.println("</script>");
	} else if(result == -1){
		out.println("<script>");
		out.println("alert('아이디가 존재하지 않습니다.')");
		out.println("histroy.back()");
		out.println("</script>");
	} else if(result == -2) {
		out.println("<script>");
		out.println("alert('데이터베이스 오류가 발생하였습니다.')");
		out.println("history.back()");
		out.println("</script>");
	}

%>
</body>
</html>