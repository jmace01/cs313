<%@ page language="java" contentType="text/html; charset=US-ASCII"
    pageEncoding="US-ASCII"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
<title>Insert title here</title>
</head>
<body>

    <p>Welcome ${username} | <a href="./makepost.jsp">Add a Post</a> | <a href="./Logout">Log Out</a></p>
    <h1>Posts</h1>
<c:forEach items="${posts}" var="aPost">
    <p>
        <b>${aPost.username}</b><br />
        <i>${aPost.date}</i><br />
        ${aPost.postData}
    </p>
</c:forEach>

</body>
</html>