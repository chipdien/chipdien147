<script type="text/javascript">
{literal}
$(document).ready(function(){
{/literal}
    var userid = {$smarty.session.id};
{literal}    
    $("#pOfficial_get").click(function(){
        $("#pOfficial_loading").show();
        $.get("ajax/getOfficialPosPresent.php?id="+userid, function(data){
            var arr = data.split("|");
            if (arr[0] == '1'){
                $("#pOfficial-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
                $("#pOfficial-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
                $("#pOfficial_get").remove();
            } else {
                $("#pOfficial-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
                $("#pOfficial-tips").html("<strong>Thất bại:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
            }    
            $("#pOfficial_loading").hide();
    	});
        return false;
    });    
});

function get_quest(id){
	$.get("ajax.php?act=present.exp&questid="+id, function(data){
		var arr = data.split("|");
		if (arr[0] == '1'){
			$("#exp-quest-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
			$("#exp-quest-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#exp\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
			$("#"+id).remove();
			get_repExp();
		}
		if (arr[0] == '0'){
			$("#exp-quest-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
			$("#exp-quest-tips").html("<strong>Lỗi:</strong> "+arr[1]+"<a href=\"#exp\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
		}
	});
	return false;
}
function get_repExp(){
	$.get("ajax.php?act=repExp.get", function(data){
		$("#repValue").html(data);
	});
}
{/literal}
</script>

    <div id="contentpanel">
    <div class="box open">
        <div class="box-title"><div>
            Phần Thưởng Quan Chức
            <a href="#" class="box-toggle"></a>
        </div></div>

        <div class="box-content">
            <p id="pOfficial-tips" class="msg-info" style="display: none;"><a href="#" title="Remove" class="remove-btn">Xóa</a></p>
            
            <p>Bạn đã nhận thưởng đến chức quan: <strong>{$present1.title}</strong></p>   
            {if $present1.sum == 0}  
                <p>Hiện tại bạn đã nhận hết quà, xin hãy quay lại sau khi thăng quan lên cấp cao hơn!</p>
            {else}
                <p>Bạn có thể nhận phần thưởng của các chức quan khác là</p>
                <ul>
                {foreach from=$present1.list key=etitle item=emoney}
                    <li>Chức <strong>{$etitle}</strong> được thưởng <strong>{$emoney}</strong> xu</li>
                {/foreach}
                </ul>
                <p>Tổng cộng, bạn sẽ nhận được phần quà là <strong>{$present1.sum}</strong> xu</p>
                <p class="button" style="width: 75px; float:left;" id="pOfficial_get"><a href="#">Nhận Quà</a></p>
                <span id="pOfficial_loading" class="loading_img"><img src="/templates/images/loading.gif"></span>
                <div class="clear"></div>
            {/if}
        </div>
    </div>
        {*if $smarty.session.id == 1}
        
        <a name="exp"></a>
        <div class="box open">
            <div class="box-title"><div>
                Phần Thưởng Thanh Danh
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
            	{if $QuestOff}
            		<p>{$QuestOff}</p>
            	{else}
                <h2>Thông tin hiện tại:</h2>
                <p>Điểm thanh danh hiện tại của bạn là: <strong>{$present2.Reputation}</strong></p>
                <p>Điểm thanh danh dùng để đổi nhiệm vụ của bạn là: <span id="repValue" style="font-weight: bold; color: green; font-size: 14px;">{$present2.repValue}</span></p>
                <p></p>
                <p id="exp-quest-tips" class="msg-info" style="display: none;"><a href="#" title="Remove" class="remove-btn">Xóa</a></p>
				<div id="ExtraQuest">
					{foreach from=$ExpQst key="qid" item="quest"}
						{if $present2.finishQuest.$qid == null}
							<div id="{$qid}" style="float: left; margin-bottom: 20px; width: 330px; margin-left: 10px; min-height: 300px;">
								<h2 style="text-transform: uppercase; text-decoration: underline;">Nhiệm vụ {$qid}: {$quest.name}</h2>
								<p style="margin-left: 40px;"><b>Yêu cầu:</b><br/>
								{foreach from=$quest.req item="quest_in" key="typeid"}
									- {$quest_in.name} 
									{if $typeid == 11 && $quest_in.num <= $emperor.OfficialGrade}<font color="green">(Đã hoàn thành)</font>{/if}
									{if $typeid == 10}
										{if $quest_in.num <= $present2.repValue}
											<font color="green">{$present2.repValue}</font>/{$quest_in.num} <font color="green">(Đã hoàn thành)</font>
											{else}
											<font color="red">{$present2.repValue}</font>/{$quest_in.num} <font color="red">(Chưa hoàn thành)</font>
										{/if}
									{/if}
									<br/>
								{/foreach}
								</p>
								<p style="margin-left: 40px;"><b>Phần thưởng:</b><br/>
								{foreach from=$quest.get item="quest_get"}
									- {$quest_get.name} {$quest_get.num} Cái<br/>
								{/foreach}
								</p>
								<p id="quest_{$qid}_get" style="float: left; margin-left: 40px; width: 100px;" class="button"><a href="#exp" onclick="get_quest({$qid});">Nhận Thưởng</a></p>
							</div>
						{/if}
					{/foreach}
					<div class="clear"></div>
					{/if}
				</div>
            </div>
        </div>
        {/if*}
    </div>
    <div class="clear"></div>



    
    
            