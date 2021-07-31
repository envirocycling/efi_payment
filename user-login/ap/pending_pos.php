
<?php include('templates/template.php'); ?>
<style>
    .select{
        font-size: 14px;
        color: black;
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Payment Orders</h1>
        <b>Filtering Options</b>
        <br>
        <?php
        include("configPhp.php");
        if ($_SESSION['user_type']!='3') {
            echo "<form action='pending_pos.php?123' method='POST'>";
            echo "Branch: <select class='select' name='branch'>";
            if (isset ($_POST['branch'])) {
                if ($_POST['branch']=='') {
                    echo "<option value=''>All Branch</option>";
                } else {
                    echo "<option value='".$_POST['branch']."'>".$_POST['branch']."</option>";
                }
            }
            echo "<option value=''>All Branch</option>";
            $sql = mysql_query("SELECT * FROM branches");
            while ($rs = mysql_fetch_array($sql)) {
                echo "<option value='".$rs['branch_name']."'>".$rs['branch_name']."</option>";
            }
            echo "</select>";
            echo "<input class='submit' type='submit' name='submit' value='Submit'>";
            echo "</form>";
        }
        ?>
        <table class="data display datatable" id="example">
            <article>

                <?php
                @session_start();
                if ($_SESSION['user_type'] == 3) {
                    $query = "SELECT * FROM payment WHERE status='pending' and branch_code like '%" . $_SESSION['branch'] . "%'";
                }
                if ($_SESSION['user_type'] == 2) {
                    if (isset($_POST['branch'])) {
                        if ($_POST['branch'] != '') {
                            $query = "SELECT * FROM payment WHERE status='pending' and branch_code like '%" . $_POST['branch'] . "%'";
                        } else {
                            $query = "SELECT * FROM payment WHERE status='pending'";
                        }
                    } else {
                        $query = "SELECT * FROM payment WHERE status='pending'";
                    }
                }
                if ($_SESSION['user_type'] == 1) {
                    $query = "SELECT * FROM payment WHERE status='' and branch_code like '%" . $_SESSION['branch'] . "%'";
                }
                $result = mysql_query($query);
                echo "<thead>";
                echo "<th></th>";
                echo "<th>po #</th>";
                echo "<th>Branch Code</th>";
                echo "<th>Voucher No.</th>";
                echo "<th>Supplier Name</th>";
                echo "<th>Date</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</thead>";
                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' id='".$row['payment_id']."' value='".$row['payment_id']."' name='".$row['payment_id']."'></td>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['branch_code'] . "</td>";
                    echo "<td>" . $row['voucher_no'] . "</td>";
                    echo "<td>" . $row['supplier_name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    if ($row['status'] == '') {
                        echo "<td>pending</td>";
                    } else {
                        echo "<td>" . $row['status'] . "</td>";
                    }
                    echo "<td><a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View </button></a></td>";
                    echo "</tr>";
                }
                ?>
        </table>
        <button>Generate Batch</button>
        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
