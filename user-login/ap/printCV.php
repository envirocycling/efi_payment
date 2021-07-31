<?php session_start();?>


<style>
    input{
        border-style:hidden;
        text-align:center;
        border-bottom: solid;
        border-width:1.5px;
    }
    #header td{
    }
    #breakdown th{
        padding-left:20px;

        border-width:1px;
        text-align:center;

    }
    #breakdown td{
        padding-left:20px;


        text-align:center;

    }
    #deductions{
        color:red;

    }
    #gross_total{
        font-size:12px;
    }
    #amount{
        text-align:right;
    }
    #tsfee{
        border-style:hidden;
    }
</style>
<center>

    <img src="logo.png"><br>
    <h5 id="letter_head"><i>ENVIROCYCLING FIBER INC.<br>
            Ninoy Aquino Hi-way, Mabalacat, Pampanga</i></h5><div id='asterisk1'>************************************</div>
    <h3>Payment Order </h3>
    <form action="online_module/online_db_sender.php" method="POST">
        <?php
        include('configPhp.php');
        $irmr=$_GET['irmr'];
        $po_number=$_GET['po_number'];
        $result = mysql_query("SELECT * FROM check_voucher where po_number='$po_number'");
        $row = mysql_fetch_array($result);
        echo "<div id='header'>";
        echo "<table>";

        echo "<tr>";
        echo "<td>IRMR: <input type='text' value='".$row['irmr_no']."' size='20' name='irmr'></td>";

        echo "<td>CV#:<input type='text' value='".$row['cv_no']."' name='cvno' readonly></td>";

        echo "<td>Date: <input type='text' value='".$row['date']."' name='date' size='20' readonly></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Supplier: <input type='text' value='".$row['supplier_name']."' name='sup_name' size=20 readonly></td>";

        echo "<td>Bank: <input type='text' value='".$row['bank']."'   size=20 name='bank' readonly></td>";
        echo "<td>Control#:<input type='text' value='".$row['control_no']."'name='control' readonly></td>";



        echo "</tr>";

        echo "<tr>";
        $acct_no=0;
        $supplier_bank_acct_details=preg_split("/[_]/",$row['supplier_name']);
        include('imsconfig.php');
        
        $supplier_id=$supplier_bank_acct_details[0];
        $result2 = mysql_query("SELECT * FROM supplier_details where supplier_id=".$supplier_id."");
        if($row2 = mysql_fetch_array($result2)) {
            $acct_no=$row2['acct_no'];
        }




        echo "<td>Acct #: <input type='text' value='".$acct_no."' name='acct_no' size=20 readonly></td>";



        echo "</tr>";






        echo "</table>";
        echo "</div>";
        $TSTotal=0;
        $totalWeight=0;
        $totalAmount=0;


        $brkdwn=preg_split("/[|]/",$row['breakdown']);
        array_pop($brkdwn);
        echo "<br>-------------------------------------------------------------------------------------<br>";
        echo "<h4><i>Delivery Breakdown</i></h4>";
        echo "<div id='breakdown'>";
        echo "<table>";
        echo "<th>WP Grade</th>";
        echo "<th>Weight</th>";
        echo "<th></th>";
        echo "<th>Unit Cost</th>";
        echo "<th></th>";
        echo "<th>Amount</th>";

        foreach ($brkdwn as $var) {
            echo "<tr>";
            $brkdwn_lvl2=preg_split("/[+]/",$var);
            $PaperType=$brkdwn_lvl2[0];
            $NetWeight=$brkdwn_lvl2[1];
            $TSFee=$brkdwn_lvl2[4];
            $Amount=$brkdwn_lvl2[3];
            $Cost=$brkdwn_lvl2[2];

            echo "<td>".$PaperType."</td>";
            echo "<td>".number_format($NetWeight,2)."</td>";
            echo "<td>..................................................</td>";
            echo  "<td>".$Cost."</td>";
            echo "<td>.........</td>";
            echo "<td id='amount'>".number_format($Amount,2)."</td>";

            $TSTotal+=$TSFee;
            $totalWeight+=$NetWeight;
            $totalAmount+=$Amount;
            echo "</tr>";
        }


        echo "</table>";
        echo "<br>*************************************************************</br>";
        echo "<b>Subtotal:&nbsp;&nbsp;&nbsp;&nbsp;".number_format($totalAmount,2)."</b><br>";
        echo "------------------------------------------<br>";

        $adj_desc=$row['adjustment_desc'];
        $adj_type=$row['adjustment_type'];
        $adj_amount=$row['adjustment_amt'];

        $adj_desc2=$row['adjustment_desc2'];
        $adj_type2=$row['adjustment_type2'];
        $adj_amount2=$row['adjustment_amt2'];



        $adj_desc3=$row['adjustment_desc3'];
        $adj_type3=$row['adjustment_type3'];
        $adj_amount3=$row['adjustment_amt3'];
        if($adj_desc!='' || $adj_desc2!='' || $adj_desc3!='' ||$adj_amount!='' ||  $adj_amount2!='' ||$adj_amount3!='' || $TSTotal>0 ) {

            echo "<i><b>Adjustments</b></i><br>";
            if($adj_desc!='') {
                echo  "<i>".$adj_desc.":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
                if(trim($adj_type)=='ADD' || trim($adj_type)=='add' || trim($adj_type)=='Add') {
                    echo "".number_format($adj_amount,2);
                    echo "</i><br>";
                }else if(trim($adj_type)=='DEDUCT' || trim($adj_type)=='Deduct' || trim($adj_type)=='deduct') {
                    echo "(".number_format($adj_amount,2).")";
                    echo "</i><br>";
                }
            }

            if($adj_desc2!='') {
                echo  "<i>".$adj_desc2.":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
                if(trim($adj_type2)=='ADD' || trim($adj_type2)=='add' || trim($adj_type2)=='Add') {
                    echo "".number_format($adj_amount2,2);
                    echo "</i><br>";
                }else if(trim($adj_type2)=='DEDUCT' || trim($adj_type2)=='Deduct' || trim($adj_type2)=='deduct') {
                    echo "(".number_format($adj_amount2,2).")";
                    echo "</i><br>";
                }
            }
            if($adj_desc3!='') {
                echo  "<i>".$adj_desc3.":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
                if(trim($adj_type3)=='ADD' || trim($adj_type3)=='add' || trim($adj_type3)=='Add') {
                    echo "".number_format($adj_amount3,2);
                    echo "</i><br>";
                }else if(trim($adj_type3)=='DEDUCT' || trim($adj_type3)=='Deduct' || trim($adj_type3)=='deduct') {
                    echo "(".number_format($adj_amount3,2).")";
                    echo "</i><br>";
                }
            }


            //   echo "<input type='text' value='".number_format($totalWeight,2)."' name='totalWeight' readonly>";
            $TSTotal=$row['final_ts'];
            if($TSTotal!='') {

                echo "TSFEE: <b><i><input type='text' value='".$TSTotal."' name='tsFinal' size=5 id='tsfee' readonly></i>";
            }



        }
        ?>

    </form>
    <br>
    <?php
    echo "<br>-------------------------------</br>";
    echo "<br><b>Grandtotal:&nbsp;&nbsp;&nbsp;&nbsp;<u>".$row['final_amount']."</u></b><br>";
    echo "</div>";
    echo "<hr>";
    echo "Ap:<input type='text' value='".$row['ap']."' size=50 name='apName' readonly><br>";

    if($row['bh_signature']!='') {
        echo "<img src='signatures/".$row['bh_signature']."' width=80 height=70 id='bh_signature'><br>";

    }
    echo "Signatory:<input type='text' value='".$row['bh']."' size=50 name='signatory' readonly>";

    ?>
    <br>
    <?php


    if($row['bh_signature']=='LLRTentative.jpg' && $row['bh']==$_SESSION['username']) {

        echo "<a href='llr_approve_po.php?po_number=$po_number'><button>Approve</button></a>";
    }
    if($row['reference_number']=='' && $_SESSION['username']=='pro') {
        echo "<a href='input_trans_details.php?po_number=$po_number'><button>Process Payment</button></a>";
    }
    if ($row['reference_number']!='' ) {
        $reference_number=$row['reference_number'];
        echo "<a href='view_payment_details.php?reference_number=$reference_number'><button>View Payment Details</button></a>";

    }

    ?>
