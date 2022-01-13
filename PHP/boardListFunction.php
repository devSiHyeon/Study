<?php 
    require_once "./header.php";
    include_once "./function.php";
    
    //($page, $page_list, $block_cnt, $total_row){
    // 현재페이지, 페이지수,   블록수,   전체 게시글 수
       
    if (isset($_GET['page'])){
        $page = $_GET['page'] == 0 ? 1 : (int)$_GET['page'];
    } else {
        $page = 1;
    } 
    
    $total_sql	 	= "SELECT COUNT(idx) FROM member_detail";
    $total_result	= mysqli_query ($db, $total_sql);
    $row     	    = mysqli_fetch_array($total_result);  // DB row
    $total_row      = $row[0];
    $page_list      = 3;
    
    $list_start     = ($page-1) * $page_list;   // 순차적인 글 목록

    // 함수 적용
    $paging         = paging($page, 5, $page_list, $total_row);
     // 현재페이지, 페이지수,   블록수,  전체 게시글 수, 게시판 list
     
     var_dump ($paging);
    
     $list_sql   = "SELECT `member_idx`, `user_name`, `user_id`, `user_phone` 
             FROM member_detail INNER JOIN member ON member_detail.member_idx = member.idx 
             ORDER BY user_name ASC, user_id ASC  LIMIT $list_start, $page_list";
            
    $list_result    = mysqli_query($db, $list_sql);
?>    

<a href="./index.php">메인</a>
    <table>
        <tr>
            <td>No</td>
            <td>아이디</td>
            <td>이름</td>
            <td>연락처</td>
        </tr>
    <?php     while ($list_row= mysqli_fetch_array($list_result)) {   ?> 
        <tr>
            <td><?= $paging[0]--?></td>
            <td><?= $list_row['user_id'];?></td>
            <td><?= $list_row['user_name'];?></td>
            <td><?= $list_row['user_phone'];?></td>
        </tr>
    <?php    } ?>
    </table>
    <?php 
        $block_start    = $paging[1];
        $block_end      = $paging[2];
        $page_total     = $paging[3];

        // 처음
        if($page >= 1){
            echo "<a href='./board_list_3.php?page=1'>처음  </a>";
        }

        // 이전 
        if($page > 1){
            $pre = $page -1 ;
                echo "<a href='./board_list_3.php?page=$pre'><  </a>";
        }
        
        // 숫자
        for($i = $block_start; $i <= $block_end ; $i++){
            if($page == $i){
                echo "<a href='./board_list_3.php?page=$i'><b>$i</b></a>";
            } else {
                echo "<a href='./board_list_3.php?page=$i'>$i </a>";
            }
        }

        // 다음
        if($page < $page_total){
            $next = $page +1 ;
                echo "<a href='./board_list_3.php?page=$next'> >  </a>";
        }

        // 마지막
        if($page <= $page_total){
            echo "<a href='./board_list_3.php?page=$page_total'> 마지막</a>";
        }
        require_once "./footer.php"; 
    ?>    
