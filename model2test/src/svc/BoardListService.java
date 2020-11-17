package svc;

import static db.JdbcUtil.*;
import java.sql.Connection;
import java.util.ArrayList;

import dao.BoardDAO;
import vo.BoardBean;

public class BoardListService {
	//articleList - 글의 모든 정보 가지고 있음

	public int getListCount() throws Exception{
		int listCount = 0;
		Connection con = getConnection();
		BoardDAO boardDAO = BoardDAO.getInstance();
		boardDAO.setConnection(con);
		listCount=boardDAO.selectListCount();
		close(con);
		return listCount;
	}
	
	public ArrayList<BoardBean> getArticleList(int page, int limit)
	throws Exception{
		
		ArrayList<BoardBean> articleList=null;
		Connection con = getConnection();
		BoardDAO boardDAO = BoardDAO.getInstance();
		boardDAO.setConnection(con);
		articleList = boardDAO.selectArticleList(page, limit);
		close(con);
		return articleList;
	}
	
}
