<?php 
    function paging ($page, $page_list, $block_cnt, $total_row){
                // 현재페이지, 페이지수,    블록수,   전체 게시글 수
    
    // 페이징
        // 페이징 기본 list, bolck 지정             
        $page_total     = ceil($total_row / $page_list);
        $block_total    = ceil($page_total / $block_cnt);
        $block		    = ceil($page / $block_cnt);     // 블록 시작 번호 구하기
        $block_start    = (($block -1) * $block_cnt)+ 1;
        $block_end      = $block_start + $block_cnt -1;
        
        // 페이지 예외 숫자 작성시 (page > 최대 페이지 ? 참일 경우 = 최대페이지 : 아닐 경우 (0보다 작은 숫자 일 경우 참 = 1 거짓 = 페이지 번호))
        $page           = $page > $page_total ? $page = $page_total : ($page < 0 ? $page = 1 : $page);
        
        // 페이지 수와 블록 수 다르게 끝나는 경우 
        if ( $block_end > $page_total)  $block_end = $page_total;

        $url = $_SERVER['PHP_SELF'];

        // 처음
        if($page >= 1)  echo "<a href='$url?page=1'>처음  </a>";
        
        // 이전 
        if($page > 1){
            $pre = $page -1 ;
                echo "<a href='$url?page=$pre'>◀  </a>";
        }
        
        // 숫자
        for($i = $block_start; $i <= $block_end ; $i++){
            if($page == $i){
                echo "<a href='$url?page=$i'><b>$i</b></a>";
            } else {
                echo "<a href='$url?page=$i'>$i </a>";
            }
        }

        // 다음
        if($page < $page_total){
            $next = $page +1 ;
                echo "<a href='$url?page=$next'> ▶  </a>";
        }

        // 마지막
        if($page <= $page_total)  echo "<a href='$url?page=$page_total'> 마지막</a>";
        
    }
?>
