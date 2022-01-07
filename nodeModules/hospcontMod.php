<?php
    include('config/db_conn.php');

    // SQL

    $getdt = 'SELECT hosname, imgpath FROM hospitals ORDER BY hosname ASC';

    $result = mysqli_query($conn, $getdt);

    $hosps = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free reults from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

?>



<div class="hdcontent">


    <?php foreach($hosps as $hosp){ ?>

        <div class="hd">

            <div class="logcon">
                <img src="<?php echo htmlspecialchars($hosp["imgpath"]);?>" class="hdp">
            </div>

            <div class="hnamecon">
                <h4 class="hname">
                    <a href="#" class="hlin">
                        <?php echo htmlspecialchars($hosp['hosname']);?>
                    </a>
                </h4>
            </div>

        </div>
    
    <?php }?>

</div>