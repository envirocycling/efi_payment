<?php
@session_start();
include("./../../configPhp.php");
include('templates/template.php');

if (isset ($_GET['deactivate_id'])) {
    $con->query("UPDATE users SET status='deactivated' WHERE user_id='".$_GET['deactivate_id']."'");
}
if (isset ($_GET['activate_id'])) {
    $con->query("UPDATE users SET status='' WHERE user_id='".$_GET['activate_id']."'");
}

?>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>AP Accounts</h1>
        <a rel="facebox" href="add_new.php">Add new</a>
        <hr>
        <article>
            <a href="ap_accounts.php"><font color="blue">AP</font></a> | <a href="reliever_accounts.php">Reliever</a>
        </article>
    </div>
    <br>
    <table width="700">
        <tr>
            <td>
                <table class="data display datatable" id="example">
                    <article>

                        <?php
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

                        $sql = $con->query("SELECT * FROM users WHERE usertype='5' and branch='".$_SESSION['branch']."'");

                        while ($rs = $sql->fetch_array()) {
                            echo "<tr>";
                            echo "<td>".$rs['user_id']."</td>";
                            echo "<td>".$rs['username']."</td>";
                            echo "<td>".$rs['firstname']." ".$rs['lastname']."</td>";
                            echo "<td>".$rs['initial']."</td>";
                            echo "<td>".$rs['position']."</td>";
                            echo "<td>".$rs['branch']."</td>";
                            if ($rs['status'] == '') {
                                echo "<td>ACTIVE</td>";
                                echo "<td><a href='ap_accounts.php?deactivate_id=".$rs['user_id']."'><button>Deactivate</button></a></td>";
                            } else {
                                echo "<td>".strtoupper($rs['status'])."</td>";
                                echo "<td><a href='ap_accounts.php?activate_id=".$rs['user_id']."'><button>Activate</button></a></td>";
                            }

                            echo "</tr>";
                        }
                        ?>
                </table>
            </td>
        </tr>
    </table>



</div>
<?php include ('templates/footer.php'); ?>
