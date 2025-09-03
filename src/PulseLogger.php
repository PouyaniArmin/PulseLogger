<?php

namespace Armin\PulseLogger;

use Exception;

class PulseLogger{
    private static ?PulseLogger $pulseLogger=null;
    private string $format="
    Timestamp: %s
    Level: %s
    Message: %s
    File: %s
    Class: %s
    Line: %s
    Function: %s
    RequestID: %s
    ClientIP: %s\n";
    private function __construct()
    {
        
    }
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton class PulseLogger.");
    }
    private function __clone()
    {
        throw new Exception("Cannot clone singleton class PulseLogger");
    }
    public static function getInstance(){
        if (self::$pulseLogger!==null) {
            return self::$pulseLogger;
        }
        return self::$pulseLogger=new PulseLogger();
    }
    public function log($level,$message){
        $backTrack=debug_backtrace();
        $caller=$backTrack[1] ?? $backTrack[0];
        $file=$caller['file'];
        $class=($caller['class']===__CLASS__) ? null : $caller['class'];
        $line=$caller['line'];
        $function=($caller['function']===__FUNCTION__)? null :$caller['function'];
        $request_id=$_SERVER['HTTP_X_REQUEST_ID'] ?? null;
        $clinentIp=$_SERVER['REMOTE_ADDR'] ?? null;
        $tiem=sprintf($this->format,date('c'),$level,$message,$file,$class,$line,$function,$request_id,$clinentIp);
        file_put_contents('log.txt',$tiem,FILE_APPEND);
    }
}