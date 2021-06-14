<!DOCTYPE html>
<html lang='ko'>
<head>
    <meta charset="utf-8">
    <title>coffee</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>

        div.cafe{
            width:400px;
            margin:0 auto;
        }
        
        span[title]{
            color: green;
            background-color:#edfebd;
        }
    </style>
</head>

<body>
<div class="cafe">
    <h1>커피 메뉴</h1>
        <div><h3>안녕하세요. <span>jquery 카페</span>입니다.</h3></div>
        <p></p>
        <button id="btnSetter">속성값 설정</button>
        <button id="btnGetter">속성값 얻기</button>
        <button id="btnRemove">속성 삭제</button>
        <br><br>

        <ul style="list-style: none;">
        <li><input type="checkbox">아메리카노</li>
        <li><input type="checkbox">에스프레소</li>
        <li><input type="checkbox">카페라떼</li>
        <li><input type="checkbox">바닐라라떼</li>
        <li><input type="checkbox">아인슈페너</li>
        <li><input type="checkbox">카페모카</li>
        </ul>
    <span id="count"></span>

    <button id="button1">주문</button><br><br>

    <button class="coffee">신상메뉴 의견주세요~</button>
    <div id="coffeeMenu"></div><br>

    커피의 맛을 평가해주세요. <br>
    <input type="text" id="focus">
</div>
</body>


<script>

// 매진
$("<span>- 매진되었습니다.</span>").appendTo("li:eq(4)");

// 주문 확인
$("input:checkbox").click(function() {
    var checked =  $("input:checked").length;
    $("#count").text("선택한 커피는 총 " + checked + "잔 입니다.");
});

// 주문 완료
$("#button1").click(function() {
    var checked =  $("input:checked").length;
    alert(checked + "주문이 완료되었습니다.");
});

// append : 뒤쪽에 내용(function 이벤트 적용) 추가
$(function() {      
    $(".coffee").on("click", function() {
        $("#coffeeMenu").append("<input placeholder='음료이름을 알려주세요' style='padding:5px; margin:5px;'><br>");
    });
});

// 맛 평가(input)
$(function() {
    $("#focus").on("focusin", function(event) {
        $(this).css("backgroundColor","#fbcdba");
    });
    
    $("#focus").on("focusout", function(event) {
        $(this).css("backgroundColor","white");
    });
});

</script>
</html>
