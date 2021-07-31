

</div>
</div>
<aside id="sidebar">
    <strong class="logo"><a href="#">lg</a></strong>
    <ul class="tabset buttons">
        <?php
        $url= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $parseURL=preg_split("[/]",$url);

        ?>
        <?php
        if ($_SESSION['position'] == 'General Manager') {
            if ($parseURL[4]=='ap_accounts.php' || $parseURL[4]=='reliever_accounts.php') {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            ?>
        <a href="reliever_accounts.php"><h6>Accounts</h6><span>[Accounts]</span><em></em></a>
        <span class="tooltip"><span>View Accounts</span></span>
        </li>
            <?php
        }
        ?>
        <li>
            <a href="settings.php" class="ico8"><span>Settings</span><em></em></a>
            <span class="tooltip"><span>Settings</span></span>
        </li>
    </ul>
    <span class="shadow"></span>
</aside>
</div>


