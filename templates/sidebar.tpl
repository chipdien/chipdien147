    <div id="sidebar">
        <div class="box open userbar">
            <div class="box-title"><div>
                Thông Tin Nhân Vật
                <a href="#" class="box-toggle"></a>
            </div></div>
            <div class="box-content">
                <p style="width: 100%; font-size: 15px;"><strong>{$emperor.EmperorName}</strong> <span>(Lvl: {$emperor.Level+$emperor.TransformWorkTimes*100})</span></p>
                <p style="font-style: italic; margin-top: -10px;">{$emperor.FavorName}</p>
                
                <p>
                    <a href="#" title="{$emperor.EmperorName}" class="user-avatar"><img src="{#IMG_ICON#}{$emperor.Gender}/n_hero_{$emperor.Icon}.png" title="{$emperor.EmperorName}" alt="{$emperor.EmperorName}" /></a>
                    Quan Chức:<br/><strong>{$emperor.OfficialPos}</strong><br/>
                    Thanh Danh:<br/><strong>{$emperor.Reputation}</strong><br/>
                    Bang Hội:<br/><strong>{$emperor.League}</strong>
                </p>
                

                <!--<p class="left"> </p>-->
                <div class="clear"></div>
                <p>
                    
                </p>
                <ul class="action-links">
                    <!--<li><a href="#" title="Edit Qwibble's profile">Messages (3)</a></li>-->
                    <li><a href="index.php" title="Sửa thông tin cá nhân">Sửa Thông Tin Cá Nhân</a></li>
                    <li><a href="index.php?logoff" title="Đăng xuất">Đăng Xuất</a></li>

                </ul>
            </div>
        </div>
        
        {block name="hook_sidebar"}{/block}
        
        {if $hook_sidebar}
            {foreach from=$hook_sidebar item="group"}
                 <div class="box open">
                    <div class="box-title"><div>{$group.title}<a href="#" class="box-toggle"></a></div></div>
                    <ul class="box-content">
                        {foreach from=$group.body item="link"}
                            {assign var="urltype" value=$link.type }
                            <li {if $smarty.get.$urltype == $link.name} class="active"{/if}><a href="?{$urltype}={$link.name}" class="">{$link.title}</a></li>
                        {/foreach}
                    </ul>
                </div>
            {/foreach}
        {/if}
        
        <!--
        <div class="box open">
            <div class="box-title"><div>
                Admin Features
                <a href="#" class="box-toggle"></a>
            </div></div>
            <ul class="box-content">

                <li><a href="#" title="Demo Pages">Demo Pages</a></li>
                <li class="active"><a href="#" title="Form Layout">Form Layout</a></li>
                <li><a href="#" title="Layout Styles">Layout Styles</a></li>
                <li><a href="#" title="Tabular Data">Tabular Data</a></li>
                <li><a href="#" title="Calendar">Calendar</a></li>
                <li><a href="#modal" title="Statistics" class="modal">Modal</a></li>

            </ul>
        </div>
        <div class="box open calendar">
            <div class="box-title"><div>
                Calendar
                <a href="#" class="box-toggle"></a>
            </div></div>
            <div class="box-content">
                <div class="top">

                    <a href="#" title="Previous Month" class="left">Prev</a>
                    <span class="current-month">April 2010</span>
                    <a href="#" title="Next Month" class="right">Next</a>
                </div>
                <div class="clear"></div>
                <table>
                    <tr>

                        <th>M</th>
                        <th>T</th>
                        <th>W</th>
                        <th>T</th>
                        <th>F</th>
                        <th>S</th>

                        <th>S</th>
                    </tr>
                    <tr>
                        <td class="another-month">28</td>
                        <td class="another-month">29</td>
                        <td class="another-month">30</td>
                        <td>01</td>

                        <td>02</td>
                        <td>03</td>
                        <td>04</td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>06</td>

                        <td class="current">07</td>
                        <td>08</td>
                        <td>09</td>
                        <td>10</td>
                        <td>11</td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>

                        <td>17</td>
                        <td>18</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td>20</td>
                        <td>21</td>

                        <td>22</td>
                        <td>23</td>
                        <td>24</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <td>26</td>

                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td>30</td>
                        <td>31</td>
                        <td class="another-month">01</td>

                    </tr>
                </table>
            </div>
        </div>-->
    </div>