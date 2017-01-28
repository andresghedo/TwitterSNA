<?php

/* GET ALL LINKS BETWEEN MOST 400 RETWEETED NODES */

$in = fopen("data//nodesRT.csv", 'r');
$limit = 400;
$arrayToSearch = [];

while (!feof($in)) {
    $data = fgetcsv($in);
    $arrayToSearch[] = $data[0];
    $limit--;
    if($limit <= 0) break;
}

fclose($in);

$in = fopen('data//net.txt', "r") or die("Couldn't get handle");
$out = fopen('data//links.csv', "w") or die("Couldn't get handle");
$nLinks = 0;

if ($in) {
    while (!feof($in)) {
        $buffer = str_replace("\n", "", fgets($in, 4096));
        $nodes = explode(" ", $buffer);

        if(count($nodes) >= 2){
            if(in_array($nodes[0], $arrayToSearch) && in_array($nodes[1], $arrayToSearch)) {
                fputcsv($out, array($nodes[0], $nodes[1]));
                $nLinks ++;
            }
        }
    }
    fclose($in);
    fclose($out);
}

echo "LINK FOUND: " . $nLinks;
