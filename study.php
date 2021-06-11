<!-- 값 넘기는 방법 -->
    <!-- form 이용 -->
        method : get / post 두 가지의 방법이 있음

    <!-- 쿼리스트링 -->
        주소 : url ? 지정이름 = 값 & 지정이름 = 값 
        형식에 맞는 글을 주소창에 작성 시 받아오는 방법
        <?
            // 변수
            $titlte = Util::sanitize($_REQUEST['titlte']);      // 값 받아오기
            $opt = Util::sanitize($_REQUEST['opt']);

            $opt_array = explode('|', $opt);                    // 여러개의 항목들을 '|' 기호 사용하여 구분하기 
            // print_r($opt_array);

            if ($titlte && $opt) {
        ?>

            <select>
                <option><?=$titlte?></option>

                <? foreach ($opt_array as $key => $value) { ?>          <!-- foreach를 사용하여 항목 개수 나열 -->
                    <option><?=$value?></option>

                <? } ?>

            </select>

            <button>전송하기</button>

        <? } ?>


    <!-- 세션 & 쿠키 -->
        쿠키는 보안이 취약함 (로컬 - 본인 컴퓨터) 
            ex) 팝업창
        세션은 쿠키를 기반으로 보안됨 (서버)
            ex) 로그인

        <!-- 세션 사용 시작 -->
            <? session_start(); // 세션 사용 시작 ?>
            항상 최상단에 위치할 것

<!-- 전체 -->
    <pre>
        내용 작성 시 화면에 보여질 때 그대로 나타남 (한 줄에 쭉 진열)
    </pre>

    <!-- 다른 파일의 함수 불러오는 방법 -->
    변수 = 파일이름 :: 경로 (변수); 
    $idx = Util::sanitize($idx);

    <!-- 화면에 코드 나오게 -->
        <!-- php  -->
        print_r($__);
        echo $__;
        var_dump( $__);

        <!-- js -->
        console.log($__);

<!-- 반복문 -->
    for (횟수) / while (무한)   


<!-- 삼항연산자 -->
    조건 ? 참 : 거짓
    <?= ($row['is_secret'] == "Y") ? "checked" : "" ?>
    
    <script>
        columns: [
            { data: "idx", className: "text-center",
                render: function(data, type, row, meta) {

                    console.log(row.is_checked)         // console 찍기

                    if (row.is_checked === true) {    

                        var checked_status = "checked";

                    } else {
                        var checked_status = "";
                    }

                    var html = `<div class='radio radio-primary'>
                                    <input form='form_modal' type='radio' id='employee' name='employee' value='${data}' ${checked_status} required>
                                </div>
                                    `;
                    return html;
                }
            },
        ]
    </script>


<!-- 공지사항 제일 먼저 위로 -->
    sql문을 사용하여 오름차순, 내림차순 설정
    
    ORDER BY 
        is_notice ASC, 
        id DESC

<!-- DataTable -->
    <script>
        dom: 'Bft<"pull-center"p>' 
        // B : 출력버튼
        buttons: [
                {extend: 'excel', title: '작업지시'},
                {extend: 'print',
                   customize: function (win){
                          $(win.document.body).addClass('white-bg');
                          $(win.document.body).css('font-size', '20px');
                          $(win.document.body).find('table')
                              .addClass('compact')
                              .css('font-size', 'inherit');
                  }
                }
            ]
        // F : 검색 적용
        // T : table 적용

        // 출력 버튼 처리 (DataTable을 사용하여 버튼을 처리하고 싶을 때)
        $("#btn-print").on("click", function() {       // id는 버튼에 적용한 이름
            $(".buttons-print").trigger("click");      // class는 DataTable에서 제공하는 이름
        });
        
        // 검색기능
            '<input id="srch_date">'    // input을 사용할 경우 
                    var table = $('#dataTables_1').DataTable();     // 데이터 목록에 보여지는 id 값 (table id)

                    $("#srch_date").on("change", function() {       // input의 id값 이 변경 되었을 때 이벤트 발생
                        table.search(this.value).draw();            // table의 동일한 값을 검색해라.
                    });

            /* <select id="srch_status">  // select를 사용할 경우 
                <option value="생산중">생산중</option>          // 주의! option value에 테이블에 나오는 글자 그대로 작성할 것 (숫자, 한글, 영어)                
            </select> */

                    $("#srch_date").on("change", function() {       // input의 id값 이 변경 되었을 때 이벤트 발생
                        table.search(this.value).draw();            // table의 동일한 값을 검색해라.
                    });


    </script>

<!-- 웹에디터 (썸머노트) -->
    <script>

        $(function(){

           $('#content').summernote('code', '<?=$row['content']?>');

        });

    </script>

<!-- 값을 넘길 때 js에서 -->
    var 이름 = $(this).data("db값");
    $("#html 값").text( $("#form name").val() );

    val() > 값을 찾아옴
    val("") > 빈값을 찾아옴
    
    
<!-- 함수 function-->
    <!-- 무작위 숫자 값 나타내기  -->
    rand(); 용어 사용  ex) 보안문자 코드, 중복되는 값을 만들어내지 않을 때 (돈과 관련되어 idx 추출할 때)

    $a = rand();
    $b = date("Ymdhis");
    $c = $a + $b;
    echo $c;

    <!-- 마지막 idx 불러오기 -->
    lastInsertID(); // 방금 전 Insert 로 인해 만들어진 row 의 idx를 가져온다.

    <!-- item을 이용하여 다른 테이블의 목록을 불러올 때 -->
    첫 번째 item은 데이터에 들어갈 내용 
    두 번째 item은 목록에 나타나서 보여지는 내용

    등록화면 "name" / 데이터 저장 "idx" / 목록화면 "name" (이때 ajax에서 다시 select 불러와야함)
    <?
        foreach ($list as $item) {
	        $result .= "<option value='". $item['idx'] . "'>". $item['name'] . "</option>";
	    }
    ?>

<!-- vscode 유용한 앱 -->
    <!-- Todo Tree -->
        // TODO :: 나중에 해야할 일 
        // FIXME :: 나중에 수정할 것 

<!-- 함수 -->
    sorting

<!-- 기타 -->
    data-idx='${row.idx}' data에 - idx라는 이름으로 저장 '$DB idx'불러오기

    스팸방지 → 구글참고 (API)
    php pad zero (글자, 숫자 작성 시 남은 자리수에 무언가 채울 때 사용)
    sql : varchar로 사용하면 0001 사용 가능 or sql 0으로 채움 기능 적용

    <!-- 숫자 int -->
        php, html : class="number_format" 작성시 화면에서 오른쪽 정렬과 콤마가 나타남
        db에는 int로 작성 (보여지는 화면에서 콤마를 작성했을 시 DB에 콤마 이후의 숫자가 사라짐)

    <!-- 날짜 시간 표시 -->
        <?=date("H:")?>
        <?="현재 날짜 : ". date("Y-m-d")?>      
        <?="현재 시간 : ". date("H:i:s")?>      
        <?="현재 일시 : ". date("Y-m-d H:i:s")?>
        ex) <?=date("H:00")?>기준  -> 11:00 기준 (분은 00으로 고정)