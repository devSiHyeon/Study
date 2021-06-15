    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- 예제 -->
    <style>
        h2 {
            color:cornflowerblue;
        }
    </style>

<!-- append, find, siblings -->
    <script>

        // append : 뒤쪽에 내용(function 이벤트 적용) 추가
        $(function() {      
            $(".coffee").on("click", function() {
                $("#coffeeMenu").append("<li>신메뉴</li>");
            });
        });


        // find : 전달받은 선택자("")에 해당하는 하위 요소를 모두 선택
        $(function() {      
            $("#coffeeMenu").find("*").css({"background-color":"#fbf8c0"});
        });
    
        // siblings : 지정한 선택자에 해당하는 요소를 모두 선택 (본인 제외)
        $(function() {      
            $(".me").siblings().css({"padding":"10px"});
        });
        
        // eq : 몇 번째인지 지정할 수 있음
        $(function() {      
            $("li").eq(2).css({"background-color":"yellow"});
        });
        
        // prop : 선택한 요소 집합의 첫 번째 요소의 지정된 프로퍼티(property)값을 반환하거나, 선택한 요소의 지정된 프로퍼티를 전달받은 값으로 설정 (true, false)
        $(function() {     
            $("#btnGetter").on("click", function() {
                $(".order").text($('input[type="checkbox"]').prop("checked"));
            });
        });
        
        // removeProp : 프로퍼티 제거
        $("#btnRemove").on("click", function() {
            $('input[type="checkbox"]').removeProp("checked"); // 프로퍼티 제거
        });
    </script>

    <h1>커피 메뉴</h1>
        <ul id="coffeeMenu" style="list-style: none;">
            <li><input type="checkbox">아메리카노</li>
            <li><input type="checkbox">에스프레소</li>
            <li class="me"> <input type="checkbox">카페라떼</li>
            <li><input type="checkbox">바닐라라떼</li>
            <li><input type="checkbox">카페모카</li>
        </ul>
        <button class="coffee">메뉴 추가</button>
        <button id="btnGetter">주문</button>
        <span class="order"></span>
        <br><br>

        

<!-- focusin, focusout -->
<script>
    $(function() {
        $("#focus").on("focusin", function(event) {
            $(this).css("backgroundColor","#fbcdba");
        });
        $("#focus").on("focusout", function(event) {
            $(this).css("backgroundColor","white");
        });

    });
    </script>
        커피의 맛을 평가해주세요. <br>
        <input type="text" id="focus">
    <br><br><br>

<!-- .attr() :선택한 요소의 속성의 값을 가져오는 것 / .removeAttr() -->
    <style>
        span[title]{
            color: green;
            background-color:#edfebd;
        }
    </style>
    <script>
        $(function() {
            var count = 0;
            $("#btnSetter").on("click", function() {
                $("span").attr("title", (++count) + "번 클릭했습니다."); 
            });

            $("#btnGetter").on("click", function() {
                $("p").text($("span").attr("title"));
            });
            
            $("#btnRemove").on("click", function() {
                $("span").removeAttr("title");
            });
        });
    </script>

    <h2>▶ attr</h2>
    <div><h3>안녕하세요. <span>jquery 카페</span>입니다.</h3></div>
    <p></p>
    <button id="btnSetter">속성값 설정</button>
    <button id="btnGetter">속성값 얻기</button>
    <button id="btnRemove">속성 삭제</button>
    <br><br>

<!-- mouseenter, mouseleave, hover-->
    <script>
    $(function() {
       $(".mouse").on({ 
         click: function() {
            $(".mouse_event").append("마우스가 문장을 클릭했습니다.<br>");
         },
         mouseenter: function() {
            $(".mouse_event").append("마우스가 커서가 문장 위로 들어왔습니다.<br>");
         },
         mouseleave: function() {
            $(".mouse_event").append("문장을 빠져 나갔습니다.<br>");
         }
      });
      
    });

    $(function() {
        $("button").hover(function() {
            $("#text").text("마우스가 올라왔습니다.");
        }, function(){
            $("#text").text("마우스가 빠져나갔습니다.");
        });
    });
    </script>
    <h2>▶ mouseenter / mouseleave</h2>
        <h3 class="mouse" style="color:blueviolet;">이 문장 위로 마우스를 움직여 보세요.</h3>
        <div class="mouse_event"></div><br>
        <div style="border:3px solid #f7af90; width:50%; text-align:right;">
            마우스를 <button>버튼</button> 위로 올려보세요.
            <p id="text"></p>
        </div>
    <br><br><br>

