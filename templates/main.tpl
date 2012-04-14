<script type="text/javascript">
{literal}
$(document).ready(function(){
{/literal}
    var userid = {$smarty.session.id};
{literal}
    $("#getNewbiePresent").click(function(){
        $("#getNewbiePresent_loading").show();
            $.get("ajax/getNewbiePresent.php?id="+userid, function(data){
        	var arr = data.split("|");
                if (arr[0] == '1'){
                    $("#getNewbiePresent-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
                    $("#getNewbiePresent-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
                    $("#getNewbiePresent").remove();    
                } else {
                    $("#getNewbiePresent-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
                    $("#getNewbiePresent-tips").html("<strong>Thất bại:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');    
                }
                $("#getNewbiePresent_loading").hide();
            });
            return false;
	});    
    });
{/literal}
</script>



    <div id="contentpanel">
        <div class="box open">
            <div class="box-title"><div>
                Thông Báo
                <a href="#" class="box-toggle"></a>
            </div></div>
            <div class="box-content">
                <h2>Chào mừng các bạn đã gia nhập cộng đồng game thủ Đắc Kỷ Private!</h2>
                <p>Để game ngày càng phát triển tốt hơn và hay hơn, đáp ứng được nhu cầu và lòng yêu thích của các bạn, chúng tôi rất mong nhận được nhiều ý kiến đóng góp của các bạn.</p>
                <p>Mọi ý kiến đóng góp, xin các bạn vui lòng post bài vào diễn đàn: <a href="http://diendan.lacai.de/forumdisplay.php?5-C%C3%A1ch-T%C3%A2n-Vi%E1%BB%87n" target="blank"><b>Cách Tân Viện</b></a></p>
            </div>
            
            {if $NewbiePresent}
            <div class="box-title"><div>
                Quà tặng tân thủ
                <a href="#" class="box-toggle"></a>
            </div></div>
            <div class="box-content">
                <p id="getNewbiePresent-tips" class="msg-info" style="display: none;"><a href="#" title="Remove" class="remove-btn">Xóa</a></p>
                <h2>Quà tặng tân thủ</h2>
                <p>Thật may mắn khi một người tài giỏi như quý thành chủ lại quyết định tham gia cứu đời, dẹp loạn, bình thiên hạ. Nữ Oa Nương Nương vô cùng cảm kích trước tấm lòng và dũng khí của quý thành chủ nên mang tặng thành chủ:<br/>
                    - 1 Kinh Nghiệm VIP(Tuần)<br/>
                    - 1 Chiến Đấu VIP(Tuần)<br/>
                    - 1 Sản Xuất VIP(Tuần)<br/>
                    - 1 Hoàng Đế Lệnh(Tuần)<br/>
                    - 1 Hiên Viên Lệnh(Tuần)<br/>
                    - 2 Cáo Thị Tuyển Dụng<br/>
                    - 3 Thần Kỳ Tiên Hạnh</p>
                <p class="button" style="width: 75px; float:left;" id="getNewbiePresent"><a href="#">Nhận Quà</a></p>
                <span id="getNewbiePresent_loading" class="loading_img"><img src="images/loading.gif"></span>
                <div class="clear"></div>

            </div>
            {/if}
        </div>
    </div>
    <div class="clear"></div>