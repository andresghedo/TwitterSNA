<?php

/* GET NODES IN RETWEET FILE, SORTED BY RETWEET COUNT */

$in = fopen("data//retweet", 'r');
$out = fopen("data//nodesRT.csv", 'w');

$retweeted = [];

while (!feof($in)) {
    $buffer = str_replace("\n", "", fgets($in, 4096));
    $data = explode(" ", $buffer);

    if(count($data) >= 2) {
        $retweeted[] = $data[1];
    }
}

$toSort = array_count_values($retweeted);
arsort($toSort);

foreach ($toSort as $key => $nRetweet) {
    fputcsv($out, array($key, $nRetweet));
}

fclose($out);
fclose($in);