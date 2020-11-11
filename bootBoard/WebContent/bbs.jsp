<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
 <%@ page import = "bbs.BbsDAO, bbs.Bbs, java.util.Vector" %>
<% 
	String id = (String)session.getAttribute("userId");
	String opt = "";
	if(id == null) {
		opt = " disabled";
	}
%>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" />

    <title>JSP 게시판</title>
  </head>
  <body>
	<nav class="navbar navbar-expand-sm navbar-light bg-light">
		<a class="navbar-brand" href="main.jsp">JSP 게시판</a>
		<!--  햄버거 버튼  -->
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent" aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link " href="main.jsp">메인</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="bbs.jsp">게시판<span class="sr-only">(current)</span></a>
				</li>	
			</ul>		
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDrodown"
					role="button" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">접속하기</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
<%
	if(id == null) {
%>					
						<a class="dropdown-item " href="login.jsp">
						로그인
						</a>
						<div class="dropdown-drivider"></div>
						<a class="dropdown-item"  href="join.jsp">회원가입</a>
<% 
	} else {
%>
						<a class="dropdown-item"  href="logoutAction.jsp">로그아웃</a>

<% 
	}
%>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	
	<div class="container pt-3">
			<table class="table table-striped text-center">
				<thead class="thead-light">
					<tr>
						<th>번호</th>
						<th>제목</th>
						<th>작성자</th>
						<th>작성일</th>
					</tr>
				</thead>
				<tbody>
<%
				int pageNumber = 1;
				if (request.getParameter("pageNumber") !=null) {
				pageNumber = Integer.parseInt(request.getParameter("pageNumber"));
				}
				BbsDAO bbsDAO = new BbsDAO();
				Vector<Bbs> list = bbsDAO.getList(pageNumber);
				for(int i = 0; i < list.size(); i++) {
%>
				<tr>
					<td><%= list.get(i).getBbsId() %></td>
					<td><a href="view.jsp?bbsId=<%=list.get(i).getBbsId() %>">
						<%= list.get(i).getBbsTitle() %>
						</a></td>
					<td><%= list.get(i).getUserId() %></td>
					<td><%= list.get(i).getBbsDate() %></td>
				</tr>
<%
				}
%>				
				</tbody>
			</table>
<%
	if(pageNumber != 1) {
%>
	<a href="bbs.jsp?pageNumber=<%=pageNumber -1 %>"class="btn btn-success mr-1">이전</a>
<%
	}
	if(bbsDAO.nextPage(pageNumber+1)){
%>
	<a href="bbs.jsp?pageNumber=<%=pageNumber + 1 %>" class="btn btn-success">다음</a>
<%
	}	
	bbsDAO.connClose();
%>
	<a href="write.jsp" class="btn btn-primary float-right<%=opt %>" id="writeBtn" >글쓰기</a>
	</div>	
	 <!--     Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" ></script>
   
  </body>
</html>