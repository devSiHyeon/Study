<?php 
    function paging ($page, $page_list, $block_cnt, $total_row){
                // 현재페이지, 페이지수,    블록수,   전체 게시글 수
    
    // 페이징
        // 페이징 기본 list, bolck 지정             
        $page_total     = ceil($total_row / $page_list);
        $block_total    = ceil($page_total / $block_cnt);
        
        // 페이지 예외 숫자 작성시 (page > 최대 페이지 ? 참일 경우 = 최대페이지 : 아닐 경우 (0보다 작은 숫자 일 경우 참 = 1 거짓 = 페이지 번호))
        $page           = $page > $page_total ? $page = $page_total : ($page < 0 ? $page = 1 : $page);

        $block		    = ceil($page / $block_cnt);     // 블록 시작 번호 구하기
        $block_start    = (($block -1) * $block_cnt)+ 1;
        $block_end      = $block_start + $block_cnt -1;
        

        // 페이지 수와 블록 수 다르게 끝나는 경우 
        if ( $block_end > $page_total) {
            $block_end = $page_total;
        }
       
        // 번호 역순으로
        $No     = $total_row-(($page -1 ) *$page_list);

        return array($No, $block_start, $block_end, $page_total);
    }
?>
