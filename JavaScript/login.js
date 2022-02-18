// ajax
$(document).ready(function(){
    $('[name=login_btn]').click(function(){

        var form = document.login_form;
        var user_id = form.user_id.value,
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

                //var data = $.parseJSON(res);       // 낮은 버전에서 사용 현재는 많이 사용하지 않음
                var data    = JSON.parse(res);

                if (data.success == 0) {
                    alert('서비스 오류입니다.\관리자에게 문의하세요.');
                    
                } else if (data.success == 1) {
                    alert('로그인 성공');
                    window.location.href='./login.php';
                } else {
                    alert('정보 불일치');
                }        
                //if (data.success == false) alert('정보 불일치');
                
            }
        })
    })
});
