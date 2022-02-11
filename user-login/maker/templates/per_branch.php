<?php include('./../../configPhp.php');

$branches = array();

$qbranches = $con->query("select * from `branches` where `status`=1;");
$rbranches = $qbranches->fetch_all(MYSQLI_ASSOC);

foreach($rbranches as $rbranch) {
    $branches[] = array(
        "name" => $rbranch['branch_name'],
        "code" => $rbranch['bcode'],
        "count" => 0
    );
}


foreach($branches as $key => $branch) {
    $bcode = $branch['code'];
    $query = "SELECT * FROM payment WHERE status='approved' and branch_code like '%{$bcode}%' and bank_code = 'SBC'";
    $result = $con->query($query);
    $count = $result->num_rows;
    $branches[$key]['count'] = $count;
}
?>

<nav class="links">
    <ul>
        <?php foreach($branches as $branch): ?>

        <?php
            $name = $branch['name'];
            $count = $branch['count'];
            $code = $branch['code'];
            $url = "{$base_url}/index_new.php?branch=".$code;
        ?>

        <li class="tab-branch">
            <a href="<?= $url ?>" class=""><?= $name ?><span class="num"><?= $count ?></span></a>
        </li>            
        <?php endforeach;?>
    </ul>
 </nav>