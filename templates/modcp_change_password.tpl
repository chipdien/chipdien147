<script type="text/javascript">
$(document).ready(function(){
    $("#username").change(function(){
        var username = $("#username").val();
        $("#username_hints").html();
        $.ajax({
            type: "POST",
            url: "ajax.php?mod=modcp&act=search.account",
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
                    $("#userid").val(arr[1]);
                    $("#button_pwdchange").show();
                    $("#button_pwdchange_inactive").hide();
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
                Đổi Mật Khẩu Tài Khoản
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
                <h2>Cảnh báo:</h2>
                <p>Các GM lưu ý không tự ý đổi mật khẩu cho thành viên qua chức năng này nếu chưa xác minh rõ chủ tài khoản là ai. Khi các thành viên yêu cầu đổi mật khẩu do bị mất hoặc quên mật khẩu, GM phải có trách nhiệm xác minh chủ tài khoản trước khi thực hiện công việc này!</p>
                <p>Tốt nhất là những trường hợp cần lấy lại pass thì liên lạc trực tiếp với chipdien</p>
                <h2>Đổi mật khẩu tài khoản:</h2>
                <form id="form_account_password_change" action="" method="POST" >
                <div class="row">
                    <div class="labels"><label for="title">Tên đăng nhập:</label></div>
                    <div class="inputs"><input type="text" id="username" name="username" value=""></div>
                    <input type="hidden" value="" name="userid" id="userid" />
                    <div class="hints" id="username_hints"></div>
                    <div class="clear"></div>
                </div>
                
                <div class="row">
                    <div class="labels"><label for="title">Password:</label></div>
                    <div class="inputs"><input type="text" id="password" name="password" value=""></div>
                    <div class="hints" id="password_hints"></div>
                    <div class="clear"></div>
                </div>
                </form>
                <div class="row">
                    <p id="button_pwdchange" class="button" style=" display: none; width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Đổi</p>
                    <p id="button_pwdchange_inactive" class="button" style="display:block; background: red;width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Đổi</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="clear"></div>
