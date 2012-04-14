<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("#reg_submit").click(function(){
		var username = $("#username").val();
		var email = $("#email").val();
		$("#msg-tips").show();
		$.ajax({
			type: "POST",
			url: "ajax.php?act=account.register",
			data: "username="+username+"&email="+email+"&submit=register",
			success: function(data){
				var arr = data.split("|");
				if (arr[0] == '1'){
					$("#msg-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
					$("#msg-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
				} else {
					$("#msg-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
					$("#msg-tips").html("<strong>Lỗi:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');
				}
				//$("#msg-").hide();
			}
		});
		return false;
	});
    
});
{/literal}
</script>
<form action="index.php?act=reg" method="post">
    <div id="login">
        <h2>Đăng Ký</h2>
        
        <p id="msg-tips" class="msg-info" style="display: none;"><img style="width: 28px;" src="images/loading.gif"></p>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" >
        <label for="password">Email:</label>
        <input type="text" id="email" name="email" >
        <!--<label><input type="checkbox" value="1" checked="checked" id="rememberMe" name="rememberMe"> &nbsp;Ghi nhớ</label>-->
        <input type="submit" value="Đăng Ký" id="reg_submit" name="submit" >
        <div class="clear"></div>
        <?php } ?>
    </div>
</form>