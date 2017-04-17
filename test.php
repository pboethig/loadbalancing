<?php

/**
 * Class UrlStressTest
 */
class UrlStressTest
{
    /**
     * @var int
     */
    private $totalScriptTime=0;

    /**
     * @var int
     */
    private $totalLoopTime=0;

    /**
     * @var int
     */
    private $totalRequests=0;

    /**
     * @var int
     */
    private $startScriptTime=0;

    /**
     * @var array
     */
    private $response=[];

    /**
     * @var int
     */
    private $repeats=0;

    /**
     * @var array
     */
    private $argv = [];

    /**
     * UrlStressTest constructor.
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;

        $this->init();
    }

    /**
     * Validates cms input
     */
    private function init()
    {
        echo PHP_EOL . '########################Test Requests##############################' . PHP_EOL;

        $this->validateCommand();

        if(!isset($this->argv[3])) $this->argv[3] = 1;

        $this->repeats=$this->argv[1];
    }

    /**
     * Validates command
     */
    private function validateCommand()
    {
        if(!isset($this->argv[1])) die("no count of requests set: type: php test.php 1000 http://url.de/ 10" . PHP_EOL);

        if(!isset($this->argv[2])) die("no url set: type: php test.php 1000 http://url.de/ 10" . PHP_EOL);

        if (filter_var($this->argv[2], FILTER_VALIDATE_URL) === FALSE) die("no valid url set: type: php test.php 1000 http://url.de/ 10" . PHP_EOL);
    }

    /**
     * Runs test
     */
    public function run()
    {
        for($a = 1; $a < $this->argv[3]+1 ; $a++)
        {
            $this->startScriptTime= microtime(TRUE);

            echo PHP_EOL . '++++++++++++++++++++++++ Test: ' . $a .' +++++++++++++++++++++++++++';
            echo PHP_EOL . 'Running: ' . $this->repeats  . ' requests. Please wait';

            for( $i = 1 ; $i < $this->repeats + 1 ; $i++)
            {
                $this->totalRequests++;

                $this->response[] = $this->request();
            }

            $this->printInvolvedHosts();

            $endScriptTime = microtime(TRUE);

            $this->totalScriptTime = $endScriptTime-$this->startScriptTime;

            $this->totalLoopTime += $this->totalScriptTime;

            $this->printSingleTestResults();
        }

        $this->summary();
    }


    private function summary()
    {
        echo PHP_EOL . '########################## Summary  ###################################';

        $this->printInvolvedHosts();

        $this->printAverages();
    }

    /**
     * @param $this->argv
     * @return array
     */
    private function request()
    {
        try
        {
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );

            $response = @file_get_contents($this->argv[2],false, stream_context_create($arrContextOptions));

            if(!$response) throw new InvalidArgumentException('given url is not reachable', 404);

        } catch (Exception  $e)
        {
            die('Code: '. $e->getCode(). ' Message: ' . $e->getMessage() . PHP_EOL);
        }

        return $response;
    }

    /**
     * prints out testresult
     */
    private function printSingleTestResults()
    {
        echo PHP_EOL . 'Load time: '.round($this->totalScriptTime,3).' seconds';

        echo PHP_EOL . 'Requests : '.count($this->response);

        echo PHP_EOL . 'Requests per second:' . round($this->argv[1] / $this->totalScriptTime , 3)  . PHP_EOL;
    }

    /**
     * @param $this->totalRequests
     * @param $this->totalLoopTime
     */
    private function printAverages()
    {
        echo PHP_EOL;

        echo PHP_EOL . '########################## Average ###################################';

        echo PHP_EOL . 'Total requests per second:' . round($this->totalRequests / $this->totalLoopTime,2);

        echo PHP_EOL . 'Total requests:' . $this->totalRequests;

        echo PHP_EOL . 'Total time:' . round($this->totalLoopTime,2) ;

        echo PHP_EOL . '########################## End ########################################' . PHP_EOL;
    }

    /**
     *
     */
    private function printInvolvedHosts()
    {
        if(!strstr($this->response[0], 'hostname')) return;

        echo PHP_EOL . PHP_EOL . '------------------ Involved hosts ------------------------';

        foreach (array_unique($this->response) as $item)
        {
            echo PHP_EOL . $item;
        }
    }
}

$test = new UrlStressTest($argv);

$test->run();
