// ajax
$(document).ready(function(){
    $('[name=logout_btn]').click(function(){    
        
        $.ajax({
            url:"./Logout.php",
            type:"POST",
            dateType:'json',
            data:'',
            success:function(res){

                var data = $.parseJSON(res);
                if (data.success == true) {
                    alert('로그아웃 되었습니다.');
                    window.location.href='./Login.php';
                }                
            }
        })
    })
});

