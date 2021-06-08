모달 등록 버튼 눌렀을 때 
    : 등록 버튼 클릭 -> 상세보기 창 (빈 값) -> 내용 입력 -> 저장하기 버튼 클릭
<?  class Util {    // 준비
        // Sanitize a String
        public static function sanitize($str) {
            $str = trim($str);
            $str = filter_var($str, FILTER_SANITIZE_STRING);
            return $str;
        }
    }
?>

<!-- 상세보기 -->
<script>
    // 모달 등록
        $("#btn_create").on("click", function() {   // <- 버튼 클릭시 기능을 함 (동적, 정적 구분)

            $("#modal_idx").val("");    // <- 모달 form의 idx

            view_modal();           // <- 내용이 길어지니 다른 function에 연결
        });

    // 모달 목록 (테이블 형식)
        function view_modal() {
            
        // 초기화
        $('#modal_dataTables_1').DataTable({buttons: []}).destroy();    // function 한 번이 아닌 여러번 띄울 때 reset 하고 다시 창을 띄운다는 말
        $('#modal_dataTables_1').DataTable({     // <- table id 
                ajax: {
                    type: "post",
                    data:  function() {
                        var param = $("#form_modal").serializeObject();
                        param.process_mode = "worker_list_modal";       //  <- ajax에 연결할 이름
                        return param;
                    },
                    url: "/pages/<?=$page_code?>_ajax.php",         // <- 어느 페이지로 이동 할 것인가? <?=$page_code?> <- 현재 페이지이름과 동일 한 파일
                    dataType: "json",
                    cache: false,
                    async: false,
                    dataSrc: '',
                },
                createdRow: function (row, data, index) { },
                drawCallback: function(settings, json) { },
                columns: [
                    { data: "idx", className: "text-center",
                        render: function(data, type, row, meta) {
                            var html = `<div class='radio radio-primary' >
                                            <input form='form_modal' type='radio' name='employee' class='checkbox_sub' value='${data}'>
                                        </div>
                                            `;
                            return html;
                        }
                    },                  //  <- html 작성시 문법이 바뀌면서 \\ 대신 `` 로 사용 변경
                    { data: "name", className: "text-center" },
                    { data: "department", className: "text-center" },
                    { data: "rank", className: "text-center" },
                ],

                pageLength: 10,
                paging: true,
                dom: 'ft<"pull-center"p>',
                buttons: [
                    {extend: 'excel', title: '작업자 목록'},
                    {extend: 'print',
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                    }
                ]
            });
        }

    // 모달 상세 (div 값 형식)
    function view_modal() {

        // 초기화
        $("#form_modal")[0].reset();
        $("#modal_1").modal("show");

        worker_list_modal();

        var modal_idx = $("#modal_idx").val();

        if (modal_idx) { // 수정 모드

            $.ajax({
                type: "post",
                data: $("#form_modal").serialize() + "&process_mode=view_modal",
                url: "/pages/<?=$page_code?>_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {
                // $("#modal_name").val(data.name); <-- 달력에서는 이런식으로 데이터 넣으면 안된다고 했죠
                // $('.datepicker').datepicker('setDate', '< ?=val(data.name)?>'); <-- 이 코드는 왕창 틀림, data.name는 자바스크립트 변수인데, <? ?> php 에서 쓸려고 하면 안되죠
                // $('.datepicker').datepicker('setDate', 'val(data.name)'); <-- val() 이란 건 비슷한 건 있지만, 이렇게 쓰는 문법은 없죠
                // $('.datepicker').datepicker('setDate', 'data.name'); <-- 홑따옴표 안에 변수가 들어가면, 더이상 변수가 아니라, 문자열이 되죠. 다시말해 그냥 순수한 그대로의 글자로 출력
                $('.datepicker').datepicker('setDate', data.name); // <-- 정답

                $("#modal_product").val(data.product_idx).trigger("change");
                $("#modal_process").val(data.process_idx);
                $("#modal_equipment").val(data.equipment_idx);
                $("#modal_amount").val(addNumberComma(data.amount));

                $("#employee").val(data.employee_idx);               
                worker_list_modal(data.employee_idx);   // 중간에 연결하는 function 넣을 수 있다

                $("#modal_memo").val(data.memo);

            });

        } else { // 등록 모드
            $("#modal_code").prop("disabled", false);

            $('.datepicker').datepicker('setDate', '<?=date("Y-m-d", strtotime("+1 days"))?>');
        }
    }

    // 상세보기 시 어떠한 기능이 없어도 바로 목록이 나오게 초기화 하기
        // 초기화
        $(function() {
            list(); // 목록
        });

</script>


