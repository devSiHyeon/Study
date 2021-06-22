    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- 예제 -->
    <style>
        h2 {
            color:cornflowerblue;
        }
    </style>


<!-- 메뉴 슬라이드 -->
    <!-- > 는 바로 아래라는 뜻 -->
    <script>
        $(function() {

            // > 는 바로 아래라는 뜻
            // .slide > span 은, .slide 바로 아래 span 이라는 뜻이니까 못 찾음
            // .slide > li > span       OR      .slide span 

            $(".slide > li > span").on("mouseover", function() {
            var submenu = $(this).next("ul");
                submenu.slideDown();
            });

            $(".slide > li").on("mouseleave", function() { // 서브 메뉴를 둘러싸고 있는 li 를 벗어나면 감춰지게
            var submenu = $(this).find("ul"); // li 밑에 있는 ul 찾기   
                submenu.slideUp();
            });  

        });

    </script>

    <style>
        .Menu{
            width:500px;
        }
        .slide .hide {
            display:none; 
            position:absolute;
            }

        .slide { 
            display: flex; 
            position:relative;
        }

        .slide > li { 
                width: 200px; 
                list-style: none; 
                text-align:center; 
                background:#e5e5e5;
        }

        .slide { 
            cursor: pointer; 
        }

        .hide > li {
            width:150px;
            height:30px;
            list-style: none;
            text-align: center;
            background-color: #eefcd4;
        }
    </style>

    <div class="Menu">
        <ul class="slide">
            <li>
                <span>병원소개</span>
                <ul class="hide">
                    <li>인사말</li>
                    <li>의료진소개</li>
                    <li>장비소개</li>
                    <li>둘러보기</li>
                </ul>
            </li>

            <li>
                <span>척추센터</span>
                <ul class="hide">
                    <li>목질환</li>
                    <li>허리질환</li>
                    <li>가슴질환</li>
                    <li>골반질환</li>
                </ul>
            </li>

            <li>
                <span>관절센터</span>
                <ul class="hide">
                    <li>무릎질환</li>
                    <li>어깨질환</li>
                    <li>상지질환</li>
                    <li>하지질환</li>
                </ul>
            </li>
        </ul>

    </div>
    <br><br>

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
        <button id="btnStart" onclick="viewMsg()">시작</button>
        <button id="btnStop">중지</button>
        <button id="btnEnd">초기화</button>
    </div>
    <div class="box">
        <div id="bar" class="bar"></div>
    </div>
    <p id="text"></p>

