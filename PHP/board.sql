create table inquiry_board (								
								
	idx		        int (11)		unsigned			        not null	autoincrement   comment	 '고유번호',
	mb_no		      int (11)		unsigned			        not null	                comment	 '작성자 기본키'		
	mb_id		      varchar (20)					            not null	                comment	 '작성자 아이디',
	title		      varchar (50)					            not null	                comment	 '제목',
	memo		      text						                  not null	                comment	 '문의 내용',
	ip	      	  int (11)		unsigned			        not null	                comment	 '작성자 ip',
	create_date	  timestamp					                not null	                comment	 '작성시간',
	update_date	  timestamp	default (0000-00-00 00:00:00)	not null	          comment	 '수정시간',		
  
  	PRIMARY KEY (idx)							
)ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT '게시글';	
  
  
  create table reply (
	idx		        int (11)		unsigned		  not null	autoincrement comment	 '고유번호'	,
  board_idx     int (11)		unsigned			not null	              comment	 '게시글 기본키',
  seq           tinyint                   not null                comment  '순번',
  depth         tinyint                   not null                comment  '깊이',
	reply		      text						          not null	              comment	 '답변',
	reply_no		  int (11)		unsigned			not null	              comment	 '답변자 기본키',
	reply_company	varchar(50)					      not null	              comment	 '답변자 이름',
	reply_ip		  int (11)		unsigned			not null	              comment	 '답변자 ip',
	update_ip	    int (11)		unsigned			not null	              comment	 '수정자 ip',
	reply_date	  timestamp	              	not null	              comment	 '답변시간',
	update_date	  timestamp	default (0000-00-00 00:00:00)	not null	comment	 '수정시간',		
								
	PRIMARY KEY (idx)							
)ENGINE=MYISAM DEFAULT CHARSET=utf8 COMMENT '답변';
