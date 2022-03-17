<?php 
    $arr = array('CJ대한통운', '롯데', '우체국', '로젠택배','CU택배');
    $str = 0;
    $cnt = count($arr);
?>
<html>
<head>
<meta charset="utf-8">
    <title>test</title>
    <style>
        #check{
            width:500px;
            height:50px;
            border:1px solid gray;
        }

        .check_ok {
            background-color:orange;
        }
        .li_display{
            display:none;
        }
        ul{
            list-style:none;
        }
    </style>
</head>
<body>
        <h5>목록</h5>
        <?php while($str < $cnt){?>
        <ul>
            <li class='select_li_1'><label class="select_la_1"><input class='checkbox_1' type='checkbox'><?= $arr[$str]?></label></li>
        </ul>
        <?php $str++; } ?>
        <button id='btn_1'>추가</button>
        <button id='del_2'>삭제</button>
        <h5>적용</h5>
        <?php 
            $str = 0;
            while($str < $cnt){?>
        <ul>
            <li class='select_li_2 li_display'><label class="select_la_2"><input class='checkbox_2' type='checkbox'><?= $arr[$str]?></label></li>
        </ul>
        <?php $str++; } ?>
    <form name='delivery' action ='./test2.php' method='POST'>
        <button type='submit'>적용</button>
    </form>
    <script>
      document.addEventListener('DOMContentLoaded',function(){

        let select_li_1 = document.getElementsByClassName('select_li_1'),
            select_la_1 = document.getElementsByClassName('select_la_1'),
            checkbox_1 = document.getElementsByClassName('checkbox_1'),
            btn_1 = document.getElementById('btn_1'),
            select_li_2 = document.getElementsByClassName('select_li_2'),
            select_la_2 = document.getElementsByClassName('select_la_2'),
            checkbox_2 = document.getElementsByClassName('checkbox_2'),
            del_2 = document.getElementById('del_2');

        // 추가
        for(let i=0; i<select_li_1.length;i++){
            btn_1.addEventListener('click',function(){
                if(checkbox_1[i].checked == true){
                    select_la_2[i].style.display = 'block';
                    checkbox_2[i].style.display = 'block';
                    checkbox_2[i].checked = true;
			        select_li_2[i].classList.remove('li_display');
                }
                if(checkbox_1[i].checked == false){
                    select_la_2[i].style.display = 'none';
                    checkbox_2[i].style.display = 'none';
                }
            });
        }

        // 삭제
        for(let i=0; i<select_li_2.length;i++){
            del_2.addEventListener('click', function(){
                if(checkbox_2[i].checked == true){
                    select_la_1[i].style.display = 'block';
                    checkbox_1[i].style.display = 'block';
                }
                if(checkbox_2[i].checked == false){
                    checkbox_1[i].checked = false;
			        select_li_2[i].classList.add('li_display');
                }
            });
        }


    });
    </script>
</body>
</html>
