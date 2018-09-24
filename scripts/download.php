<?php

class dlXML {
    private $url;

    public function __construct($url){
        $this->url = $url;
    }

    public function getUrl(){
        return $this->url;
    }

    public function download(){
        if (preg_match("/(.gz)$/",$this->url)){
            $this->url = "compress.zlib://" . $this->url;
        }
        $xml = simplexml_load_file($this->url) or die("feed not loading");
        return $xml;
    }
}
// $u = "ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/1038_JC.xml";
// $file = new dlXML($u);
// $file->download();


