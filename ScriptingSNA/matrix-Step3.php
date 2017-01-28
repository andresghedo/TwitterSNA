<?php

$handle = fopen("data//nodesRT.csv", "r") or die("Couldn't get handle");
$nodes = [];
$limit = 400;

/* GET 400 NODES MOST RETWEETED */
if ($handle) {
    while (!feof($handle)) {
        $buffer = str_replace("\n", "", fgets($handle, 4096));
        $nodes[] = explode(',', $buffer)[0];
        $limit--;
        if($limit <= 0) break;
    }
    fclose($handle);     
}

/* GET ADJACENCIES BETWEEN NODES */
$handleLinks = fopen("data//links.csv", "r") or die("Couldn't get handle");
$links = [];
if ($handleLinks) {
    while (!feof($handleLinks)) {
        $buffer = str_replace("\n", "", fgets($handleLinks, 4096));
        $links[] = $buffer;
    }
    fclose($handleLinks);     
}

$counter1 = 0;
$counter0 = 0;
$handleMatrix = fopen("data//matrix-400.csv", "w") or die("Couldn't get handle");

// FIRST LINE
$toWrite = [];
$toWrite[] = "";
foreach ($nodes as $Xnode) {
    $toWrite[] = $Xnode;
}
fputcsv($handleMatrix, $toWrite, ";");
// END FIRST LINE


/* WRITE MATRIX IN A CSV FILE */
foreach ($nodes as $Xnode) {
    $toWrite = [];
    $toWrite[] = $Xnode;
    foreach ($nodes as $Ynode) {

        $toSearch = $Xnode . "," . $Ynode;
        /* if exist link between Xnode and Ynode put 1 in adj matrix */
        if(in_array($toSearch, $links)){
            $toWrite[] = '1';
            $counter1 ++;
        } else  { /* else put 0 */
            $toWrite[] = '0';
            $counter0++;
        }
    }
    fputcsv($handleMatrix, $toWrite, ";");
}
fclose($handleMatrix);

print_r("STATISTICS: " . PHP_EOL);
print_r("MATRIX LINKS: " . $counter1 . PHP_EOL);
print_r("MATRIX NO LINKS: " . $counter0);
