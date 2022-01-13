
<?php 
    require_once "./header.php";

    // 페이지 가져오기
        /* 기본 페이지 
            if (isset ($_GET['page'])){ 
                $page = $_GET['page'];
            } else {
                $page = 1;
            } 
        */

        // 페이지 응용
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;      // 주소창에 문자, 소수점 작성 방지하기 위해 무조건 int 형으로 바꿔준다

        /* 
            if (isset ($_GET['page'])){ 
                $type = is_numeric($_GET['page']);
                $page = ( $type == false ? 1 : $_GET['page']);
            } else {
                $page = 1;
            }
        */ 
        
    // 페이징
        // 페이징 기본 list, bolck 지정       
        $page_list 	= 5;                            // 한 페이지에 몇 개의 row가 들어가는지
        $block_cnt	= 3;                            // 한 블록에 몇 개가 들어가는지
        
        $total_sql	 	= "SELECT COUNT(idx) FROM member_detail";
        $total_result	= mysqli_query ($db, $total_sql);
        $row     	    = mysqli_fetch_array($total_result);  // DB row
        $total_row      = $row[0];
        
        $page_total     = ceil($total_row / $page_list);
        $block_total    = ceil($page_total / $block_cnt);
        
        
        // 페이지 예외 숫자 작성시 (page > 최대 페이지 ? 참일 경우 = 최대페이지 : 아닐 경우 (0보다 작은 숫자 일 경우 참 = 1 거짓 = 페이지 번호))
        $page = $page > $page_total ? $page = $page_total : ($page < 0 ? $page = 1 : $page);

        $list_start     = ($page-1) * $page_list;   // 순차적인 글 목록

        $block		    = ceil($page / $block_cnt);     // 블록 시작 번호 구하기
        $block_start    = (($block -1) * $block_cnt)+ 1;
        $block_end      = $block_start + $block_cnt -1;

        // 페이지 수와 블록 수 다르게 끝나는 경우 
        if ( $block_end > $page_total) {
            $block_end = $page_total;
        }

        $list_sql   = "SELECT `member_idx`, `user_name`, `user_id`, `user_phone` 
                    FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx 
                    ORDER BY user_name ASC, user_id ASC  LIMIT $list_start,  $page_list";
        $list_result    = mysqli_query($db, $list_sql);
        
        // 번호 역순으로
        $No     = $total_row-(($page -1 ) *$page_list);

?>    
<a href="./index.php">메인</a>
    <table>
        <tr>
            <td>No</td>
            <td>아이디</td>
            <td>이름</td>
            <td>연락처</td>
        </tr>
    <?php     while ($row_list= mysqli_fetch_array($result_list)) {   ?> 
        <tr>
            
            <td><?= $No--?></td>
            <td><?= $row_list['user_id'];?></td>
            <td><?= $row_list['user_name'];?></td>
            <td><?= $row_list['user_phone'];?></td>
        </tr>
    <?php    } ?>
    </table>
    <?php 
            // 처음
            if($page >= 1){
                echo "<a href='./board_list.php?page=1'>처음  </a>";
            }

            // 이전 
            if($page > 1){
                $pre = $page -1 ;
                    echo "<a href='./board_list.php?page=$pre'><  </a>";
            }
            
            // 숫자
            for($i = $block_start; $i <= $block_end ; $i++){
                if($page == $i){
                    echo "<b>$i</b>";
                } else {
                    echo "<a href='./board_list.php?page=$i'>$i </a>";
                }
            }

            // 다음
            if($page < $total_page){
                $next = $page +1 ;
                    echo "<a href='./board_list.php?page=$next'> >  </a>";
            }

            // 마지막
            if($page <= $total_page){
                echo "<a href='./board_list.php?page=$total_page'> 마지막</a>";
            }
     require_once "./footer.php"; 
     ?>    
