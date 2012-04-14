<form action="" method="post">
    <div id="login">
        <h2>Đăng Nhập</h2>
        
        {if $login_err}
        	<p class="msg-error">{$login_err}</p>
        {/if}
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" >
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" >
        <label><input type="checkbox" value="1" checked="checked" id="rememberMe" name="rememberMe"> &nbsp;Ghi nhớ</label>
        <input type="submit" value="Đăng Nhập" name="submit" >
        <div class="clear"></div>
    </div>
</form>