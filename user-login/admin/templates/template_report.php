<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>EFI Payment System</title>
    <link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
    <script type="text/javascript" src="js/jquery.main.js"></script>
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
    <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="js/setup.js" type="text/javascript"></script>
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('a[rel*=facebox]').facebox({
                loadingImage: 'src/loading.gif',
                closeImage: 'src/closelabel.png'
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();
            $('.datatable').dataTable({
                aLengthMenu: [
                    [10, 20, 40, 100, 1000, 2000, 10000, -1],
                    [10, 20, 40, 100, 1000, 2000, 10000, "All"]
                ],
                iDisplayLength: -1
            });
            setSidebarHeight();
        });
    </script>


    <style>
        h6{
            color:white;
        }
        .tabs{
            margin-left: 20px;
            margin-top: 20px;
        }
        #type{
            background-color: gray;
            font-weight:bold;
            color:white;
        }
    </style>


</head>
<body>