<!-- event 동작하지 않게 (event.preventDefault()) -->
    <script>
    $(function() {
        $("#linkList a").on("click", function(event) {
        event.preventDefault();
        alert("이 링크는 동작하지 않습니다!");
        });
    });

    </script>
    <ul id="linkList">
        <li><a href="//www.devkuma.com">첫번째 링크</a></li>
        <li><a href="//www.devkuma.com">두번째 링크</a></li>
    </ul>
    <br><br><br>

<!-- slideUp / slideDown -->

    <style>
        .wrap{
            width:200px;
            height:100px;
            border:2px solid #b0ec17;
        }
    </style>
    <script>
		$(function() {
        	$("#btn1").on("click", function() {
            	$("#divBox1").slideUp(1000);        // 괄호 안의 숫자는 속도를 의미함
			});
            $("#btn2").on("click", function() {
            	$("#divBox1").slideDown(1000); 
			});
      	});
    </script>
    <h2>▶ slide up / down</h2>
    <div>
        <button id="btn1">슬라이드 업</button> 
        <button id="btn2">슬라이드 다운</button><br><br>
        <div id="divBox1" class="wrap">안녕하세요. jQuery입니다.</div>
    </div>

<!-- animate() -->
    <style>
        .box {
            border:1px solid #d2c9f7;
            margin:10px;
            width:400px;
        }
        .bar {
            background:#fdc8cf;
            height:50px;
            width:0px;
            border:1px solid #d2c9f7;
        }
    </style>
    <script>
        $(function() {
            $("#btnStart").on("click", function(){
            $(".bar").stop().animate({
                    width: "400px"  // CSS width 프로퍼티의 값을 "400px"로 설정함.
                }, 2000, "linear"); // 시간당 속도 함수를 "linear"으로 설정함.
            });

            $("#btnStop").on("click", function(){
                $(".bar").stop().animate({
                },); 
            });

            $("#btnEnd").on("click", function(){
                $(".bar").stop().animate({
                    width: "0px"   // CSS width 프로퍼티의 값을 "1px"로 설정함
                }, 2000, "swing");  // 시간당 속도 함수를 "swing"으로 설정
            });
        });
    </script>
    <h2>▶ animate</h2>
    <div>
        <button id="btnStart">시작</button>
        <button id="btnStop">중지</button>
        <button id="btnEnd">초기화</button>
    </div>
    <div class="box">
        <div id="bar" class="bar"></div>
    </div>
    <p id="text"></p>


<!-- on, off 기능 -->   
<!-- btn on으로 클릭했지만 첫 번째 이벤트 적용 x -->
<!-- http://www.devkuma.com/codes/167 -->
<script>
    $(function() {
      $("#btn").on("click", function() {
        alert("버튼을 클릭했습니다.");
      });
      $("#btnBind").on("click", function() {
        $("#btn").on("click").text("버튼 클릭 가능");
      });
      $("#btnUnbind").on("click", function() {
        $("#btn").off("click").text("버튼 클릭 불가능");
      });
    });
  </script>
  <button id="btn">버튼 클릭 가능</button>
  <button id="btnBind">버튼 클릭을 가능하게 합니다.</button>
  <button id="btnUnbind">버튼 클릭을 불가능하게 합니다.</button>

  <br><br><br>

<!-- contents를 사용하여 적용하기 -->  
<!-- css 적용되는 부분이 어디인가?-->
    <iframe src="https://api.jquery.com/" width="50%" height="300" id="frameDemo"></iframe>
    <script>
    $( "#frameDemo" ).contents().find( "a" ).css( "background-color", "red" );
    </script>