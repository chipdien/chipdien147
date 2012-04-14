    <div id="menubar" class="wrapper box-title"><div>
        <ul id="mainnav">
            <li {if $currMenu == 'index'} class="active"{/if}><a href="index.php" title="">Tổng Quan</a></li>
            <li {if $currMenu == 'present'} class="active"{/if}><a href="present.php" title="">Nhận Thưởng</a></li>
            <li {if $currMenu == 'shop'} class="active"{/if}><a href="shop.php" title="">Chợ</a></li>
            <li {if $currMenu == 'profile'} class="active"{/if}><a href="profile.php" title="">Trang Cá Nhân</a></li>
            
            <!--
            <li {if $smarty.get.mod == 'profile'} class="active"{/if}><a href="profile.php" title="">Trang Cá Nhân</a></li>
            <li {if $smarty.get.mod == 'present'} class="active"{/if}><a href="present.php" title="">Nhận Thưởng</a></li>
            <!--<li {if $smarty.get.mod == 'quest'} class="active"{/if}><a href="quest.php" title="">Nhiệm Vụ</a></li>-->
            <!--
            <li {if $smarty.get.mod == 'market'} class="active"{/if}><a href="market.php" title="">Chợ</a></li>
			{if $smarty.session.id == 1}
				<li {if $smarty.get.mod == 'magic'} class="active"{/if}><a href="index.php?mod=magic" title="">Magic</a></li>
			{/if}
            -->
            
            {if $smarty.session.id == 2000004}
                <li {if $smarty.get.mod == 'modcp'} class="active"{/if}><a href="modcp.php" title="">ModCP</a></li>
                <li {if $smarty.get.mod == 'modcp'} class="active"{/if}><a href="dev.php" title="">DEV</a></li>
            {/if}
            <!--<li <?php if($section['active'] == 'inventory') echo ' class="active"'; ?>><a href="inventory.php" title="">Hòm Đồ</a></li>-->

            <!--<li><a href="./6.html" title="">Settings</a></li>
            <li><a href="#modal" title="" class="modal">Modal Popup</a></li>-->
        </ul>
        <div id="loginbar">
            Chào bạn <span style="color: #fff; font-weight: bold;">{$smarty.session.usr}</span>, <a href="index.php?logoff" title="Đăng xuất">Đăng xuất</a>?
        </div>
        <div class="clear"></div>
    </div></div> 