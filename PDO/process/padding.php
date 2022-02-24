<?
	function _paging($current,$offset,$block,$tcount, $qrst, $fisrt = true, $last= true, $next=true, $prev=true){
	// current = 현재 페이지 ,$offset = 리스트수 , block = 보여줄 페이지 수 , tcount = 전체 row수, qrst = query string

		if($tcount <= 0) return;

		$ap		= ceil($tcount/$offset);									// 전체 페이지 수
		$cp		= ceil($current/$block);									// 현재 페이지 블럭 번호
		$tp		= ceil($ap/$block);											// 토탈 페이지 블럭 수
		$fp		= ($cp * $block) - ($block-1);								// 첫번째 페이지
		$np		= (($s=(($cp + 1) *$block)-($block-1)) > $ap)?$ap:	$s;		// 다음 블럭 전체 수를 초과할경우 전체 페이지 수로..
		$pp		= (($s = (($cp - 1) *$block)) > 0)? $s : 1;					// 이전 블럭 0보다 작을 경우 1로 고정
		$ui		= '';														// page ui value;
		
		if($cp == $tp)		$lp =  $ap;
		else				$lp = ($cp*$block); // 마지막 페이지

		$uri = $_SERVER['PHP_SELF'].'?';
		$uri .= (strlen($qrst)>0)? $qrst.'&page=':'page=';

		if($fisrt === true)			$ui.= '<a href="'.$uri.'1" class="a-page-fl a-page-f">◀◀</a>';
		
		if($prev===true)			$ui.= '<a href="'.$uri.$pp.'" class="a-page-pn a-page-p">이전</a>';
		
		for($i=$fp;$i<=$lp;$i++){
			if($i==$current)		$ui.= '<a href="" class="a-page-c a-page">'.$i.'</a>';
			else					$ui.= '<a href="'.$uri.$i.'" class="a-page">'.$i.'</a>';
		}
		
		if($next===true)			$ui.= '<a href="'.$uri.$np.'" class="a-page-pn a-page-n">다음</a>';
		
		if($last === true)			$ui.= '<a href="'.$uri.$ap.'"class="a-page-fl a-page-l">▶▶</a>';

		return $ui;
	}

	function sum ($a, $b){
		echo $a + $b;
		return $a;
	}
?>