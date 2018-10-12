<?php
/* 
Create class
takes in url and array of parameters needed 
outputs obj quickly and with little memory usage
set clickcast 
set limits 

*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

class Download {
    private $url;
    private $node_arr = array();
    private $setLimit = 50000000;
    private $node = "job";
    public $job_arr = array();

    public function __construct($url, $node_arr){
        $this->url = $url;
        $this->node_arr = $node_arr;
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

//added from better download php
    public function parse() 
    {
        if(empty($this->url))
        {
            throw new Exception("URL is empty");
            // die("Please specify xml file to parse.\n");
        }
    
        // $countIx = 0;
    
        $xml = new XMLReader();

        if(preg_match("/(.gz)$/",$this->url)) 
        {
            $this->setLimit = 10000000;
            $xml->open('compress.zlib://'.$this->url);
        } 
        else 
        {
            $xml->open($this->url);
        }

        if($this->retrieve_remote_file_size($this->url) < $this->setLimit){

            // $job_arr = array();

            while($xml->read() && $xml->name != $this->node) { ; } //skips over nodes we don't need
    
            while($xml->name == $this->node)
            {
                $element = new SimpleXMLElement($xml->readOuterXML());
                //can use variables for this too 
                // $title = 'title';
                $job = array();
                foreach($this->node_arr as $n) {
                    $job[$n] = strval($element->$n);
                }
                array_push($this->job_arr,$job);
                $xml->next($this->node);
                unset($element);
            }
            // print "Number of items=$countIx\n";
            // print "memory_get_usage() =" . memory_get_usage()/1024 . "kb\n";
            // print "memory_get_usage(true) =" . memory_get_usage(true)/1024 . "kb\n";
            // print "memory_get_peak_usage() =" . memory_get_peak_usage()/1024 . "kb\n";
            // print "memory_get_peak_usage(true) =" . memory_get_peak_usage(true)/1024 . "kb\n";
            $xml->close();
            // return json_encode($job_arr);
        }else {
            throw new Exception("Feed is too large - get with someone who knows grep");
            // die("feed too large - please get with someone who knows grep");
        }
    }  
}




// LOGIC
//DONT NEED CLICKCAST INFO ANYMORE
// TODO: Should throw this in a function and add a try catch error handeling in process for this

    if (empty($_GET["url"])) {
        throw new Exception("You must enter a URL");
        die("must enter url");
        $url = "";
    } else {
        $website = $_GET["url"];
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
            echo "Invalid URL"; 
        } else {
            $u = $website;
        }
    } 
    
    
    
    if (empty($_GET["values"])) {
        $values = "";
    } 
    else 
    {
        $valcheck = preg_replace('/\s+/', '', $_GET["values"]);
        // check if VAL address syntax is valid (this regular expression also allows dashes in the URL)
        if (preg_match("/^[a-zA-Z0-9,_-]+$/i",$valcheck)) 
        {
            $v = json_encode((string)$_GET['values']);
            $val = explode(",",$valcheck);
        }
        else 
        {
            echo "Invalid Characters in Values - Only Letters, numbers, whitespaces, dashes, underscores and commas are allowed"; 
        }
    } 
    
    // $u = "ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/1051_JC.xml";
    // url:"ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/994_JC_PPA.xml",
    $x = new Download($u,$val);
    try {
        $x->parse();
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
    echo json_encode($x->job_arr);




 /* 
start_time=`date +%s`
php download.php
end_time=`date +%s`
echo execution time was `expr $end_time - $start_time` s. 
*/