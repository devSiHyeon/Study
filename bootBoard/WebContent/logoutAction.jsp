<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>로그아웃 데이터 처리</title>
</head>
<body>
<%
	session.invalidate();
	out.println("<script>");
	out.println("location.href='main.jsp'");
	out.println("</script>");
%>
</body>
</html>