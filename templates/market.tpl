<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("#pOfficial_get").click(function(){
		$("#pOfficial_loading").show();
		$.get("ajax.php?act=present.official", function(data){
        	var arr = data.split("|");
			if (arr[0] == '1'){
				$("#pOfficial-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
				$("#pOfficial-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this)\">Xóa</a>").fadeIn('slow');	
			}
			$("#pOfficial_loading").hide();
    	});
		return false;
	});
    
});
function sell_item(id){
	var item_num = $("#"+id+"_num").val();
	$.get("ajax.php?act=item.sell&item="+id+"&num="+item_num, function(data){
        var arr = data.split("|");
		if (arr[0] == '0'){
			$("#"+id+"-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
			$("#"+id+"-tips").html("<strong>Lỗi:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this);return false;\">Xóa</a>").fadeIn('slow');	
		}
		if (arr[0] == '1'){
			getItemNum(id);
			$("#"+id+"-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
			$("#"+id+"-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this); return false;\">Xóa</a>").fadeIn('slow');			
		}
	});
	return false;
}
function get_quest(id){
	var num = $("#event_"+id+"_num").val();
	$.get("ajax.php?act=event.get&id="+id+"&num="+num, function(data){
        var arr = data.split("|");
		if (arr[0] == '0'){
			$("#event-"+id+"-tips").removeClass("msg-info msg-error msg-success").addClass('msg-error');
			$("#event-"+id+"-tips").html("<strong>Lỗi:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this);return false;\">Xóa</a>").fadeIn('slow');	
		}
		if (arr[0] == '1'){
			var itemlists = $("#event_"+id+"_list").val();
			itemlist = itemlists.split(",");
			for (var key in itemlist) { getItemNum(itemlist[key]); }
			//itemlist.foreach( function( k, v ) { getItemNum(v); });
			$("#event-"+id+"-tips").removeClass("msg-info msg-error msg-success").addClass('msg-success');
			$("#event-"+id+"-tips").html("<strong>Thành công:</strong> "+arr[1]+"<a href=\"#\" title=\"Remove\" class=\"remove-btn\" onclick=\"messageRemove(this); return false;\">Xóa</a>").fadeIn('slow');			
		}
	});
	return false;
}
function getItemNum(id){
	$.get("ajax.php?act=item.update&item="+id, function(data){
		$("#"+id+"_num_update").html(data);
		$("#event_"+id+"_num_update").html(data);
	});
}
{/literal}
</script>

	<div id="contentpanel">
        <div class="box open">
            <div class="box-title"><div>
                Thanh Lý Vật Phẩm
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
                <h2>Hệ thống chợ và cửa hàng vật phẩm:</h2>
                <p>Một trong những chức năng mới được đưa vào sử dụng là hệ thống chợ. Tại đây người chơi có thể trao đổi, mua và bán các vật phẩm cần thiết như quần áo, bảo rương, cho đến các vật phẩm hỗ trợ xây dựng, quản lý game v.v...</p>    
                
                <h2>Thanh lý vật phẩm:</h2>
                <p>Trong quá trình tổ chức các sự kiện, các thành chủ đã thu thập được nhiều vật phẩm quý. Tuy nhiên vì một lý do nào đó lại chưa nhận thưởng hết các phần quà tặng. Sau khi sự kiện kết thúc, các vật phẩm không còn sử dụng được nữa có thể đem bán thanh lý tại đây.</p>
                
                <p>Lưu ý: trước khi mua/bán, người chơi phải thoát khỏi trò chơi, và vào lại sau khi đã thao tác xong.</p>
                </div>
        </div>
        
        <div class="box open">
            <div class="box-title"><div>
                Hòm Đồ
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
            	{foreach from=$goodids item=item}
            		{assign var=goodsid value=$item.GoodsID}
            		<div id="{$goodsid}_list" style='float: left; width: 374px;'>
                        <div style='width: 70px; float: left;'>
                            <span class='item_num' id="event_{$goodsid}_num_update" style='position: absolute; color: rgb(255, 255, 255); margin-top: 37px; float: right; text-align: right; margin-right: 3px; width: 58px; font-weight: bold;'>{$item.Num}</span>
                            <img src='http://play.lacai.de/res/item/n_item_{$goodsid}.jpg'>
                        </div>
						<div style='float: right; margin-right: 20px; width: 50px; margin-bottom: 5px;'>
                            <form method='post' action='market.php?type=thanhly'>
                            <input type='hidden' name='item' value='{$goodsid}'  />
                            <input type='hidden' name='mode' value='1'  />
                            <input type='text' name='num' id="{$goodsid}_num" value='' style='width: 36px; background: {if $item.Num == 0}#ccc{else}#fff{/if};'/>
                            <br/>
                            <input id="{$goodsid}_sell" type='submit' name='submit' style='width: 52px; margin-top: 2px;' value='Đổi' onclick="javascript:sell_item({$goodsid});return false;" />
                            </form>
                        </div>
						<div style='float: right; width: 230px;'>
                            <h2>{$itemlist.$goodsid.name}</h2>
                            <p>01 {$itemlist.$goodsid.name} đổi được {$itemlist.$goodsid.price} xu.</p>
                        </div>
                        <p id="{$goodsid}-tips" class="msg-info" style="clear: both; margin-right: 18px; display:none;"><a href="#" title="Remove" class="remove-btn">&nbsp;</a></p>
					</div>
				{/foreach}
                <div style="clear: both;"></div>
                <p class="msg-info"><strong>Chú ý:</strong> trước khi click vào nút <strong>ĐỔI</strong>, các thành chủ <strong>bắt buộc phải out khỏi game</strong>!</p>
                
                </div>
        </div>
        
        <div class="box open" id="Event01">
            <div class="box-title"><div>
                Hòm Đồ
                <a href="#" class="box-toggle"></a>
            </div></div>
            
            <div class="box-content">
            	{foreach from=$event1 item=event key=eventid}
            	{if (!$event.req.exp) || (($event.req.exp.min < $emperor.Reputation) && ($event.req.exp.max >= $emperor.Reputation)) }
            		<div id="event{$key}" style='width: 100%; clear: both;'>
            			<form method='post' action='index.php'>
            			{foreach from=$event.in item="item"}
            				{assign var=goodsid value=$item.id}
                        <div style='width: 70px; float: left;'>
                            <span class='item_num' id="{$goodsid}_num_update" style='position: absolute; color: rgb(255, 255, 255); margin-top: 37px; float: right; text-align: right; margin-right: 3px; width: 58px; font-weight: bold;'>{$event1inv.$goodsid}</span>
                            <img src='http://play.lacai.de/res/item/n_item_{$goodsid}.jpg'>
                        </div>
                        {/foreach}
						<div style='float: right; margin-right: 20px; width: 50px; margin-bottom: 5px;'>
                            <input type='hidden' name='item' value='{$event1_items.$eventid}' id="event_{$eventid}_list" />
                            <input type='hidden' name='mode' value='1'  />
                            <input type='text' name='num' id="event_{$eventid}_num" value='' style='width: 36px; background: {if $event1inv.$goodsid == 0}#ccc{else}#fff{/if};'/>
                            <br/>
                            <input id="event_{$eventid}_sell" type='submit' name='submit' style='width: 52px; margin-top: 2px;' value='Đổi' onclick="javascript:get_quest({$eventid});return false;" />
                        </div>
                        <div style='width: 70px; float: right;'>
                            <span class='item_num' style='position: absolute; color: rgb(255, 255, 255); margin-top: 37px; float: right; text-align: right; margin-right: 3px; width: 58px; font-weight: bold;'>{$event1inv.out.0.id}</span>
                            <img src='http://play.lacai.de/res/item/n_item_{$event1_out.$eventid}.jpg'>
                        </div>
						<div style='float: right; width: 465px;'>
                            <h2>{$event.name}</h2>
                            <p>{$event.desc} <br><b>Bạn muốn đổi bao nhiêu {$event.name}?</b></p>
                        </div>
                        <p id="event-{$eventid}-tips" class="msg-info" style="clear: both; margin-right: 18px; display:none;"><a href="#" title="Remove" class="remove-btn">&nbsp;</a></p>
                        </form>
					</div>
				{/if}
				{/foreach}
                <div style="clear: both;"></div>
                <p class="msg-info"><strong>Chú ý:</strong> trước khi click vào nút <strong>ĐỔI</strong>, các thành chủ <strong>bắt buộc phải out khỏi game</strong>!</p>
                
                </div>
        </div>
    </div>
    <div class="clear"></div>
    