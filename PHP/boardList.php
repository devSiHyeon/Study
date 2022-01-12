
<?php 
    require_once "./header.php";

    $No   = 1;
    if (isset ($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // paging
        // total list 
        $sql_total	 	= "SELECT COUNT(idx) FROM member_detail";
        $result_total	= mysqli_query ($db, $sql_total);
        $row            = mysqli_fetch_array($result_total);
        $row_total 	    = $row[0];  // DB row
        
        // now page        
        $page_list 	= 5;                            // 한 페이지에 몇 개의 row가 들어가는지
        $block_cnt	= 3;                            // 한 블록에 몇 개가 들어가는지
        $block		= ceil($page / $block_cnt);     // 블록 단위
        
        $page_start  = ($page - 1) * $page_list;  

        $block_start	= (($block -1 ) * $block_cnt ) + 1;
        $block_end	    = $block_start + $block_cnt -1 ;
        
        $total_page     = ceil($row_total / $page_list);    // 총 페이지 개수
        $total_block    = ceil($total_page / $block_cnt);   // 총 블록의 개수  

        // 블록 마지막 번호
        if($block_end > $total_page) {
            $block_end = $total_page;
        }

    // list
        $sql_list   = "SELECT `member_idx`, `user_name`, `user_id`, `user_phone` 
                    FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx 
                    ORDER BY user_name ASC, user_id ASC Limit $page_start, $page_list";
        $result_list    = mysqli_query($db, $sql_list);
        
    // No 순번 역순    
    $No  = $row_total-(($page-1) * $page_list);             // DB 내용 시작 번호
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
