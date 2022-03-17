<div class='delivery_ul'>
	<ul>
		<?php
			if($record_count == 0) {
		?>
				<li colspan="<?=$colspan?>" class="center">등록된 데이터가 없습니다.</li>
		<?php
			} else {
				for ($i=0; $list=sql_fetch_array($result); $i++) {	?>
					<li class="checkbox_ok <?= ($list['check_id']=='1') ? 'delivery_check' : ''?>">
						<div class='delivery_num'><?=get_string($list['de_id'])?></div>
						<label class='delivery_ok'>
							<input type="checkbox" class='delivery' name="chklist" value="<?=get_string($list['de_id'])?>" <?=$list['check_id']=='1' ? 'checked="checked"':"";?> /><?=get_string($list['de_name'])?>
						</lab>
					</li>
		<?php
				} // end
			}
		?>
	</ul>
</div>


<script>
  //--------------------------------------------------------------------
  // 체크박스 이벤트 발생 
  //--------------------------------------------------------------------
  let checkbox_li = document.getElementsByClassName('checkbox_ok'),
    check = document.getElementsByClassName('delivery');

  for (let i = 0; i < check.length; i++){
    checkbox_li[i].addEventListener('click',function(){

      if (check[i].checked == true) {
        checkbox_li[i].classList.add('delivery_check');
      }
      if (check[i].checked == false) {
        checkbox_li[i].classList.remove('delivery_check');
      }
    });
  }
</script>
