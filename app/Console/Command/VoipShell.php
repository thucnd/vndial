<?php

/**
 * VoipShell.php
 *
 * Get all calls request and start outbound
 *
 * $Id: VoipShell.php 2013/05/29 thucnd$
 * 
 */
App::uses('Shell', 'Console');
App::uses('ComponentCollection', 'Controller');
App::uses('CallRequestComponent', 'Controller/Component');
App::uses('PlivoLogicComponent', 'Controller/Component');

declare(ticks = 1);

class VoipShell extends AppShell {

    private $_callRequestLogic = null;
    private $_plivoLogic = null;

    const LOG_FILE = 'debug_voip';

    // Multi thread
    public $maxProcesses = 25;
    protected $jobsStarted = 0;
    protected $currentJobs = array();
    protected $signalQueue = array();
    protected $parentPID;

    function startup() {
        if (!function_exists('pcntl_fork'))
            die('PCNTL functions not available on this PHP installation');

        $this->parentPID = getmypid();

        pcntl_signal(SIGCHLD, array($this, "childSignalHandler"));

        $collection = new ComponentCollection();
        $this->_callRequestLogic = new CallRequestComponent();

        $this->_plivoLogic = new PlivoLogicComponent();
    }

    /**
     *  Main program
     */
    public function main() {
        $this->log('Start update calls into queue !!!', self::LOG_FILE);
        $this->log('Get campaign list', self::LOG_FILE);
        $campaigns = $this->_callRequestLogic->getCampaignList();
        $this->log('campaign: ' . json_encode($campaigns), self::LOG_FILE);
        
        foreach ($campaigns as $campaign) {
            $params = array();
            $params = $campaign;

            $CallRequests = $this->_callRequestLogic->getCallRequestList($params);
            $this->log('Call request: ' . json_encode($CallRequests), self::LOG_FILE);
            
            if (count($CallRequests) > 0) {
                for ($i = 0; $i < count($CallRequests); $i++) {
                    $params['call_request_id'] = $CallRequests[$i]['call_request_id'];
                    $params['caller'] = $CallRequests[$i]['caller'];
                    $params['called'] = $CallRequests[$i]['called'];
                    $params['user_id'] = $CallRequests[$i]['user_id'];
                    $params['retries'] = $CallRequests[$i]['retries'];
                    $launched = $this->launchJob($params);
                }
            }
        }

        $this->log('End process !!!', self::LOG_FILE);
    }

    /**
     * Launch a job from the job queue
     */
    protected function launchJob($params) {
        $pid = pcntl_fork();
        
        if ($pid == -1) {
            //Problem launching the job
            error_log('Could not launch new job, exiting');
            return false;
        } else if ($pid) {
            // Parent process
            // Sometimes you can receive a signal to the childSignalHandler function before this code executes if
            // the child script executes quickly enough!

            $this->currentJobs[$pid] = getmypid();

            // In the event that a signal for this pid was caught before we get here, it will be in our signalQueue array
            // So let's go ahead and process it now as if we'd just received the signal
            if (isset($this->signalQueue[$pid])) {
                echo "found $pid in the signal queue, processing it now \n";
                $this->childSignalHandler(SIGCHLD, $pid, $this->signalQueue[$pid]);
                unset($this->signalQueue[$pid]);
            }
        } else {
            //Forked child, do your deeds....
            $exitStatus = 0; //Error code if you need to or whatever
            //echo "Doing something fun in pid " . getmypid() . "\n";
            $this->_plivoLogic->makeCall($params);
            exit($exitStatus);
        }
        return true;
    }

    /**
     * childSignalHandler
     * 
     * 
     * @param type $signo
     * @param type $pid
     * @param type $status
     * @return boolean 
     */
    public function childSignalHandler($signo, $pid = null, $status = null) {
        //If no pid is provided, that means we're getting the signal from the system.  Let's figure out
        //which child process ended
        if (!$pid) {
            $pid = pcntl_waitpid(-1, $status, WNOHANG);
        }

        //Make sure we get all of the exited children
        while ($pid > 0) {
            if ($pid && isset($this->currentJobs[$pid])) {
                $exitCode = pcntl_wexitstatus($status);
                if ($exitCode != 0) {
                    echo "$pid exited with status " . $exitCode . "\n";
                }
                unset($this->currentJobs[$pid]);
            } else if ($pid) {
                //Oh no, our job has finished before this parent process could even note that it had been launched!
                //Let's make note of it and handle it when the parent process is ready for it
                echo "..... Adding $pid to the signal queue ..... \n";
                $this->signalQueue[$pid] = $status;
            }
            $pid = pcntl_waitpid(-1, $status, WNOHANG);
        }
        return true;
    }
}
