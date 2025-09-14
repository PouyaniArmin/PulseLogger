<?php 


namespace Armin\PulseLogger\Handler;

class FileHandler{
    private string $basePath;
    public function __construct(?string $basePath=null)
    {
        if ($basePath) {
            $this->basePath=rtrim($basePath,'/');
        }
        else{
            $this->basePath=dirname(__DIR__,3).'/logs';
        }
        if (!is_dir($this->basePath)) {
            mkdir($this->basePath,0777,true);
        }
    }
    public function write(string $filename,string $content){
        $filePath=$this->basePath.'/'.$filename;
        file_put_contents($filePath,$content,FILE_APPEND);
    }
}