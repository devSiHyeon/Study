package svc;

import java.sql.Connection;
import dao.BoardDAO;
import static db.JdbcUtil.*;
import vo.BoardBean;

public class BoardWriteProService {
	;

	public boolean registArticle(BoardBean boardBean) {

		boolean isWriteSuccess = false;
		Connection con = getConnection();
		BoardDAO boardDAO = BoardDAO.getInstance();
		boardDAO.setConnection(con);
		int insertCount = boardDAO.insertArticle(boardBean);

		if (insertCount > 0) {
			commit(con);
			isWriteSuccess = true;
		} else {
			rollback(con);
		}
		close(con);
		return isWriteSuccess;
	}

}
