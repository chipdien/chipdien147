    <div id="footer">&copy; <strong>Đắc Kỷ Việt Nam</strong> 2011. All rights reserved!</div>

    <!-- Modal Dialog Example -->  
    <div id="modal" class="modal-container">
        <h2>Pop Up Example</h2>
        <p>This is a pop up example. Arcu magna vulputate nunc, at sollicitudin enim mi molestie massa.</p>
        <h2>Content</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eu auctor neque. Arcu magna vulputate nunc, at sollicitudin enim mi molestie massa. Ut quis urna elit, ac ultrices nisl. Donec placerat blandit nunc nec ultricies.</p>
        <h2>Form Example</h2>

        <label for="username">Username:</label>
        <input type="text" id="username" />
        <label for="password">Password:</label>
        <input type="text" id="password" />
        <input type="submit" value="Submit" />
        <div class="clear"></div>
    </div>
    <div id="mask"></div>

{if $smarty.session.id == 2000004 || $smarty.session.id == 3000001}
	{debug}
{/if}
    <!-- End of Modal Dialog Example -->
</body>

</html>