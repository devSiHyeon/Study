<!-- 프로젝트 순서-->
1. 요청 (고객)
    2. 기능정리 / 정리
    3. DB 설계 (글자 - Exel, aquery tool / SQL)
    4. 화면설계 (종이 / 정리)
    5. 개발 (TODO 미리 해야할 일 적은 후 코딩)

    <!-- list : 검색기능-->
    $_SERVER['PHP_SELF'] - 검색해서 해당 페이지로 다시 돌아옴 → 처리페이지 따로 만들 필요 없음
    
    GET / POST
    검색할 때는 → GET
    나머지는 → POST 
    수정, 삭제는 고유번호를 전달해줄 것

<!-- list : 페이지 -->
    1. 게시글의 총 갯수 구하기
    2. 하단의 번호에 링크 연결하기
    3. 링크 연결 시 게시글 몇 개 나타날지 정하기 (LIMIT 사용)
    4. 게시글 나타날 때 몇 번째 게시글부터 나오는지 정하기
    5. \
    
    page값을 구할 때 변수에 임의로 값을 줘서 맞는지 확인
        ex) 임의 값 : <?  $row_total['cnt'] = 32; ?> 
            변수 : <?=$row_total['cnt']?>

    %는 수학적으로 보면 나누기, 프로그램 언어로 봤을 때 나머지 값 
    - 올림 : ceil(값)
    - 내림 : floor(값)
    - 반올림 : round(값)


<!-- view : 댓글 -->
   연결 테이블 (매핑 테이블)
   ./view.php?id={$row['tb_board_id']}  - id인지 연결 id 인지 구분하기


<!-- 비밀번호 -->
    주민번호, 운전면허증 번호, 비밀번호는 암호화해서 저장할 것 → 법으로 정해져 있음
    정책이 바뀌어 단방향(Encrypt)으로만 사용
    
    암호화 사용할 시 CRUD 중 C를 제외한 나머지 페이지(password 들어가는 페이지) 모두 적용
    암호화 사용할 시 변환되는 문자수가 많아지기 때문에 db에 입력시 255 정도가 적당함

<!--  파일 첨부  -->
    1. 저장공간 만들기 (읽기 : 4 / 쓰기 : 2 / 실행 exe : 1) → 권한 777로 저장
    2. 필드 만들기         
    3. form 속성 변경
        : enctype="multipart/form-data" 추가
    4. process 
        : $id = mysqli_insert_id($db); // 직전에 insert 로 생성된 행의 id (오토 인크리먼트 지정된 필드)값을 반환한다.


<!-- 소프트 삭제 -->
    Soft Delete - enum(''Y, 'N') 
    삭제시 소프트 삭제는 간단하지만 DB 내용까지 삭제할 때는 신경써서 할 것
    1. 삭제 순서 (게시물, 댓글, 첨부파일)
    2. 댓글 내용
    3. 첨부파일 (첨부파일 불러오기 → 첨부파일 DB삭제 → 첨부파일 물리적 삭제)

<!-- 기능 -->
    <!-- 메시지 + 이동 -->
    function msgAndGo_2($msg_2, $url_2) {

echo "
        <script>
            alert('{$msg_2}');
            document.location.href = '{$url_2}';
        </script>
    ";

exit;
}

<!-- 암호화 -->
function Encrypt($str, $secret_key='lab.jfix.net', $secret_iv='lab.jfix.net') {
$key = hash('sha256', $secret_key);
$iv = substr(hash('sha256', $secret_iv), 0, 16);  //32가 안정적

return str_replace("=", "", base64_encode(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
);
}

<!-- 아이디 or 비밀번호 무언가 일치 확인할 때 -->
if ($row['password'] == $password) {
}
