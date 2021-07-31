
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
        if ($parseURL[2]=='form_expense_summary.php') {
            echo "<li class='active'>";
        }else {
            echo "<li>";
        }
        ?>

        <?php
        if ($parseURL[2]=='form_journal_entries.php') {
            echo "<li class='active'>";
        }else {
            echo "<li>";
        }
        ?>
        <?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
if (strlen(strstr($agent, 'Firefox')) > 0) {
   ?>
   
        <li>
          <center> <a href="autoprint.php"><br />Auto Print</a>
            </center>
            <span class="tooltip"><span>Auto Print</span></span>
        </li>
   <?php
}
?>


        <li class="sidenav_menu">
            <a href="<?= $base_url; ?>/index_new.php?branch=Pampanga">SBC</a>
        </li>

        <li class="sidenav_menu">
            <a href="<?= $base_url; ?>/bdo_index.php?branch=Pampanga" >BDO</a>
        </li>

        <li class="sidenav_menu active">
            <a href="settings.php" class="ico8"><span>Settings</span><em></em></a>
            <span class="tooltip"><span>Settings</span></span>
        </li>

    </ul>
    <span class="shadow"></span>
</aside>
</body>


