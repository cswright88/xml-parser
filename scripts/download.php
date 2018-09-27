<?php

class dlXML {
    private $url;

    public function __construct($url){
        $this->url = $url;
    }

    public function getUrl(){
        return $this->url;
    }
    public function retrieve_remote_file_size($file){
        $ch = curl_init($file);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    
        curl_close($ch);
        return $size;
    }

    public function download(){
        set_time_limit(60);
        if (preg_match("/(.gz)$/",$this->url)){
            $this->url = "compress.zlib://" . $this->url;
        }
        if($this->retrieve_remote_file_size($this->url) < 75000000){
            $xml = simplexml_load_file($this->url) or die("feed not loading");
            return $xml;
        }else {
            die("feed too large - please get with someone who knows grep");
        }

    }
}
// $u = "ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/1038_JC.xml";
// $file = new dlXML($u);
// $file->download();


