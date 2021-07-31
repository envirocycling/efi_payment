
</div>
</div>

<?php $base_url = "http://localhost/paymentsystem/user-login/maker"; ?>

<style>
            .sidenav-menu {
                display: block !important;
                list-style: none !important;
                list-style-type: none !important;
            }

            .sidenav-menu-item {
                width: 100% !important;
                box-sizing: border-box !important;
                margin: 10px 0px !important;
            }

            .sidenav-menu-item a {
                color: #fff !important;
                display: block !important;
                text-align: center !important;
                padding: 15px 0px !important;
            }

            .active {
                background: #4F86C6 !important;
            }

            .sidenav-menu-item a:hover {
                background: #4F86C6 !important;
            }
        </style>

<aside id="sidebar">
    <strong class="logo"><a href="#">lg</a></strong>

    <ul class="sidenav-menu"> 
 
        <li class="sidenav-menu-item active">
            <a href="<?= $base_url; ?>/index_new.php?branch=Pampanga">SBC</a>
        </li>

        <li class="sidenav-menu-item">
            <a href="<?= $base_url; ?>/bdo/bdo_index.php?branch=Pampanga" >BDO</a>
        </li>

    </ul>
</aside>
</body>


