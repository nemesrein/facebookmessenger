<?php
class LogViewer extends CI_Controller
{
    private $logViewer;

    public function __construct()
    {
        $this->logViewer = new \CILogViewer\CILogViewer();
        //...
    }

    public function index()
    {
        echo $this->logViewer->showLogs();
        return;
    }
}
