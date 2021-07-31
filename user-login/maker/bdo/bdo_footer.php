        <?php include './../../../configPhp.php'; ?>
        <!-- Sidenav Menu -->
        <style>
            .sidenav-menu {
                display: block;
                list-style: none;
                list-style-type: none;
            }

            .sidenav-menu-item {
                width: 100%;
                box-sizing: border-box;
                margin: 10px 0px;
            }

            .sidenav-menu-item a {
                color: #fff;
                display: block;
                text-align: center;
                padding: 15px 0px;
            }

            .active {
                background: #4F86C6;
            }

            .sidenav-menu-item a:hover {
                background: #4F86C6;
            }
        </style>
        <aside id="sidebar">
            <strong class="logo"><a href="#">lg</a></strong>

            <ul class="sidenav-menu">
                <li class="sidenav-menu-item">
                    <a href="<?= $base_url; ?>/index_new.php?branch=Pampanga">SBC</a>
                </li>

                <li class="sidenav-menu-item active">
                    <a href="<?= $base_url; ?>/bdo/bdo_index.php?branch=Pampanga" >BDO </a>
                </li>

                <!-- <li class="sidenav-menu-item">
                    <a href="settings.php" class="ico8">Settings</a>
                </li> -->
            </ul>
        </aside>
        <!-- End Sidenav Menu -->

    </div>
</body>