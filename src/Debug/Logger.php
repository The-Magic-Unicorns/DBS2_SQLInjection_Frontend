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
        fwrite($this->fiha, $message . "\n");
        return $this;
    }
}