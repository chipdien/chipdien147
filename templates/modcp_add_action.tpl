<script type="text/javascript">
$(document).ready(function(){
    $.get("ajax/modcp_actgroup.php?type=list_select", function(msg){
        $("#select_actgroup").html(msg);
    });
    $("#select_actgroup").change(function(){
        var actgroup_id = $("#select_actgroup").val();
        $.get("ajax/modcp_actgroup.php?type=detail&id="+actgroup_id, function(msg){
            $("#actgroup_detail_box").html(msg);
        });
        $("#actgroup_detail").show();
    });
    $("#username").change(function(){
        var username = $("#username").val();
        $.ajax({
            type: "POST",
            url: "ajax/modcp_action.php?type=search_account",
            data: "username="+username,
            dataType: "json",
            success: function(data){
                $("#username_hints").html(data.msg);
                $("#userid").val(data.userid);
                if (data.status) {
                    $("#button_username").show();
                    $("#button_username_inactive").hide();
                } else {
                    $("#button_username").hide();
                    $("#button_username_inactive").show();
                }
            }
        });
        
    });
    $("#goodsid").change(function(){
        var goodsid = $("#goodsid").val();
        $.ajax({
            type: "POST",
            url: "ajax/modcp_action.php?type=search_good",
            data: "goodsid="+goodsid,
            dataType: "json",
            success: function(data){
                $("#goodsid_hints").html(data.msg);
                $("#goodsname").val(data.good);
                if (data.status) {
                    $("#button_good").show();
                    $("#button_good_inactive").hide();
                } else {
                    $("#button_good").hide();
                    $("#button_good_inactive").show();
                }
            }
        });
    });
    $("#button_username").click(function(){
        var username = $("#username").val();
        var userid = $("#userid").val();
        var groupid = $("#select_actgroup").val();
        $.ajax({
            type: "POST",
            url: "ajax/modcp_action.php?type=add_receiver",
            data: "username="+username+"&userid="+userid+"&groupid="+groupid,
            dataType: "json",
            success: function(data){
                $("#username_hints").html(data.msg);
                if (data.status) {
                    $("#username").val("");
                    $("#userid").val(0);
                    $("#button_username").hide();
                    $("#button_username_inactive").show();
                    reload_actgroup(groupid);
                }
            }
        });
    });
    $("#button_good").click(function(){
        var goodsid = $("#goodsid").val();
        var goodsnum = $("#goodsnum").val();
        var goodsname = $("#goodsname").val();
        var groupid = $("#select_actgroup").val();
        $.ajax({
            type: "POST",
            url: "ajax/modcp_action.php?type=add_good",
            data: "goodsid="+goodsid+"&goodsnum="+goodsnum+"&groupid="+groupid+"&goodsname="+goodsname,
            dataType: "json",
            success: function(data) {
                $("#goodsid_hints").html(data.msg);
                if(data.status) {
                    $("#goodsid").val("");
                    $("#goodsnum").val(0);
                    $("#goodsname").val("");
                    $("#button_good").hide();
                    $("#button_good_inactive").show();
                    reload_actgroup(groupid);
                }
            }
        });
    });
    
});
function reload_actgroup(id){
    $.get("ajax/modcp_actgroup.php?type=detail&id="+id, function(msg){
        $("#actgroup_detail_box").html(msg);
    });
}
function delete_receiver(id,group){
    $.get("ajax/modcp_action.php?type=del_receiver&userid="+id+"&groupid="+group, function(data){
        if(data.status){
            reload_actgroup(group);
        }
    }, "json");
}
function delete_good(id,group){
    $.get("ajax/modcp_action.php?type=del_good&goodsid="+id+"&groupid="+group, function(data){
        if(data.status){
            reload_actgroup(group);
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
        
        <div class="box open settings">
            <div class="box-title"><div>
                Thiết kế Nhóm tặng phẩm
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
                <form action="" method="post">
                    <div class="row">
                        <div class="labels"><label for="group">Nhóm tặng phẩm:</label></div>
                        <div class="inputs">
                            <select id="select_actgroup">
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="row">
                        <div class="labels"><label for="title">Người nhận:</label></div>
                        <div class="inputs"><input type="text" id="username" name="username" value=""></div>
                        <input type="hidden" value="" name="userid" id="userid" />
                        <div class="hints" id="username_hints"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="row">
                        <p id="button_username" class="button" style=" display: none; width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Thêm</p>
                        <p id="button_username_inactive" class="button" style="display:block; background: red;width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Thêm</p>
                    </div>
                    
                    <div class="row">
                        <div class="labels"><label for="title">Vật phẩm:</label></div>
                        <div class="inputs"><input type="text" id="goodsid" name="goodsid" value=""></div>
                        <div class="hints" id="goodsid_hints"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="row">
                        <div class="labels"><label for="title">Số lượng:</label></div>
                        <div class="inputs"><input type="text" id="goodsnum" name="goodsnum" value="0"></div>
                        <div class="hints"></div>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" value="false" id="goodsname" name="goodsname" />
                    <div class="row">
                        <p id="button_good" class="button" style="display:none; width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Thêm</p>
                        <p id="button_good_inactive" class="button" style="display: block; background: red; width: 60px; margin-left: 318px; margin-top: 0px; margin-bottom: 15px;">Thêm</p>
                    </div>
                    
                </form>

            </div>
        </div>
        
        
        
        
    </div>
    <div class="clear"></div>