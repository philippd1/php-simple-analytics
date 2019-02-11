<?php include 'php-analytics--authentication.php'; ?>
<!doctype html>
<html lang="de">

<head>
    <title>title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://bootswatch.com/4/materia/bootstrap.min.css">
</head>

<body>
    <?php
    include 'php-analytics--include.php';
    $db = $tracker->connectDB();
    $logEntries = $db->query()->orderBy('timestamp', 'ASC')->results();
    $lowestEntry = $db->query()->orderBy('timestamp', 'DESC')->limit(1)->first();
    $totalHits = $db->query()->count();
    $lowestTimestamp = $lowestEntry["timestamp"];

    $lowestTimestamp_weekday = date('N', $lowestTimestamp);
    $lowestTimestamp_month = date('m', $lowestTimestamp);
    $lowestTimestamp_day = date('d', $lowestTimestamp);
    ?>
    <h2 class="text-center">Simple PHP-Analytics</h2>
    <h4 class="text-center">tracking since: <?php echo $lowestTimestamp_day ?></h4>
    <h4 class="text-center">total hits: <?php echo $totalHits; ?></h4>




    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        All stats
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <h3>All stats</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    foreach($logEntries as $logEntry){
        $countOfPage = $db->query()->where("trackPage","=",$logEntry["trackPage"])->count();
        ?>
                            <tr>
                                <td><?php echo $logEntry["trackPage"]; ?> <span
                                        class="badge badge-dark"><?php echo $countOfPage; ?></span></td>
                                <td><?php echo $logEntry["timestamp"]; ?></td>
                            </tr>
                            <?php
    }
    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        compressed view
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <h3>compressed view</h3>
                    <table class="table">
                        <thead><tr><th>Page</th></tr></thead>
                        <tbody>
                            <?php
$alreadyMentioned = array();
    foreach($logEntries as $logEntry){
        if(!in_array($logEntry["trackPage"], $alreadyMentioned)){
            array_push($alreadyMentioned, $logEntry["trackPage"]);

            $countOfPage = $db->query()->where("trackPage","=",$logEntry["trackPage"])->count();
            ?>
                            <tr>
                                <td><?php echo $logEntry["trackPage"]; ?> <span
                                        class="badge badge-dark"><?php echo $countOfPage; ?></span></td>
                            </tr>
                            <?php
    }
    }
    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script>
    $('.collapse').collapse();
    </script>
</body>

</html>