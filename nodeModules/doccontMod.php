<?php

    include('config/db_conn.php');

    // SQL

    $getdt = 'SELECT firstname, lastname, profpth FROM doctors ORDER BY firstname ASC';

    $result = mysqli_query($conn, $getdt);

    $docs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free reults from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

?>



<div class="hdcontent">


    <?php foreach($docs as $doc){ ?>

        <div class="hd">

            <div class="logcon">
                <img src="<?php echo htmlspecialchars($doc['profpth']);?>" class="hdp">
            </div>

            <div class="hnamecon">
                <h4 class="hname">
                    <a href="#" class="hlin">
                        <?php echo htmlspecialchars($doc['firstname']. 
                        ' ' . $doc['lastname']);?>
                    </a>
                </h4>
            </div>

        </div>
    
    <?php }?>

</div>