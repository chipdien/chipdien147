<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("#password_change").click(function(){
        var forumpassword = $("#4rumpassword").val();
        var oldpassword = $("#oldpassword").val();
        var newpassword = $("#newpassword").val();
        var retype_password = $("#retype_password").val();
        $("#password_loading").show();
        $.ajax({
            type: "POST",
            url: "ajax/changePassword.php",
            data: "forumpassword="+forumpassword+"&oldpassword="+oldpassword+"&newpassword="+newpassword+"&retype_password="+retype_password+"&submit=Lưu",
            success: function(data){
                var arr = data.split("|");	
                if (arr[0] == '1'){
                    $("#password-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
                    $("#password-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
                } else {
                    $("#password-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
                    $("#password-tips").html("<strong>Lỗi::</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');
                }
                $("#password_loading").hide();		
            }
        });
        return false;
    });
        
	$("#email_change").click(function(){
		var email = $("#email").val();
		$("#email_loading").show();
		$.ajax({
			type: "POST",
			url: "ajax.php?act=email.change",
			data: "email="+email+"&submit=Lưu",
			success: function(data){
				var arr = data.split("|");
				if (arr[0] == '1'){
					$("#email-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
					$("#email-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
				} else {
					$("#email-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
					$("#email-tips").html("<strong>Lỗi:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');
				}
				$("#email_loading").hide();
			}
		});
		return false;
	});
	$("#emperorname_change").click(function(){
		var change_name = $("#change_name").val();
		$("#emperorname_loading").show();
		$.ajax({
			type: "POST",
			url: "ajax.php?act=emperorname.change",
			data: "change_name="+change_name+"&submit=Lưu",
			success: function(data){
				var arr = data.split("|");
				if (arr[0] == '1'){
					$("#emperorname-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
					$("#emperorname-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
				} else {
					$("#emperorname-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
					$("#emperorname-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');
				}
				$("#emperorname_loading").hide();
			}
		});
		return false;
	});
    
});
{/literal}
</script>

    <div id="contentpanel">
        <div class="box open settings">
            <div class="box-title"><div>
                Thay Đổi Mật Khẩu
                <a href="#" class="box-toggle"></a>
            </div></div>
            <form action="ajax.php?act=password.change" method="post">
            <div class="box-content">

                <p id="password-tips" class="msg-info" style="display: none;"><a href="#" title="Remove" class="remove-btn">Xóa</a></p>

                <div class="row">
                    <div class="labels"><label for="4rumpassword">Mật khẩu diễn đàn:</label></div>
                    <div class="inputs"><input type="password" id="4rumpassword" name="4rumpassword" value=""></div>
                    <div class="hints">Nhập mật khẩu diễn đàn hiện tại vào đây!</div>
                    <div class="clear"></div>
                </div>
                <div class="row">
                    <div class="labels"><label for="oldpassword">Mật khẩu hiện tại:</label></div>
                    <div class="inputs"><input type="password" id="oldpassword" name="oldpassword" value=""></div>
                    <div class="hints">Nhập mật khẩu hiện tại vào đây!</div>
                    <div class="clear"></div>
                </div>
                <div class="row">
                    <div class="labels"><label for="newpassword">Mật khẩu mới:</label></div>
                    <div class="inputs"><input type="password" id="newpassword" name="newpassword" value=""></div>
                    <div class="hints">Mật khẩu mới phải <span style="color: red; font-weight: bold;">từ 6 đến 16 ký tự</span> và phải có ít nhất 3 trong 4 điều kiện sau:<br/>
                    - có sử dụng ký tự viết thường: <span style="color: red; font-weight: bold;">a..z</span><br/>
                    - có sử dụng ký tự viết hoa: <span style="color: red; font-weight: bold;">A-Z</span><br/>
                    - có sử dụng số: <span style="color: red; font-weight: bold;">0-9</span><br/>
                    - có sử dụng ký tự đặc biệt: <span style="color: red; font-weight: bold;">! @ # $ % ^ & * ( ) + = . _ -</span>  
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="row">
                    <div class="labels"><label for="retype_password">Xác nhận mật khẩu mới:</label></div>
                    <div class="inputs"><input type="password" id="retype_password" name="retype_password" value=""></div>
                    <div class="hints">Nhập lại mật khẩu mới một lần nữa vào đây để xác nhận việc thay đổi mật khẩu của bạn.</div>
                    <div class="clear"></div>
                </div>
                <p class="row">
                    <input type="submit" value="Lưu" name="submit" id="password_change" >
                    <input type="reset" value="Hủy" />
                    <span id="password_loading"><img style="width: 28px;" src="images/loading.gif"></span>
                </p>
            </div>
            </form>
        </div>
        
        {*
        <div class="box open settings">
            <div class="box-title"><div>
                Thay Đổi Email
                <a href="#" class="box-toggle"></a>
            </div></div>
            <form action="ajax.php?act=email.change" method="post">
            <div class="box-content">
            
                <p id="email-tips" class="msg-info" style="display: none;"></p>
                
                <div class="row">
                    <div class="labels"><label for="email">E-mail Address:</label></div>
                    <div class="inputs"><input type="text" id="email" name="email" value="{$profile.email}"></div>
                    <div class="hints">Địa chỉ email của bạn chỉ hiển thị cho người quản trị. Địa chỉ này sẽ dùng để thông báo những thông tin quan trọng từ trò chơi.</div>
                    <div class="clear"></div>
                </div>

                <p class="row">
                    <input type="submit" value="Lưu" name="submit" id="email_change" >
                    <input type="reset" value="Hủy" />
                    <span id="email_loading"><img style="width: 28px;" src="images/loading.gif"></span>
                </p>
            </div>
            </form>
   
        </div>
        
        <div class="box open settings">
            <div class="box-title"><div>
                Đổi Tên Thành Chủ (In-Game)
                <a href="#" class="box-toggle"></a>
            </div></div>
            <form action="profile.php?act=emperorname.change" method="post" name="form_change_name" id="form_change_name">
            <div class="box-content">
            
                <p id="change_name-tips" class="msg-info" style="display: none;"></p>
                
                {if $profile.requestname}
                <div class="row">
                	<p style="color: green;">Bạn đã đăng ký đổi tên thành chủ, tên thành chủ mới của bạn sau khi máy chủ bảo trì là <b>{$profile.requestname}</b>. Xin bạn vui lòng chờ đến khi máy chủ bảo trì xong!</p>
                </div>
                {else}
                <div class="row">
                    <div class="labels"><label for="email">Tên thành chủ (In-Game):</label></div>
                    <div class="inputs"><input type="text" id="change_name" name="change_name" value="{$emperor.EmperorName}"></div>
                    <div class="hints">Lưu ý:<br>- Mỗi lần đổi tên sẽ mất <b>100 xu</b>!. Quá trình đổi tên này không có giá trị ngay lập tức! Tên của bạn chỉ được thay đổi sau khi bảo trì hệ thống!<br>- Tên thành chủ không được dài quá 15 ký tự!<br>- Chỉ cho phép các ký tự sau: <span style="color: green;">a-z A-Z 0-9 _-.</span> </div>
                    <div class="clear"></div>
                </div>
                
                <p class="row">
                    <input id="emperorname_change" type="submit" value="Lưu" name="submit" >
                    <input type="reset" value="Hủy" />
                    <span id="emperorname_loading"><img style="width: 28px;" src="images/loading.gif"></span>
                </p>
                {/if}
            </div>
            </form>
   
        </div>
        *}
        
    </div>
    <div class="clear"></div> 
    
            