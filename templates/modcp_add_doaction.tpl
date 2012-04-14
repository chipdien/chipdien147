<script type="text/javascript">
$(document).ready(function(){
    $.get("ajax/modcp_actgroup.php?type=list&actionbutton=view", function(msg){
        $("#actgroup_list").html(msg);
    });
    $.get("ajax/modcp_actgroup.php?type=list&active=1&actionbutton=view", function(msg){
        $("#actgroup_list_done").html(msg);
    });
});
function reload_actgroup(id){
    $.get("ajax/modcp_actgroup.php?type=detail&id="+id+"&button=1", function(msg){
        $("#actgroup_detail_box").html(msg);
    });
    $("#actgroup_detail").show();
}
function actgroup_run(groupid){
        $.get("ajax/modcp_actgroup.php?type=actrun&groupid="+groupid, function(msg){
            if(msg.status) {
                $("#actgroup_detail_box").html("<p class='msg-success'><strong>Thành công:</strong> Đã gửi quà tặng thành công đến các thành chủ!<a href='#' title='Remove' class='remove-btn'>Xóa</a></p>");
                $.get("ajax/modcp_actgroup.php?type=activated&groupid="+groupid, function(data){
                    if(data.status) {
                        $.get("ajax/modcp_actgroup.php?type=list&actionbutton=view", function(msg){
                            $("#actgroup_list").html(msg);
                        });
                        $.get("ajax/modcp_actgroup.php?type=list&active=1", function(msg){
                            $("#actgroup_list_done").html(msg);
                        });
                    }
                });
            }
        }, "json");
}
</script>

<div id="contentpanel">
        <div class="box open" id="actgroup_detail" style="display: none;">
            <div class="box-title"><div>
                Thông tin chi tiết Nhóm tặng phẩm
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content" id="actgroup_detail_box">
            </div>
        </div>
    
    <div class="box open">
        <div class="box-title"><div>Danh sách nhóm tặng phẩm<a href="#" class="box-toggle"></a></div></div>
        <div class="box-content tabular-view" id="actgroup_list">

        </div>
    </div>
    
    <div class="box open">
        <div class="box-title"><div>Danh sách nhóm tặng phẩm đã được trao<a href="#" class="box-toggle"></a></div></div>
        <div class="box-content tabular-view" id="actgroup_list_done">

        </div>
    </div>
</div>
<div class="clear"></div>