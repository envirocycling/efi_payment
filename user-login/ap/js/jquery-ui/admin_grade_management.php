<?php
date_default_timezone_set('America/Los_Angeles');
include('templates/template.php');


?>




<div class="grid_10">
       <div class="box round first">
        <h2>Waste Paper Grades </h2>

        <?php
        include("config.php");
        $query="SELECT * FROM wp_grades";
        $result=mysql_query($query);

        ?>
        <table class="data display datatable" id="example">
            <?php
            echo "<thead>";
            echo "<tr class='data'>";
            echo "<th class='data'>Grade Code</th>";
            echo "<th class='data'>Desc</th>";
            echo "<th class='data'>Action</th>";
            echo "</tr>";
            echo "</thead>";


            while($row = mysql_fetch_array($result)) {
                echo "<tr class='data'>";
                echo "<td class='data'>".$row['wp_grade']."</td>";
                echo "<td class='data'>".$row['wp_desc']."</td>";
                echo "<td class='data'><a rel='facebox' href='admin_edit_wpgrade.php?grade_id=".$row['grade_id']."'>Edit</a> &nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp ";
                echo "<a rel='facebox' href='deletegrade_confirmation.php?grade_id=".$row['grade_id']."'>Delete</a></td>";
                echo "</tr>";

            }


            ?>
        </table>
        <a rel="facebox" href="admin_addnew_wpgrade.php"><button>Add New WP Grade</button></a>


    </div>
</div>
