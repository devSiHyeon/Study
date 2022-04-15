<?php

$sc_gc_id1      = isset($_GET['sc_gc_id1']) ? $_GET['sc_gc_id1'] : "";			// 카테고리1
$sc_gc_id2      = isset($_GET['sc_gc_id2']) ? $_GET['sc_gc_id2'] : "";			// 카테고리2
$sc_gc_id3      = isset($_GET['sc_gc_id3']) ? $_GET['sc_gc_id3'] : "";			// 카테고리3
$sc_gc_id4      = isset($_GET['sc_gc_id4']) ? $_GET['sc_gc_id4'] : "";			// 카테고리4

$sc_gc_id2      = (strlen($sc_gc_id2) > 0) ? substr($sc_gc_id2, -4) :$sc_gc_id2; 
$sc_gc_id3      = (strlen($sc_gc_id3) > 0) ? substr($sc_gc_id3, -4) :$sc_gc_id3;
$sc_gc_id4      = (strlen($sc_gc_id4) > 0) ? substr($sc_gc_id4, -4) :$sc_gc_id4;

// 리스트 조건
$get_page = isset($_GET['page']) ? $_GET['page']: "";
if(!$get_page) $page = 1; 

$from_record = ($page - 1) * $page_row;
$total_page  = ceil($record_count / $page_row);  // 전체 페이지 계산

// 리스트
$sql = "SELECT * FROM goods WHERE 조건";

    $result = sql_query($sql);
    $result2 = sql_query($sql);

// 1차 카테고리
    $cateQ = 'SELECT * FROM category WHERE ca_depth = \'1\' ';

    $cateR = sql_query($cateQ);
    $cateL = array();

    while($row = sql_fetch_array($cateR)) {
        $cateL[$row['ca_depth']][$row['ca_id']] = $row;
    }

    $sql = 'select * from hi_category where ca_depth = 1 and ca_open_use = 1';

    $cate1 = array();
    if (false !==($rows = DB::conn()->selectAll($sql))) {

        foreach ($rows as $key => $item) {
            
            $cate1[$item['ca_id']] = array(
                'name' => $item['ca_name']
                , 'selected' => ($item['ca_id'] == $sc_gc_id1)? ' selected':''
                
            );
             
        }

        $category = $sc_gc_id1;
        $depth = 2;
    }


    // 카테고리 depth 개수에 따른 select box 
    $cateD = 'SELECT MAX(ca_depth) AS depthMax FROM hi_category';
    $cateM = sql_query($cateD);
    $resultM = sql_fetch_array($cateM);

// END 카테고리

// 검색 카테고리
    $search_sql = array();
    
    $cate2 = $cate3 = $cate4 = array();

    // 2차
    if (strlen($sc_gc_id2) > 0){        

        $sql = 'SELECT * FROM category WHERE LEFT(ca_search,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'2\'';
        //$search_sql[2] = DB::conn()->selectAll($sql, array($sc_gc_id1));
        if (false !== ($rows = DB::conn()->selectAll($sql, array($sc_gc_id1)))) {
            foreach($rows as $key => $item) {
                $dest = $sc_gc_id1.$item['ca_id'];
                
                $cate2[$dest] = array(
                                'name' =>$item['ca_name']
                                , 'selected' => ($item['ca_id'] == $sc_gc_id2)? ' selected':''
                            );
            }

        }
      
        $category = $sc_gc_id1.$sc_gc_id2;
        $depth = 3;
      
    }

    // 3차
    if (strlen($sc_gc_id3) > 0){        

        $sql = 'SELECT * FROM category WHERE MID(ca_search,6,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'3\'';
        if (false !== ($rows = DB::conn()->selectAll($sql, array($sc_gc_id2)))) {
            foreach($rows as $key => $item) {
                $dest = $sc_gc_id1.$item['ca_id'];
                
                $cate3[$dest] = array(
                                'name' =>$item['ca_name']
                                , 'selected' => ($item['ca_id'] == $sc_gc_id3)? ' selected':''
                            );               
            }

        }
        $depth = 4;
        $category = $sc_gc_id1.$sc_gc_id2.$sc_gc_id3;
    }
    
    //4차
    if (strlen($sc_gc_id4) > 0){        

        $sql = 'SELECT * FROM category WHERE MID(ca_search,11,4)  LIKE ? AND ca_open_use = \'1\' AND ca_depth = \'4\'';
        
        if (false !== ($rows = DB::conn()->selectAll($sql, array($sc_gc_id3)))) {
            foreach($rows as $key => $item) {
                $dest = $sc_gc_id1.$item['ca_id'];
                
                $cate4[$dest] = array(
                                'name' =>$item['ca_name']
                                , 'selected' => ($item['ca_id'] == $sc_gc_id4)? ' selected':''
                            );               
            }

        }
        
    }

