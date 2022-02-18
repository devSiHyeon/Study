// ajax
$(document).ready(function(){
    $('[name=login_btn]').click(function(){

        var form = document.login_form,
            user_id = form.user_id.value,
            user_pw = form.user_pw.value;

            // 아이디 체크
            if(user_id.length < 4){
                 alert("id 4자 이상 작성하세요");
                 return false;
             }

             // 비밀번호 체크
             if (user_pw.length < 8){
                 alert("pw 8자 이상 작성하세요");
                 return false;
             }    

        $.ajax({
            url:"./process/login.php",
            type:"POST",
            dateType:'json',
            data:{'id':form.user_id.value,'pw':form.user_pw.value},
            success:function(res){

                //var data    = $.parseJSON(res);
                var data    = JSON.parse(res);

                if (data.result == 0) {
                    alert('서비스 오류입니다.\n관리자에게 문의하세요.');
                    
                } else if(data.result == 'id'){
                    alert('아이디 4자 이상 작성하세요');
                } else if(data.result == 'pw'){
                    alert('비밀번호 8자 이상 작성하세요');
                }                               
                else if (data.result == 1) {
                    alert('로그인 성공');
                    window.location.href='./login.php';
                } else {
                    alert('회원정보를 찾을 수 없습니다');
                }        
                //if (data.success == false) alert('정보 불일치');
                
            }
        })
    })
});

