<?php
/* 

    CREATED 08/26/2018
    GOAL - PARSE XML CODE
                PARSE A JOB XML FILE AND PASS ARRAY OF VAR YOU'RE LOOKING FOR
    DEV: Chris Wright

Logic
     Parsexml(
          string  $url  [no default], 
          array $node_arr [default ["referencenumber", "title", "city", "state", "url", "description"]], 
     ) 

EXAMPLE: 
//To print the first element run the following:
//Take out the array[0] to see the entire obj

php -a;
$url = "test.xml";
include "./parsexml.php"; print_r((new Parsexml($url))->parse());
exit

*/

include('download.php');

//THIS CREATES AND RETURNS AN OBJECT OF JOBS FOR USE FROM A URL EITHER DOWNLOADED WITH THE ATTACHED DOWNLOAD CLASS OR A DOCUMENT INSIDE THE SAME DIRECTORY
class Parsexml extends dlXML{
    private $node_arr;

    public function __construct($url, $node_arr = array("referencenumber", "title")){
        parent::__construct($url);
        $this->node_arr = $node_arr;
        // $this->limit = $limit;
    }

    public function parse($limit = 10000){
        $xml = self::download();
        $job = $xml->job;
        $obj = array();
                foreach($job as $el){
                    $job_arr = array();
                    foreach($el->children() as $key=>$child){
                            if(in_array($key,$this->node_arr)){
                                $node = (string)$child;
                                $job_arr = array_merge($job_arr,array($key=>$node));
                            }                    
                        }
                    array_push($obj,$job_arr);
                }
        return $obj;
    }
}







/* 
EXAMPLE JOB NODE
<job>
        <title><![CDATA[Nanny - Great Pay and Flexible Hours]]></title>
        <date><![CDATA[Fri, 10 Aug 2018 04:58:34 UTC]]></date>
        <referencenumber><![CDATA[ngreat-winkelman-az-20180810]]></referencenumber>
        <url><![CDATA[https://www.urbansitter.com/signup/sitter?rx_page=jobview&utm_source=jobs2careers&utm_medium=jobpost&rx_source=Jobs2Careers&rx_campaign=Jobs2Careers50&rx_medium=cpc&rx_job=ngreat-winkelman-az-20180810&rx_ad=job&rx_group=20180819]]></url>
        <company><![CDATA[UrbanSitter]]></company>
        <city><![CDATA[Winkelman]]></city>
        <state><![CDATA[AZ]]></state>
        <description><![CDATA[Do you love working with children? Do you want a flexible opportunity that pays well?  Do you have experience as a babysitter, nanny or a caretaker?  If you answered yes to any of those questions, become an UrbanSitter babysitter!  Top sitters earn over $1000 a week babysitting for great local families.  Hours are flexible and you keep 100% of what you make.  Nannies: we have great full and part-time jobs too. ]]></description>
        <postalcode><![CDATA[]]></postalcode>
        <experience><![CDATA[]]></experience>
        <category><![CDATA[]]></category>
        <salary><![CDATA[]]></salary>
        <education><![CDATA[]]></education>
        <jobtype><![CDATA[]]></jobtype>
        <cpc><![CDATA[0.50]]></cpc>
        <segment>0.50</segment>
		<sponsored><![CDATA[sponsored 0.50]]></sponsored>
		<campaign_id></campaign_id>
        <cid>1038</cid>
        </job>

*/
?>