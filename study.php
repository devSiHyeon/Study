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

<!-- js -->
    <!-- 정적  -->
        ex) 리스트 불러오기 전 선택삭제 or 등록 버튼처럼 고정으로 되어있는 부분
        $("#form_main").on("submit", function()) {
        }

    <!-- 동적  -->
        ex) 리스트를 불러와서 수정 or 삭제
        $(document).on("click", ".btn_update", function()) {
        }

    <!-- 버튼 클릭했을 때 -->
        $("#btn_create").on("click", function() {
        });

    <!-- select 항목 변경 했을 때 (값이 변경 되었을 때)-->
        $("#modal_product").on("change", function() {

        }
        select option 선택값 가져오기
        .trigger("change"); 강제 실행 시키는 방법 (trigger)
        
    <!-- 정보 저장할 때 -->
        $("#form_modal").on("submit", function() {
        });

    <!-- ajax 사용하여 줄나눔할 때 `` 변경 -->
    <script>
        var html = `
                    <button type='button' class='btn btn-default btn-xs btn_delete' data-idx='${data}'>삭제</button>
                    <button type='button' class='btn btn-default btn-xs btn_up' data-sort='${row.sort}'>▲</button>
        `;
        return html;
    </script>
    <!-- CallBack 콜백함수란 -->
    콜백 함수는 코드를 통해 명시적으로 호출하는 함수가 아니라, 개발자는 단지 함수를 동록하기만 하고,
    어떤 이벤트가 발생했거나 특정 시점에 도달했을 때 시스템에서 호출하는 함수를 말한다.

    <!-- 달력 (datepicker) -->
    코드 확인 필요없음 (date("Y-m-d"))
        <script>
            $("#modal_order_date").val(data.order_date);        // 달력에서는 이런식으로 데이터 넣으면 안된다고 했죠
            $('.datepicker').datepicker('setDate', '< ?=val(data.order_date)?>'); //  이 코드는 왕창 틀림, data.order_date는 자바스크립트 변수인데, <? ?> php 에서 쓸려고 하면 안되죠
            $('.datepicker').datepicker('setDate', 'val(data.order_date)'); // val() 이란 건 비슷한 건 있지만, 이렇게 쓰는 문법은 없죠
            $('.datepicker').datepicker('setDate', 'data.order_date'); //  홑따옴표 안에 변수가 들어가면, 더이상 변수가 아니라, 문자열이 되죠. 다시말해 그냥 순수한 그대로의 글자로 출력
            $('.datepicker').datepicker('setDate', data.order_date); // <-- 정답 (데이터 값이 있을 때)

            $('.datepicker').datepicker('setDate', '<?=date("Y-m-d")?>');           // 당일날짜
            $('.datepicker').datepicker('setDate', '<?=date("Y-m-d", strtotime("+1 days"))?>'); // (내일 날짜)

            // function 사용하기 
            $(document).ready(function(){
                $('.datepicker').datepicker().datepicker('setDate', 'today');
                
            });
        </script>
        

    코드 확인 필요 (날짜에 제대로 적용이 되었는지)
        var now = new Date();
        var year = now.getFullYear();
        var month = now.getMonth()+1;
        var date = now.getDate()+1;
        var tomorrow = year + "-" + ("00"+month).slice(-2) + "-" +("00"+date).slice(-2);

<!-- ajax -->
    spa 기반 : 이벤트가 일어나면 데이터를 받아서 틀에 담는 것 - 페이지가 변하지 않음
        ex) 실시간 채팅, 바로 목차 보는 것
    
    그리드 툴 : 부트스트랩처럼 연결해서 사용 
        ex) ajax를 이용하여 게시판 같은 데이터베이스 연결

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

