{config_load file="test.conf" section="dirs"}
{include file="header.tpl" title=foo}

{if $is_logged_in}
	{include file="nav.tpl"}
	{include file="sidebar.tpl"}
{/if}
	
{include file=$view}
{include file="footer.tpl"}
