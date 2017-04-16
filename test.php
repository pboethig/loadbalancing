<?php

echo PHP_EOL . '########################Test Requests##############################' . PHP_EOL;

$totalScriptTime=0;
$totalLoopTime=0;
$totalRequests=0;
$startScriptTime=0;

if(!isset($argv[1])) die("no count of requests set: type: php test.php 1000 http://url.de/ 10" . PHP_EOL);
if(!isset($argv[2])) die("no url set: type: php test.php 1000 http://url.de/ 10" . PHP_EOL);
if(!isset($argv[3])) $argv[3] = 1;

$repeats=$argv[1];

for($a=1;$a<$argv[3]+1;$a++)
{
    $startScriptTime= microtime(TRUE);

    echo PHP_EOL . '------------------------Test:'.$a.'-------------------------' . PHP_EOL;

    for($i=1;$i<$repeats+1;$i++)
    {
        $totalRequests++;

        $response[] = file_get_contents($argv[2]);
    }

    $endScriptTime = microtime(TRUE);

    $totalScriptTime = $endScriptTime-$startScriptTime;

    $totalLoopTime += $totalScriptTime;

    echo "\n\r".'<!-- Load time: '.$totalScriptTime.' seconds -->'. PHP_EOL;

    echo PHP_EOL . 'requests per second:' . $argv[1] / $totalScriptTime  . PHP_EOL;
}

echo PHP_EOL . '########################## differernt Responses ###################################';

foreach (array_unique($response) as $item)
{
    echo PHP_EOL . $item;
}

echo PHP_EOL;

echo PHP_EOL . '########################## Average ###################################';

echo PHP_EOL . 'total requests per second:' . round($totalRequests / $totalLoopTime,2);

echo PHP_EOL . 'total requests:' . $totalRequests;

echo PHP_EOL . 'total time:' . round($totalLoopTime,2) ;

echo PHP_EOL . '########################## Average ###################################' . PHP_EOL;
?>
