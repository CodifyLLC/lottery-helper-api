<?php
set_time_limit(2000);

//------------------------------------------------------------------
// Auto Subscription Cron
//------------------------------------------------------------------

// include the scripts config
require dirname(__FILE__) . '/../env.php';
require dirname(__FILE__) . '/../shared-config.php';

print "Running syncDatabase in '" . ENV_MODE . "' mode\n";

//--------------------------------------------------------
// Make sure all the sql-updates are just the file name
//--------------------------------------------------------
$updatePath = dirname(__FILE__) . '/../sql';

//---------------------------------------------------------
// Get the files we already updated
//---------------------------------------------------------
$sql = "SELECT * FROM sql_updates";
$results = qdb_list('',$sql);
$filesUpdatedArray = array();


foreach($results as $result) {
    array_push($filesUpdatedArray, $result['file_location']);
}

//---------------------------------------------------------
// Get all the sql files in the directory
//---------------------------------------------------------
$filesToCheck = glob($updatePath . "/*.sql");
$sqlQueriesExecuted = 0;
$sqlFilesExecuted = 0;

print "There are " . count($filesToCheck) . " Files to check\n";
foreach ($filesToCheck as $sqlFile) {
    $fileNameParts = explode('/', $sqlFile);
    $fileName = end($fileNameParts);

    if (in_array($fileName, $filesUpdatedArray)) {
        continue;
    }


    print "We need to execute " . $fileName . "...";

    $sql = file_get_contents($sqlFile);
    $sql = remove_remarks($sql);
    $quries = split_sql_file($sql, ';');
    $dataSource = 'main';

    $sqlFilesExecuted++;
    foreach($quries as $query) {
        $sqlQueriesExecuted++;
        qdb_list($dataSource, $query);
    }


    //    Now we need to put this in the table that it's been ran.'
    $sql = 'INSERT INTO sql_updates (file_location, username) VALUES (?, "checkout.sh")';
    $params = array('s', $fileName);
    qdb_exec('', $sql, $params);

    print "Done!";
    print "\n\n";
}

print "Script Complete!\n\n";