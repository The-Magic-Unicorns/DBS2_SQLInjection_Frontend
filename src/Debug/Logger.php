<?php

namespace DBS2\Debug;

class Logger
{
    private $logFile = __DIR__ . '/../../var/log/debug.log';
    private $fiha = null;

    public function __construct()
    {
        $this->fiha = fopen($this->logFile, 'a+');
    }

    public function __destruct()
    {
        fclose($this->fiha);
    }

    /**
     * @param string $message
     * @return $this
     */
    public function log(string $message): self
    {
        $today = new \DAteTime('now');
        $today = $today->format('d.m.Y H:i:s');
        fwrite($this->fiha, $today . '; ' . $message . "\n");
        return $this;
    }
}