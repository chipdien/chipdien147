<script type="text/javascript">
$(document).ready(function(){
    $("#submit_add_actgroup").click(function(){
        var title = $("input[name=title]").val();
        var desc = $("input[name=desc]").val();
        var content = $('textarea#actgroup_content').val();
        $.ajax({
            type: "POST",
            url: "/ajax/modcp_actgroup.php?type=add",
            data: "title="+title+"&desc="+desc+"&content="+content,
            success: function(msg) {
                var arr = msg.split("|");
                if (arr[0] == '1'){	
                    $("#form_msg").removeClass("msg-info msg-error msg-success").addClass('msg-success');
                    $("#form_msg").html("<strong>Thành công:</strong> "+arr[1]+"<a href='#' title='Remove' class='remove-btn' onclick='messageRemove(this)'>Xóa</a>").fadeIn('slow');
                    $('#form_add_actgroup')[0].reset();
                    $.get("/ajax/modcp_actgroup.php?type=list", function(msg){
                        $("#actgroup_list").html(msg);
                    });
                } else {
                    $("#form_msg").removeClass("msg-info msg-error msg-success").addClass('msg-error');
                    $("#form_msg").html("<strong>Thất bại:</strong> "+arr[1]+"<a href='#' title='Remove' class='remove-btn' onclick='messageRemove(this)'>Xóa</a>").fadeIn('slow');
                }
            }
        });
        
        return false; 
    });
    $.get("/ajax/modcp_actgroup.php?type=list", function(msg){
        $("#actgroup_list").html(msg);
    });
    
});
</script>

<div id="contentpanel">
    <div class="box open">
        <div class="box-title"><div>Thêm nhóm tặng phẩm<a href="#" class="box-toggle"></a></div></div>
        <div class="box-content">
            <p id="form_msg" style="display: none;"></p>
            <form id="form_add_actgroup" method="post" action="">
                <h2>Tiêu đề:</h2>
                <input type="text" name="title" value="" style="background: #fff;"/>
                <h2>Phụ chú/ Ghi chú:</h2>
                <input type="text" name="desc" value="" style="background: #fff;"/>
                <h2>Nội dung:</h2>
                <textarea id="actgroup_content" cols="" rows="20" name="content" style="background: #fff;"></textarea>
                <input id="submit_add_actgroup" type="submit" name="submit" value="Thêm">
            </form>
        </div>
    </div>
    
    <div class="box open">
        <div class="box-title"><div>Danh sách nhóm tặng phẩm<a href="#" class="box-toggle"></a></div></div>
        <div class="box-content tabular-view" id="actgroup_list">

        </div>
    </div>
</div>
<div class="clear"></div>


