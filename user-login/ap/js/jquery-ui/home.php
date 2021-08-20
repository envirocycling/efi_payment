
<?php
date_default_timezone_set('America/Los_Angeles');
include('templates/template.php');

?>

<div class="grid_10">
    <div class="box round first">
        <h2> <?php if($_SESSION['usertype']!='Super User') {
                echo $_SESSION['user_branch']." ";
            } ?>Overall WP Grade Receiving For The Month of <?php echo date('F');?></h2>
        <div id="bar-chart">
            <?php
            if($_SESSION['usertype']=='Super User') {
                echo '<iframe src="dist/graphs/overall_wp_grade.php" height="360" width="100%"></iframe>';
            }else {
                echo '<iframe src="dist/graphs/restricted_overall_wp_grade.php" height="360" width="100%"></iframe>';

            }
            ?>
        </div>
    </div>
</div>

<div class="grid_10">
    <div class="box round">
        <?php
        if($_SESSION['usertype']!='Super User') {

            echo '<h2>'. $_SESSION['user_branch'].' monthly performance for the year  '.date("Y").'</h2>';
        }else {
            echo '<h2>Branches performance for the month of '.date("F").'</h2>';
        }
        ?>


        <div class="block">
            <div id="points-chart">
                <?php
                if($_SESSION['usertype']=='Super User') {
                    echo '<iframe src="dist/graphs/branch_performance.php" height="360" width="100%"></iframe>';
                }else {
                    echo '<iframe src="dist/graphs/restricted_branch_performance.php" height="360" width="100%"></iframe>';

                }
                ?>
            </div>
        </div>
    </div>
</div>



<div class="grid_5">
    <div class="box round">
        <h2> <?php if($_SESSION['usertype']!='Super User') {
                echo $_SESSION['user_branch']." ";
            } ?>WP Receiving Percentage For The Month of <?php echo date('F');?></h2>
        <div id="donuts-chart">
            <iframe src="dist/graphs/pie_grades_receiving.php" height="320" width="100%"></iframe>
        </div>
    </div>
</div>


<div class="grid_5">
    <div class="box round">
        <?php
        if($_SESSION['usertype']!='Super User') {

            echo '<h2>'. $_SESSION['user_branch'].' monthly performance percentage for the year  '.date("Y").'</h2>';
        }else {
            echo '<h2>Branch Receiving Percentage For The Month of  '.date("F").'</h2>';
        }
        ?>

        <div id="bubble-chart">
            <iframe src="dist/graphs/pie_branch_receiving.php" height="320" width="100%"></iframe>
        </div>
    </div>
</div>
<div class="clear">
</div>

<div class="clear">
</div>
