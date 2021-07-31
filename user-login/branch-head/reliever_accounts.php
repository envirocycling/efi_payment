<?php include('templates/template.php'); ?>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Reliever Accounts</h1>
        <a rel="facebox" href="add_new.php">Add new</a>
        <hr>
        <article>
            <a href="ap_accounts.php">AP</a> | <a href="reliever_accounts.php"><font color="blue">Reliever</font></a>
        </article>
    </div>
    <br>
    <table width="700">
        <tr>
            <td>
                <table class="data display datatable" id="example">
                    <article>

                        <?php
                        @session_start();
                        include("configPhp.php");
                        echo "<thead>";
                        echo "<th>user_id</th>";
                        echo "<th>Username</th>";
                        echo "<th>Name</th>";
                        echo "<th>Initial</th>";
                        echo "<th>Position</th>";
                        echo "<th>Branch</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";

                        echo "</thead>";

                        $sql = mysql_query("SELECT * FROM users WHERE position='Reliever' and usertype='4' and branch='".$_SESSION['branch']."'");
                        while ($rs = mysql_fetch_array($sql)) {
                            echo "<tr>";
                            echo "<td>".$rs['user_id']."</td>";
                            echo "<td>".$rs['username']."</td>";
                            echo "<td>".$rs['firstname']." ".$rs['lastname']."</td>";
                            echo "<td>".$rs['initial']."</td>";
                            echo "<td>".$rs['position']."</td>";
                            echo "<td>".$rs['branch']."</td>";

                            $sql_act = mysql_query("SELECT * FROM reliever_activate WHERE user_id='".$rs['user_id']."' ORDER BY date_to DESC");
                            $rs_count = mysql_num_rows($sql_act);
                            $rs_act = mysql_fetch_array($sql_act);


                            if ($rs_count == 0 || $rs_act['date_to'] < date("Y/m/d")) {
                                echo "<td>Deactivated</td>";
                            } else {
                                echo "<td>Activated until: <b>".date("M d, Y", strtotime($rs_act['date_to']))."</b></td>";
                            }
                            echo "<td><a rel='facebox' href='activate.php?user_id=".$rs['user_id']."'><button>Activate</button></a></td>";
                            echo "</tr>";
                        }
                        ?>
                </table>
            </td>
        </tr>
    </table>



</div>
<?php include ('templates/footer.php'); ?>
