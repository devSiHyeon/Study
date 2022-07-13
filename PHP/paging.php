<?php

function paging($listPer, $listPage, $totalPage, $blockPer, $totalBlock, $page, $block, $url, $search="")
{
    // $_SERVER['QUERY_STRING'] 사용시 : company_notice_list.php & company_qna_list.php
    // (strlen($search) > 0) ? '&'.$search : $search;

    $pagingHtml = ''; 
    $page_prev = ($page == 1 || $page < 1) ? 1 : $page-1;
    $page_next = ($page == $totalPage || $page > $totalPage) ? $totalPage : $page+1;

    $beq = ceil($page / $blockPer);
    $block_start = (($beq - 1) * $blockPer) + 1;
    $block_end = (($block_start + 4) > $totalPage) ? $totalPage : $block_start + 4;
    $totalblock = ceil($totalBlock);

    $block_prev = ($page == 1 || $page < 1) ? 1 : $beq;
    $block_next = ($page == $totalPage || $page > $totalPage) ? $totalblock : $beq;

    $pagingHtml .= '<a href=\''.$url.'?page=1\' id="bg-prev-end" class="btn_page" data-lg="1" data-bg="'.$block.'"> 처음페이지 </a>';
    $pagingHtml .= '<a href=\''.$url.'?page='.$page_prev.$search.'\' id="bg-prev" class="btn_page" data-lg="'.$page_prev.'" data-bg="'.$block_prev.'"> 이전페이지 </a>';

    for($i = $block_start ; $i <= $block_end ; $i++) {
        
        if ($i == $page) {
            $pagingHtml .= '<a href=\''.$url.'?page='.$i.$search.'\' id="bgid-'.$i.'" class="bg-'.$beq.' n-block btn_page" data-bg="'.$beq.'" data-lg="'.$i.'"><strong>'.$i.'</strong></a>';
        } else {
            $pagingHtml .= '<a href=\''.$url.'?page='.$i.$search.'\' id="bgid-'.$i.'" class="bg-'.$beq.' n-block btn_page" data-bg="'.$beq.'" data-lg="'.$i.'"><span>'.$i.'</span></a>';
        }
        
    }
    
    $pagingHtml .= '<a href=\''.$url.'?page='.$page_next.$search.'\' id="bg-next" class="btn_page" data-lg="'.$page_next.'" data-bg="'.$block_next.'"> 다음페이지 </a>';
    $pagingHtml .= '<a href=\''.$url.'?page='.$totalPage.'\' id="bg-next-end" class="btn_page" data-lg="'.$totalPage.'" data-bg="'.$totalBlock.'"> 마지막페이지</a>';
        
    return $pagingHtml;
}

