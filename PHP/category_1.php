// 리스트
$sql = "SELECT *
       FROM table  WHERE 조건
    ";

    $result = sql_query($sql);
    $result2 = sql_query($sql); 

// 1차 카테고리
    $cateQ = 'SELECT * FROM category WHERE ca_depth = \'1\'';

    $cateR = sql_query($cateQ);
    $cateL = array();

  // 2차 배열
    while($row = sql_fetch_array($cateR)) {
        $cateL[$row['ca_depth']][$row['ca_id']] = $row;
    }

    // 카테고리 depth 개수에 따른 select box 
    $cateD = 'SELECT MAX(ca_depth) AS depthMax FROM category';
    $cateM = sql_query($cateD);
    $resultM = sql_fetch_array($cateM);

// 검색 카테고리
    $search_sql = array();
    
    // 2차
    if (strlen($sc_gc_id2) > 0){        

        $sql = 'SELECT * FROM category WHERE LEFT(ca_search,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'2\'';
        $search_sql[2] = DB::conn()->selectAll($sql, array($sc_gc_id1));
        
    }
    
    // 3차
    if (strlen($sc_gc_id3) > 0){        

        $sql = 'SELECT * FROM category WHERE MID(ca_search,6,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'3\'';
        $search_sql[3] = DB::conn()->selectAll($sql, array($sc_gc_id2));
        
    }
    
    //4차
    if (strlen($sc_gc_id4) > 0){        

        $sql = 'SELECT * FROM hi_category WHERE MID(ca_search,11,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'4\'';
        $search_sql[4] = DB::conn()->selectAll($sql, array($sc_gc_id3));
        
    }

<table class="form_table">
				<colgroup>
					<col width="15%">
					<col width="">
					<!-- <col width="">
					<col width=""> -->
				</colgroup>
				<tr>
					<th scope="row">
						카테고리
					</th>
          <td>
              <?php if ( isset($cateL) && ( count($cateL) > 0 ) ) { 
                  foreach ($cateL as $key => $value) {  ?>

                      <select id="sc_gc_id<?=$key?>" name="sc_gc_id<?=$key?>" data-depth="<?=$key?>" class="table_selectcss" style='width:200px;<?=($key > 1 && (strlen($sc_gc_group['sc_gc_id'.$key]) < 1 )) ? 'display:none' : ''?>'>
                          <option class="sel-cate-none" value="" <?= strlen($sc_gc_id1) == '0' ? 'selected' :''?>><?=$key?>차 카테고리선택</option>
                              <?php foreach ($value as $ske => $sval) { ?>
                                  <option class="sel-cate-<?=$sval['ca_parent']?>" value="<?=$sval['ca_id']?>" <?= $sc_gc_id1 == $sval['ca_id'] ? 'selected' :''?>> <?=$sval['ca_name']?></option>
                              <?php } ?>
              <?php 
              } 
              ?>
                  </select>
              <?php 
                  $search_id = array('','',$sc_gc_id2, $sc_gc_id3, $sc_gc_id4);

                  for( $i = $key+1; $i <= $resultM['depthMax']; $i++){


                      if(isset($search_id[$i]) && strlen($search_id[$i] ) > 0){                                    
              ?>
                      <select id = sc_gc_id<?=$i?> name = sc_gc_id<?=$i?> data-depth="<?=$i?>" class='table_selectcss' >
                          <option class="sel-cate-none" value="" style="display:inline;"><?=$i?>차 카테고리선택</option>

                          <?php foreach ($search_sql[$i] as $ske => $sval) { echo $i;?>
                              <option class="sel-cate-<?=$sval['ca_parent']?>" value="<?=$sval['ca_id']?>" <?= $search_id[$i] == $sval['ca_id'] ? 'selected' :''?>> <?=$sval['ca_name']?></option>
                          <?php } ?>
                      </select>
              <?php

                      } else {

              ?>

                          <select id = sc_gc_id<?=$i?> name = sc_gc_id<?=$i?> data-depth="<?=$i?>" class='table_selectcss' style="display:none;"></select>
              <?php 
                      }
                  }
              } ?>
					</td>
				</tr>
</table>
    
<script>
$(document).ready(function() {
    var sc_2 = document.getElementById('sc_gc_id2'),
        sc_3 = document.getElementById('sc_gc_id3'),
        sc_4 = document.getElementById('sc_gc_id4');
                    
    // 2차 카테고리 
    $('#sc_gc_id1').on('change',function(){
        var depth = $(this).data('depth');
        var child = depth+1;
        var ca_id = $(this).val();      

        $.ajax({
            url : './ajax.category_list.php',
            type : 'GET',
            data : {depth : depth, ca_id :ca_id},
            dataType:'json',
            success:function(res){
                
                if (res.depth == '2'){
                    
                    sc_2.style.display = 'inline';
                    sc_3.style.display = 'none';
                    sc_4.style.display = 'none';

                    $("select[name='sc_gc_id2']").empty();
                    
                    select = '<option class=\'sel-cate-none\' value=\'\'>2차 카테고리 선택</option>';
                    $("select[name='sc_gc_id2']").append(select);

                    for (var i = 0; i<res.result.length; i++){
                        data = '<option value=\''+res.result[i].ca_id+'\'>'+res.result[i].ca_name+'</option>';
                        $("select[name='sc_gc_id2']").append(data);
                    }
                }
               
            }
        })      


    });

    // 3차 카테고리 
    $('#sc_gc_id2').on('change',function(){
        var depth = $(this).data('depth');
        var child = depth+1;
        var ca_id = $(this).val();      

        $.ajax({
            url : './category_list.php',
            type : 'GET',
            data : {depth : depth, ca_id :ca_id},
            dataType:'json',
            success:function(res){
                
                if (res.depth == '3'){
                    
                    sc_3.style.display = 'inline';
                    sc_4.style.display = 'none';
                    $("select[name='sc_gc_id3']").empty();
                    
                    select = '<option class=\'sel-cate-none\' value=\'\'>3차 카테고리 선택</option>';
                    $("select[name='sc_gc_id3']").append(select);

                    for (var i = 0; i<res.result.length; i++){
                        data = '<option value=\''+res.result[i].ca_id+'\'>'+res.result[i].ca_name+'</option>';
                        $("select[name='sc_gc_id3']").append(data);
                    }
                }
               
            }
        })
    });

    // 4차 카테고리 
    $('#sc_gc_id3').on('change',function(){
        var depth = $(this).data('depth');
        var child = depth+1;
        var ca_id = $(this).val();      

        $.ajax({
            url : './category_list.php',
            type : 'GET',
            data : {depth : depth, ca_id :ca_id},
            dataType:'json',
            success:function(res){
                
                if (res.depth == '4'){
                    
                    sc_4.style.display = 'inline';
                    $("select[name='sc_gc_id4']").empty();
                    
                    select = '<option class=\'sel-cate-none\' value=\'\'>4차 카테고리 선택</option>';
                    $("select[name='sc_gc_id4']").append(select);

                    for (var i = 0; i<res.result.length; i++){
                        data = '<option value=\''+res.result[i].ca_id+'\'>'+res.result[i].ca_name+'</option>';
                        $("select[name='sc_gc_id4']").append(data);
                    }
                }
               
            }
        })
    });
    

});

</script>
