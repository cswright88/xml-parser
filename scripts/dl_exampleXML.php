<?php
    // read first part of the xml file for example.htm
    // $file = fopen($url,"rb");
    // $firstlines = fread($file, 8192);
    // fclose($file);
    // $y = json_encode((string)$firstlines);
    $url = $_GET["url"];

    if(preg_match("/(.gz)$/",$url)) 
        {
            $url = 'compress.zlib://'.$url;
        } 

    $handle = fopen($url, "rb");
    if (FALSE === $handle) {
        exit("Failed to open stream to URL");
    }

    $contents = "";
    $count = 0;
    while ($count < 2) {
        $contents .= fread($handle, 8192);
        $count ++;
    }
    fclose($handle);

    $formattedContents = preg_split('/(<.*?>.*?<\/.*?>)/',$contents,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        
    //    $y = explode(">",$contents);
    $formattedContents = json_encode($formattedContents);
    echo $formattedContents;