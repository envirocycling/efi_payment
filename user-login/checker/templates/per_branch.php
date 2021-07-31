			        <nav class="links">
                        <ul>
                            <li>
                                <a href="index_new.php?branch=Pampanga" class="">Pampanga<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Pampanga%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
                            <li>
                                <a href="index_new.php?branch=Sauyo" class="">Sauyo<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Sauyo%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
                            <li>
                                <a href="index_new.php?branch=Kaybiga" class="">Kaybiga<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Kaybiga%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=Cainta" class="">Cainta<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Cainta%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=Calamba" class="">Calamba<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Calamba%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=Mangaldan" class="">Mangaldan<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Mangaldan%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=Cavite" class="">Cavite<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Cavite%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=pasay" class="">Pasay<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Pasay%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
									<li>
                                <a href="index_new.php?branch=Urdaneta" class="">Urdaneta<span class="num">
                                        <?php
                                        include('configPhp.php');
                                        $query = "SELECT count(payment_id) FROM payment WHERE status='approved' and branch_code like '%Urdaneta%'";
                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo $row['count(payment_id)'];
                                        }
                                        ?>
                                    </span></a></li>
                        </ul>
                    </nav>
                    		<br />
		<br />