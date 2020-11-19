package dao;

import static db.JdbcUtil.*;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

import javax.sql.DataSource;

import vo.BoardBean;

public class BoardDAO {

	DataSource ds;
	Connection con;
	private static BoardDAO boardDAO;
	
	private BoardDAO () {
		
	}
	public static BoardDAO getInstance() {
		if(boardDAO == null) {
			boardDAO = new BoardDAO();
		}
		return boardDAO;
	}
	public void setConnection(Connection con) {
		this.con = con;
	}
	
	//글의 개수 구하기
	public int selectListCount() {
		int listCount = 0;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		
		try {
			pstmt = con.prepareStatement("select count(*) from board");
			rs=pstmt.executeQuery();
			
			if(rs.next()) {
				listCount=rs.getInt(1);
			}
			
		}catch(Exception ex) {
			System.out.println("getListCount 에러: " +ex);
		}finally {
			close(rs);
			close(pstmt);
		}
		return listCount;
	}
	
	//글 목록 보기
	public ArrayList<BoardBean> selectArticleList(int page,int limit) {
		
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		String board_list_sql="select * from board order by BOARD_RE_REF desc, BOARD_RE_SEQ asc limit ?,?";
		ArrayList<BoardBean> articleList = new ArrayList<BoardBean> ();
		BoardBean board = null;
		int startrow=(page-1) *10; // 읽기 시작할 row번호
		
		try {
			pstmt = con.prepareStatement(board_list_sql);
			pstmt.setInt(1, startrow);
			pstmt.setInt(2, limit);  
			rs = pstmt.executeQuery();
			while(rs.next()) {
				board = new BoardBean();
				board.setBoard_num(rs.getInt("BOARD_NUM"));
				board.setBoard_name(rs.getString("BOARD_NAME"));
				board.setBoard_subject(rs.getString("BOARD_SUBJECT"));
				board.setBoard_content(rs.getString("BOARD_CONTENT"));
				board.setBoard_file(rs.getString("BOARD_FILE"));
				board.setBoard_re_ref(rs.getInt("BOARD_RE_REF"));
				board.setBoard_re_lev(rs.getInt("BOARD_RE_LEV"));
				board.setBoard_readcount(rs.getInt("BOARD_READCOUNT"));
				board.setBoard_date(rs.getDate("BOARD_DATE"));
				articleList.add(board);
 			}
		}catch (Exception ex) {
			System.out.println("getBoardList 에러 : " + ex);
		}finally {
			close(rs);
			close(pstmt);
		}
		return articleList;
	}
	
	//글 내용 보기
	public BoardBean selectArticle(int board_num) {
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		BoardBean boardBean = null;
		
		try {
			pstmt = con.prepareStatement("select * from board where BOARD_NUM = ?");
			pstmt.setInt(1,  board_num);
			rs=pstmt.executeQuery();
			
			if(rs.next()) {
				boardBean = new BoardBean();
				boardBean.setBoard_num(rs.getInt("board_num"));
				boardBean.setBoard_name(rs.getString("board_name"));
				boardBean.setBoard_subject(rs.getString("board_subject"));
				boardBean.setBoard_content(rs.getString("board_content"));
				boardBean.setBoard_file(rs.getString("board_file"));
				boardBean.setBoard_re_ref(rs.getInt("board_re_ref"));
				boardBean.setBoard_re_lev(rs.getInt("board_re_lev"));
				boardBean.setBoard_readcount(rs.getInt("board_readcount"));
				boardBean.setBoard_date(rs.getDate("board_date"));
			}
		}catch(Exception ex) {
			System.out.println("getDetail 에러 : " + ex);
		}finally {
			close(rs);
			close(pstmt);
		}
		return boardBean;
	}
	
	//글 등록
	public int insertArticle (BoardBean article) {
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		int num = 0;
		String sql= "";
		int insertCount=0;
		
		try {
			pstmt=con.prepareStatement("select max(board_num) from board");
			rs=pstmt.executeQuery();
			
			if(rs.next())
				num=rs.getInt(1)+1;
			else
				num=1;
			sql="insert into board values(?,?,?,?,?,?,?,?,?,?,now())";
			
			pstmt = con.prepareStatement(sql);
			pstmt.setInt(1, num);
			pstmt.setString(2, article.getBoard_name());
			pstmt.setString(3, article.getBoard_pass());
			pstmt.setString(4, article.getBoard_subject());
			pstmt.setString(5, article.getBoard_content());
			pstmt.setString(6, article.getBoard_file());
			pstmt.setInt(7, num);
			pstmt.setInt(8, 0);
			pstmt.setInt(9, 0);
			pstmt.setInt(10, 0);
			
			insertCount=pstmt.executeUpdate();
		}catch(Exception ex) {
			System.out.println("boardInsert 에러 : " + ex);
		}finally {
			close(rs);
			close(pstmt);
		}
		return insertCount;
	}
	public int updateReadCount(int board_num) {

		PreparedStatement pstmt = null;
		int updateCount = 0;
		String sql = "update board set board_readcount = + board_readcount +1 where board_num =?";
		
		try {
			pstmt=con.prepareStatement(sql);
			pstmt.setInt(1, board_num);
			updateCount = pstmt.executeUpdate();
		}catch(Exception ex) {
			System.out.println("setReadCountUpdate 에러 : " + ex);
		}
		finally {
			if(pstmt !=null) close(pstmt);
		}
		return updateCount;
	}
	public int insertReplyArticle(BoardBean article) {
		
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		String board_max_sql="select max(board_num) from board";
		String sql="";
		int num=0;
		int insertCount = 0;
		int re_ref=article.getBoard_re_ref();
		int re_lev=article.getBoard_re_lev();
		int re_seq=article.getBoard_re_seq();
		
		try {
			pstmt=con.prepareStatement(board_max_sql);
			rs = pstmt.executeQuery();
			if(rs.next())num = rs.getInt(1)+1;
			else num =1;
			sql="update board set board_re_seq=board_re_seq+1 where board_re_ref=? and board_re_seq>?";
			pstmt=con.prepareStatement(sql);
			pstmt.setInt(1, re_ref);
			pstmt.setInt(2, re_seq);
			int updateCount=pstmt.executeUpdate();
			
			if(updateCount>0) {
				commit(con);
			}
			re_seq=re_seq +1;
			re_lev = re_lev+1;
			sql="insert into board values(?,?,?,?,?,?,?,?,?,?,now())";
			pstmt = con.prepareStatement(sql);
			pstmt.setInt(1, num);
			pstmt.setString(2,article.getBoard_name());
			pstmt.setString(3,article.getBoard_pass());
			pstmt.setString(4,article.getBoard_subject());
			pstmt.setString(5,article.getBoard_content());
			pstmt.setString(6,"");  //답장에는 파일을 업로드하지 않음
			pstmt.setInt(7,  re_ref);
			pstmt.setInt(8, re_lev);
			pstmt.setInt(9, re_seq);
			pstmt.setInt(10, 0);
			insertCount = pstmt.executeUpdate();
		}catch(Exception ex) {
			System.out.println("boardReply 에러 : " +ex);
		}finally {
			close(rs);
			close(pstmt);
		}
		return insertCount;
	}
}
