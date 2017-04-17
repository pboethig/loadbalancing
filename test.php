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
$response = [];

for($a=1;$a<$argv[3]+1;$a++)
{
    $startScriptTime= microtime(TRUE);

    echo PHP_EOL . '++++++++++++++++++++++++ Test: ' . $a .' +++++++++++++++++++++++++++' . PHP_EOL;

    for($i=1;$i<$repeats+1;$i++)
    {
        $totalRequests++;

        $response[] = file_get_contents($argv[2]);
    }

    printInvolvedHosts($response);

    $endScriptTime = microtime(TRUE);

    $totalScriptTime = $endScriptTime-$startScriptTime;

    $totalLoopTime += $totalScriptTime;

    printSingleTestResults($totalScriptTime, $argv);
}

printInvolvedHosts($response);

printAverages($totalRequests, $totalLoopTime);

/**
 * @param $totalScriptTime
 * @param $argv
 */
function printSingleTestResults($totalScriptTime, $argv)
{
    echo "\n\r".'Load time: '.round($totalScriptTime,3).' seconds';

    echo PHP_EOL . 'requests per second:' . round($argv[1] / $totalScriptTime,3)  . PHP_EOL;
}

/**
 * @param $totalRequests
 * @param $totalLoopTime
 */
function printAverages($totalRequests, $totalLoopTime)
{
    echo PHP_EOL;

    echo PHP_EOL . '########################## Average ###################################';

    echo PHP_EOL . 'Total requests per second:' . round($totalRequests / $totalLoopTime,2);

    echo PHP_EOL . 'Total requests:' . $totalRequests;

    echo PHP_EOL . 'Total time:' . round($totalLoopTime,2) ;

    echo PHP_EOL . '########################## Average ###################################' . PHP_EOL;
}
/**
 * @param $response
 */
function printInvolvedHosts($response)
{
    echo PHP_EOL . '------------------ Invoved hosts ------------------------';

    foreach (array_unique($response) as $item)
    {
        echo PHP_EOL . $item;
    }
}
