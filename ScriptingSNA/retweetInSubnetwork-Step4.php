<?php


/* GET COUNT RETWEET FOR NODE IN SUB/EXTRACT 400 NODES NETWORK */

$handle = fopen("data//nodesRT.csv", "r") or die("Couldn't get handle");
$nodes = [];
$retweet = [];
$limit = 400;

/* GET 400 NODES MOST RETWEETED */
if ($handle) {
    while (!feof($handle)) {
        $buffer = str_replace("\n", "", fgets($handle, 4096));
        $nodes[] = explode(',', $buffer)[0];
        $retweet[explode(',', $buffer)[0]] = 0;
        $limit--;
        if($limit <= 0) break;
    }
    fclose($handle);     
}

$in = fopen("data//retweet", 'r');
$out = fopen("data//retweetInSubnetwork.csv", 'w');

while (!feof($in)) {
    $buffer = str_replace("\n", "", fgets($in, 4096));
    $data = explode(" ", $buffer);

    if(count($data) == 3) {
        if(in_array($data[0], $nodes) && in_array($data[1], $nodes))
            $retweet[$data[1]] += $data[2];
    }
}

arsort($retweet);

foreach ($retweet as $key => $nRetweet) {
    fputcsv($out, array($key, $nRetweet));
}

fclose($out);
fclose($in);

print_r("COMPLETED! Check file data//retweetInSubnetwork.csv ");
