package user;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;

public class UserDAO {
	private Connection conn;
	private PreparedStatement pstmt;
	private ResultSet rs;
	
	public UserDAO() {
		try {
			Context init=new InitialContext();
			DataSource ds =(DataSource) init.lookup("java:comp/env/jdbc/bbsDB");
			conn = ds.getConnection();
		} catch(Exception e) {
			e.printStackTrace();
		}
	}
public void connClose() {
	try {
		if(rs!=null)rs.close();
		if(pstmt!=null)pstmt.close();
		if(conn!=null)conn.close();
	}catch(SQLException e) {
		e.printStackTrace();
	}
}

public int login(String userId, String userPassword) {
	String sql="SELECT userPassword FROM user WHERE userId=?";
	try {
		pstmt = conn.prepareStatement(sql);
		pstmt.setString(1, userId);
		rs=pstmt.executeQuery();
		if(rs.next()) {
			if(rs.getString(1).equals(userPassword)) {
				return 1;
			}else {
				return 0;
			}
		}
		return -1;
	}catch (SQLException e) {
		e.printStackTrace();
			}
	return -2;
		}

public int join(User user) {
	String sql="INSERT INTO user VALUES (?,?,?,?,?)";
	try {
		pstmt = conn.prepareStatement(sql);
		pstmt.setString(1, user.getUserId());
		pstmt.setString(2, user.getUserPassword());
		pstmt.setString(3, user.getUserName());
		pstmt.setString(4, user.getUserGender());
		pstmt.setString(5, user.getUserEmail());
		
		return pstmt.executeUpdate();
	} catch (SQLException e) {
		e.printStackTrace();
	}
	return -1;
}
}
	