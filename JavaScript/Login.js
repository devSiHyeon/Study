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
            url:"./LoginProcess.php",
            type:"POST",
            dateType:'json',
            data:{'id':form.user_id.value,'pw':form.user_pw.value},
            success:function(res){

                //var data = JSON.parse(res);
                var data    = $.parseJSON(res);

                if (data.success == true) {
                    alert('로그인 성공');
                    window.location.href='./Login.php';
                } else {
                    alert('정보 불일치');
                }
                //if (data.success == false) alert('정보 불일치');
                
            }
        })
    })
});

