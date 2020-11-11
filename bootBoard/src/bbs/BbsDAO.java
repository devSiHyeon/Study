package bbs;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Vector;

import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;

public class BbsDAO {
	private Connection conn;
	private PreparedStatement pstmt;
	private ResultSet rs;

	public BbsDAO() {
		try {
			Context init = new InitialContext();
			DataSource ds = (DataSource) init.lookup("java:comp/env/jdbc/bbsDB");
			conn = ds.getConnection();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void connClose() {
		try {
			if (rs != null)
				rs.close();
			if (pstmt != null)
				pstmt.close();
			if (conn != null)
				conn.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	public String getDate() {
		String sql = "SELECT NOW()";
		try {
			PreparedStatement pstmt = conn.prepareStatement(sql);
			rs = pstmt.executeQuery();
			if (rs.next()) {
				return rs.getString(1);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}

		return ""; // 데이터베이스 오류 코드
	}

	public int getNext() {
		String sql = "SELECT bbsId FROM bbs ORDER BY bbsId DESC";
		try {
			PreparedStatement pstmt = conn.prepareStatement(sql);
			rs = pstmt.executeQuery();
			if (rs.next()) {
				return rs.getInt(1) + 1;
			}
			return 1; // 첫 번째 게시물
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return -1; // 데이터베이스 오류 코드
	}

	public int write(String bbsTitle, String userId, String bbsContent) {
		String sql = "INSERT INTO BBS VALUES (?, ?, ?, ?, ?, ?)";
		try {
			PreparedStatement pstmt = conn.prepareStatement(sql);
			pstmt.setInt(1, getNext());
			pstmt.setString(2, bbsTitle);
			pstmt.setString(3, userId);
			pstmt.setString(4, getDate());
			pstmt.setString(5, bbsContent);
			pstmt.setInt(6, 1);
			return pstmt.executeUpdate();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return -1; // 데이터 베이스 오류 코드
	}

	public Vector<Bbs> getList(int pageNumber) {
		String sql = "SELECT * FROM bbs WHERE bbsId < ? AND bbsAvailable = 1 ORDER BY bbsId DESC LIMIT 10";
		Vector<Bbs> list = new Vector<Bbs>();
		try {
			PreparedStatement pstmt = conn.prepareStatement(sql);
			pstmt.setInt(1, getNext() - (pageNumber - 1) * 10);
			rs = pstmt.executeQuery();
			while (rs.next()) {
				Bbs bbs = new Bbs();
				bbs.setBbsId(rs.getInt(1));
				bbs.setBbsTitle(rs.getString(2));
				bbs.setUserId(rs.getString(3));
				bbs.setBbsDate(rs.getString(4));
				bbs.setBbsContent(rs.getString(5));
				bbs.setBbsAvailable(rs.getInt(6));
				list.add(bbs);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return list;
	}
	
	public boolean nextPage(int pageNumber) {
		String sql= "SELECT * FROM bbs WHERE bbsId < ? AND bbsAvailable=1";
		try {
			PreparedStatement pstmt = conn.prepareStatement(sql);
			pstmt.setInt(1, getNext() - (pageNumber - 1) * 10);
			rs = pstmt.executeQuery();
			while (rs.next()) {
				return true;
			}
		}catch (SQLException e) {
			e.printStackTrace();
		}
		return false;
	}
}