<!-- 저장 -->
<script>
        // 모달 저장
            $("#form_modal").on("submit", function() {      // 모달 저장할 때 이벤트 발생
            create_modal();
            return false;
        });

        // 모달 저장
        function create_modal() {

            var modal_idx = $("#modal_idx").val();
            var process_mode = "";          // ajax에서 사용할 이름 = ""; 빈칸

            if (modal_idx) process_mode = "update_modal"; // 수정 모드
            else process_mode = "create_modal"; // 등록 모드

            // 숫자 콤마 처리
            $(".number_format").each(function() {
                var value = $(this).val().replace(/,/gi, "");
                $(this).val( value );
            });

            $.ajax({
                type: "post",
                data: $("#form_modal").serialize() + "&process_mode=" + process_mode,
                url: "/pages/<?=$page_code?>_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {
                if (data.status) {
                    list();
                    toastr["success"](data.message);
                    $("#modal_1").modal("hide");
                } else {
                    toastr["error"](data.message);
                }
            });
        }

</script>
<?php // 저장
    if ($process_mode == "create_modal") {      // js 연결하는 이름

        // 변수 정리
        $name = Util::sanitize($_REQUEST['modal_name']);    //  Util::sanitize : function을 사용한 것 

        $sql = "
                INSERT INTO table_name
                SET
                    name = '$name'
                
        ";
        $result = $db->query($sql)->affectedRows();

        echo json_encode($result);
    }
?>

<!-- 수정 -->
<?php // 수정
    if ($process_mode == "update_modal") {      // js 연결하는 이름

        // 변수 정리
        $name = Util::sanitize($_REQUEST['modal_name']);    //  Util::sanitize : function을 사용한 것 

        $sql = "
                UPDATE table_name
                SET
                    name = '$name'
                WHERE idx = '$idx'
                LIMIT 1         -- 하나만 수행            
        ";
        $result = $db->query($sql)->affectedRows();

        echo json_encode($result);
    }
?>

<!-- 삭제 -->
<?php // 삭제
    if ($process_mode == "delete") {      // js 연결하는 이름

        // 변수 정리
        $name = Util::sanitize($_REQUEST['modal_name']);    //  Util::sanitize : function을 사용한 것 

        $sql = "
                DELETE
                FROM table_name
                WHERE idx = '$idx'
                LIMIT 1         -- 하나만 수행            
        ";
        $result = $db->query($sql)->affectedRows();

        echo json_encode($result);
    }
?>

<!-- 기능 -->
    <!-- 작업자 체크 확인 -->
    <script> 
        $('.radio-employee').on('checked', function() {
            var valueCheck = $('.radio-value:checked').val(); // 체크된 Radio 버튼의 값을 가져옵니다.
        });
    </script>

    <!-- 제품이 선택되었을 때, 생산공정의 목록이 확정됨 -->
    <script>
        $("#modal_product").on("change", function() {
            var product_idx = $(this).val();
            change_modal_process(product_idx);
        });
    </script>
        
    <!-- 제품이 선택되었을 때, 생산공정의 목록이 확정됨 -->
    <script>
        function change_modal_process(product_idx) {
            // alert(product_idx);

            $.ajax({
                    type: "post",
                    data: `process_mode=change_modal_process&product_idx=${product_idx}`,
                    url: "/pages/<?=$page_code?>_ajax.php",
                    dataType: "json",
                    cache: false,
                    async: false,
                }).done(function(data) {

                    // console.log( data.length );
                    // console.log( data[0].process_idx );
                    $("#modal_process").empty();
                    $("#modal_process").append(`<option value=''>선택</option>`);
                    data.forEach(function(item, index) {
                        // console.log(item.process_idx);
                        $("#modal_process").append(`<option value='${item.process_idx}'>${item.process_name}</option>`);
                    });

                });
        }
    </script>

    <!-- 숫자 콤마 처리 -->
    <script>
        $(".number_format").each(function() {
            var value = $(this).val().replace(/,/gi, "");
            $(this).val( value );
        });
    </script>

    <!-- 다른 테이블에서 가져올 때 -->
    <?
        foreach ($list as $item) {      // $list는 생략되어 있지만 select를 위쪽에 사용하였음

            // 부서 가져오기
            $sql = "
                    SELECT title
                    FROM table_name
                    WHERE idx = '{$item['department_idx']}'
                    LIMIT 1
            ";
            // echo $sql;
            $temp = $db->query($sql)->fetchArray();
            $item['department'] = $temp['title'];       // $item['js에 저장할 때 이름'] = $temp['DB에 저장되어 있는 이름'];

            $result[] = $item;
        }

        echo json_encode($result);
    ?>

    <!-- Join -->
    <?
        $sql = "
                SELECT a.process_idx, b.name AS process_name
                FROM jfm_product_process a
                LEFT JOIN jfm_process b
                    ON a.process_idx = b.idx
                WHERE a.product_idx = '{$product_idx}'
                GROUP BY a.process_idx 
        ";
    ?>

    <!-- 기능 완료 되었을 때(저장, 수정, 삭제) -->
    <?
        if ($result) {
            $temp = array(
                            "status" => 1,
                            "message" => "삭제되었습니다.",
            );
        } else {
            $temp = array(
                            "status" => 0,
                            "message" => "삭제 오류",
            );
        }
    ?>
    <!-- script에서 숫자 -->
    <script>
        val(addNumberComma(data.amount));   
    </script>