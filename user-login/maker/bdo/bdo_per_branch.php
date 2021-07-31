<?php include('./../../../configPhp.php');

$activeBranch = $_GET['branch'];

$branches = [
    ["name" => "Pampanga", 'count' => 0],
    ["name" => "Sauyo", 'count' => 0],
    ["name" => "Kaybiga", 'count' => 0],
    ["name" => "Cainta", 'count' => 0],
    ["name" => "Calamba", 'count' => 0],
    ["name" => "Mangaldan", 'count' => 0],
    ["name" => "Cavite", 'count' => 0],
    ["name" => "Silang", 'count' => 0],
    ["name" => "Pasay", 'count' => 0],
    ["name" => "San Pedro", 'count' => 0],
    ["name" => "San Fernando", 'count' => 0]
];

foreach($branches as $key => $branch) {
    $_branch = $branch['name'];
    $query = "SELECT * FROM payment WHERE status='approved' and branch_code like '%{$_branch}%' and bank_code = 'BDO_MAIN'";
    $result = $con->query($query);
    $count = $result->num_rows;
    $branches[$key]['count'] = $count;
}
?>

<nav class="links branch-link">
    <ul>
        <?php foreach($branches as $branch): ?>

        <?php
            $name = $branch['name'];
            $count = $branch['count'];
            $url = "http://localhost/paymentsystem/user-login/maker/bdo/bdo_index.php?branch=".$name;
        ?>

        <li class="tab-branch ">
            <a href="<?= $url ?>" class="<?= ($activeBranch === $name) ? 'tab-branch-active' : '' ?>"><?= $name ?><span class="num  <?= $count ? 'badge-yellow' : '' ?>"><?= $count ?></span></a>
        </li>            
        <?php endforeach;?>
    </ul>
 </nav>