// END 검색 카테고리
?>

<table>
  <th scope="row">
  카테고리
  </th>
  <td id="cateBox">

        <select id="cate-1" class="cate-depth table_selectcss" name="sc_gc_id1" data-depth="1">
            <option value=""> -- 선택 -- </option>
            <?php foreach($cate1 as $key => $item) { ?>
            <option value="<?=$key?>"<?=$item['selected']?>><?=$item['name']?></option>
            <?php } ?>
        </select>

        <select id="cate-2" class="cate-depth table_selectcss" name="sc_gc_id2" data-depth="2">
            <option value=""> -- 선택 -- </option>
        <?php foreach($cate2 as $key => $item) { ?>
            <option value="<?=$key?>"<?=$item['selected']?>><?=$item['name']?></option>
        <?php } ?>
        </select>
    
        <select id="cate-3" class="cate-depth table_selectcss" name="sc_gc_id3" data-depth="3">
            <option value=""> -- 선택 -- </option>
            <?php foreach($cate3 as $key => $item) { ?>
            <option value="<?=$key?>"<?=$item['selected']?>><?=$item['name']?></option>
            <?php } ?>
        </select>
    
        <select id="cate-4" class="cate-depth table_selectcss" name="sc_gc_id4" data-depth="4">
            <option value=""> -- 선택 -- </option>
            <?php foreach($cate4 as $key => $item) { ?>
            <option value="<?=$key?>"<?=$item['selected']?>><?=$item['name']?></option>
            <?php } ?>
        </select>
</table>


<script>
  
var category = "<?=$category?>",
    depth = "<?=$depth?>";

var getCategory = function(depth, ca_id) {

    var depth = (typeof depth =='undefined') ? 1 : depth,
        ca_id = (typeof ca_id =='undefined') ? '' : ca_id;

        if (ca_id.length < 1) return false;
 
    $.ajax({
        url : './category_list.php',
        type : 'GET',
        data : {depth : depth, ca_id :ca_id},
        dataType:'json',
        success:function(res){
            if(res.err == false) {
                ui = '';
                                    
                $.each(res.data, function(key, val){
                    ui += '<option value="'+key+'">' + val+ ' </option>';
                    
                })
                
            }  

            $("#cate-"+depth).append(ui);
        }
    });
}

$(document).ready(function() {
	if($('a.btn_basic_whiteorange').length > 0){
		$('a.btn_basic_whiteorange').each(function(){
			
			$(this).click(function(){
				$('a.btn_basic_whiteorange').removeClass('on');
				$(this).addClass('on');
			});
			
		});	
	}

    var sc_2 = document.getElementById('sc_gc_id2'),
        sc_3 = document.getElementById('sc_gc_id3'),
        sc_4 = document.getElementById('sc_gc_id4');
                    
    // 2차 카테고리 

    getCategory(depth, category);
    $(document).on('change', '.cate-depth', function(){

        var depth = Number($(this).data('depth')),
            ca_id = $(this).val(),
            ui = '',
            idx = depth - 1;   


            if (depth > 3 ) return false;

            $(".cate-depth").each(function(key, val){
         
                if ( key > idx) {
                    $(this).find('> option').remove();
                    
                    $(this).append('<option value=""> --선택--</option>');
                    
                }


            }) 
            getCategory((depth+1), ca_id);        

    });
  
</script>
