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


<!-- js -->
    정적 ex) 리스트 불러오기 전 선택삭제 or 등록 버튼처럼 고정으로 되어있는 부분
        $("#form_main").on("submit", function()) {
        }

    동적 ex) 리스트를 불러와서 수정 or 삭제
        $(document).on("click", ".btn_update", function()) {
        }

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

<!-- 공지사항 제일 먼저 위로 -->
    sql문을 사용하여 오름차순, 내림차순 설정
    
    ORDER BY 
        is_notice ASC, 
        id DESC

<!-- 기타 -->
    // TODO :: 나중에 해야할 일
    // FIXME :: 나중에 수정할 것 
    스팸방지 → 구글참고 (API)
    php pad zero (글자, 숫자 작성 시 남은 자리수에 무언가 채울 때 사용)
    sql : varchar로 사용하면 0001 사용 가능 or sql 0으로 채움 기능 적용

<!-- 웹에디터 (썸머노트) -->
    <script>

    $(function(){

    $('#content').summernote('code', '<?=$row['content']?>');

    });

    </script>