<script type="text/javascript">
$(document).ready(function(){
    $("#username").change(function(){
        var username = $("#username").val();
        $("#username_hints").html();
        $.ajax({
            type: "POST",
            url: "ajax.php?mod=modcp&act=view.account",
            data: "username="+username,
            success: function(msg){
            	var arr = msg.split("|");
                if(arr[0] == '0') {
                    $("#username_hints").html("&nbsp;<font color='red'>"+arr[1]+"</font>");
                    $("#userid").val("0");
                    $("#button_pwdchange").hide();
                    $("#button_pwdchange_inactive").show();
                } else {
                    $("#username_hints").html("&nbsp;<font color='green'>Tài khoản hợp lệ, UserID là <b>"+arr[1]+"</b></font>");
                    $("#result_info").html(arr[2]);
                    $("#userid").val(arr[1]);
                }
            }
        });
    });
    $("#button_pwdchange").click(function(){
        var username = $("#username").val();
        var userid = $("#userid").val();
        var password = $("#password").val();
        $.ajax({
            type: "POST",
            url: "ajax.php?mod=modcp&act=change.password",
            data: "username="+username+"&userid="+userid+"&password="+password,
            success: function(msg){
            	var arr = msg.split("|");
                if(arr[0] == '1') {
                    $("#username_hints").html("<font color='green'>Đổi mật khẩu tài khoản thành công!</font>");
                    $("#form_account_password_change")[0].reset();
                } else {
                    $("#username_hints").html("<font color='red'>"+arr[1]+"</font>");
                }
            }
        });
    });
});
</script>

    <div id="contentpanel">
        <div class="box open settings">
            <div class="box-title"><div>
                Xem Thông Tin Tài Khoản
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
                <h2>Thông tin tài khoản:</h2>
                <p>Nhập Username của tài khoản để kiểm tra thông tin.</p>
                
                <form id="form_account_password_change" action="" method="POST" >
                <div class="row">
                    <div class="labels"><label for="title">Tên đăng nhập:</label></div>
                    <div class="inputs"><input type="text" id="username" name="username" value=""></div>
                    <input type="hidden" value="" name="userid" id="userid" />
                    <div class="hints" id="username_hints"></div>
                    <div class="clear"></div>
                </div>
                
                <div id="result_info"></div>

                </form>
            </div>
        </div>
        
    </div>
    <div class="clear"></div>
