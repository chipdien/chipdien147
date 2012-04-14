<script type="text/javascript">
$(document).ready(function(){
    $("#submit_add_quest").click(function(){
        var title = $("input[name=title]").val();
        var content = $("textarea#quest_content").val();
        var brief = $('textarea#quest_brief').val();
        var target = $('input[name=target]').val();
        var type = $('select[name=type]').val();
        $.ajax({
            type: "POST",
            url: "ajax.php?mod=dev&act=manage.quest&type=add",
            data: "title="+title+"&brief="+brief+"&content="+content+"&target="+target+"&type="+type,
            success: function(msg) {
                if (msg == 'OK') {
                    $("#form_msg").html("<strong>Thành công:</strong> Đã thêm thành công! <a href='#' title='Remove' class='remove-btn'>Xóa</a>").addClass("msg-success").show();
                    $('#form_add_quest')[0].reset();
                    $.get("ajax.php?mod=modcp&act=manage.actgroup&type=list", function(msg){
                        $("#quest_list").html(msg);
                    });
                } else {
                    $("#form_msg").html("<strong>Lỗi:</strong> "+msg+" <a href='#' title='Remove' class='remove-btn'>Xóa</a>").addClass("msg-error").show();
                }
            }
        });
        
        return false; 
    });
    // @TODO: list and edit quest!
    $.get("ajax.php?mod=dev&act=manage.quest&type=list", function(msg){
        $("#quest_list").html(msg);
    });
    
});
</script>

<div id="contentpanel">
    <div class="box open">
        <div class="box-title"><div>Thêm nhiệm vụ <a href="#" class="box-toggle"></a></div></div>
        <div class="box-content">
            <p id="form_msg" style="display: none;"></p>
            <form id="form_add_quest" method="post" action="">
                <h2>Tiêu đề:</h2>
                <input type="text" name="title" value="" style="background: #fff;"/>
                <h2>Giới thiệu nhiệm vụ:</h2>
                <textarea id="quest_content" cols="" rows="20" name="content" style="background: #fff;"></textarea>
                <h2>Hướng dẫn nhiệm vụ:</h2>
                <textarea id="quest_brief" cols="" rows="20" name="brief" style="background: #fff;"></textarea>
                <h2>Phần thưởng</h2>
                <input type="text" name="target" value="" style="background: #fff;"/>
                <h2>Nhóm nhiệm vụ</h2>
                <select name="type">
                    <option value="0">Nhiệm vụ tân thủ</option>
                    <option value="1">Nhiệm vụ chính </option>
                    <option value="2">Nhiệm vụ tầm tiên </option>
                    <option value="3">Nhiệm vụ chiến đấu </option>
                    <option value="4">Nhiệm vụ bang hội </option>
                    <option value="5">Nhiệm vụ tu luyện </option>
                    <option value="6">Nhiệm vụ thiên mệnh </option>
                    <option value="7">Nhiệm vụ hàng ngày </option>
                    <option value="8">Nhiệm vụ nô lệ </option>
                </select>
                <input id="submit_add_quest" type="submit" name="submit" value="Thêm">
            </form>
        </div>
    </div>
    
    <div class="box open">
        <div class="box-title"><div>Danh sách nhóm tặng phẩm<a href="#" class="box-toggle"></a></div></div>
        <div class="box-content tabular-view" id="quest_list">

        </div>
    </div>
</div>
<div class="clear"></div>