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

<!-- jQuery -->
    <!-- 기본형 -->
    <script>
        $(document).ready(function() {
            alert("로딩 완료");
        });
    </script>
    
    <!-- 축약형 -->
    <script>
       $(function() {
            alert("로딩 완료");
        });
    </script> 



<!-- ajax -->
    spa 기반 : 이벤트가 일어나면 데이터를 받아서 틀에 담는 것 - 페이지가 변하지 않음
        ex) 실시간 채팅, 바로 목차 보는 것
    
    그리드 툴 : 부트스트랩처럼 연결해서 사용 
        ex) ajax를 이용하여 게시판 같은 데이터베이스 연결
