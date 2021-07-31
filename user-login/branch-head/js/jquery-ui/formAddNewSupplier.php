<style>
    h1{
        color:white;

    }
</style>

<?php
include("templates/template.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>EFI INCOMING DELIVERIES MONITORING SYSTEM</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
        <link href="css/table/demo_page.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="js/table/table.js"></script>
        <script src="js/setup.js" type="text/javascript"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                setupLeftMenu();

                $('.datatable').dataTable();
                setSidebarHeight();


            });
        </script>


        <script type="text/javascript">



            function apply(val)
            {

                if (val=='YES') {

                    document.getElementById('acct_name').disabled = false;
                    document.getElementById('acct_no').disabled = false;
                    document.getElementById('bank').disabled = false;
                } else {
                    document.getElementById('acct_name').disabled = true;
                    document.getElementById('acct_no').disabled = true;
                    document.getElementById('bank').disabled = true;

                    document.getElementById('acct_name').value = "";
                    document.getElementById('acct_no').value = "";
                    document.getElementById('bank').value = "";
                }
            }



        </script>


    </head>
    <body>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Add A New Supplier</h2>
                <div class="block ">
                    <form action="addNewSupplierExec.php" method="POST">
                        <table class="form">

                            <tr>
                                <td>
                                    <label>
                                        <h4> Supplier ID:</h4> </label>
                                </td>
                                <td>
                                    <?php

                                    if(!isset ($_SESSION['username'])) {
                                        header("Location:index.php");
                                    }
                                    include('config.php');
                                    $result = mysql_query("SELECT * FROM supplier_details  order by supplier_id desc limit 1");
                                    $row = mysql_fetch_array($result);
                                    $idNumber=$row['supplier_id']+1;
                                    ?>
                                    <input type="text" class="mini" name="supplier_id" style="color:blue; font-size:25px; border-style:hidden; font-weight:bold;" value="<?php echo $idNumber;?>" readonly/>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Supplier Name:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="supplier_name" class="large" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        <h4> Classification:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="classification" class="mini" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Branch:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="branch" class="mini" value="<?php echo $_SESSION['user_branch'];?>" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Branch Head In Charge:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="bh_in_charge" class="mini" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Address:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="street" class="large" value="Street/Barangay" />
                                </td>
                                <td>
                                    <input type="text" name="municipality" class="large" value="Municipality" />
                                </td>
                                <td>
                                    <input type="text" name="city" class="large" value="City" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Owner Name:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="owner" class="large" value="" />
                                </td>



                                <td>
                                    <label>
                                        <h4>  Contact:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="owner_contact" class="large" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Representative Name:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="representative" class="large" value="" />
                                </td>



                                <td>
                                    <label>
                                        <h4>     Contact:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="representative_contact" class="large" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        <h4> Number of Trucks:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="no_of_trucks" class="mini" value="" />
                                </td>

                                <td>
                                    <label>
                                        <h4> Plate Number/s:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="plate_numbers" class="large" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Number of Warehouses:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="no_of_wh" class="mini" value="" />
                                </td>

                                <td>
                                    <label>
                                        <h4> Warehouse Addresses:</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="wh_address" class="large" value="" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>
                                        <h4> Is Payable Online?:</h4> </label>
                                </td>
                                <td>
                                    <select name="payable_online" id="payable_online" onchange="apply(this.value)" >
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>
                                    </select>
                                </td>
                            </tr>


                            <tr><td><i><h5 style="color:red;">To be filled-out only if the answer is yes</h5></i></td></tr>
                            <tr>
                                <td>

                                    <label>
                                        <h4>Bank :</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="bank"  id="bank" class="large" value="" disabled="true"/>

                                </td>





                            </tr>

                            <tr>
                                <td>

                                    <label>
                                        <h4>Acct Name :</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="acct_name" id="acct_name" class="large" value="" disabled="true" />

                                </td>





                            </tr>
                            <tr>
                                <td>

                                    <label>
                                        <h4>Acct No. :</h4> </label>
                                </td>
                                <td>
                                    <input type="text" name="acct_no" id="acct_no" class="large" value="" disabled="true"/>

                                </td>





                            </tr>


                            <tr>
                                <td>

                                </td>
                                <td>
                                    <input type="submit" value="Save New Supplier"/>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>

</body>
</html>
