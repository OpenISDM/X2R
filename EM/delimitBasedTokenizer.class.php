<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        extractor.class.php

    Abstract:

        extractor.class.php is the class for modeling the 
        URI extracting & transforming process as below. 
        
        Step 1. Load the RDF content to a Graph data structure
        Step 2. Traverse the Graph to finding all the URIs
        Step 3. Transform these URIs to search friendly terms
        Step 4. Wrap these terms as a JSON output



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
include_once 'tokenizer.class.php';

class Delimit_Based_Tokenizer extends Tokenizer
{

    public function tokenizeArr(array $arr)
    {

        $intmArr = array();
        foreach($arr as $str)
        {
            $tempArr = $this->tokenizeStr($str);
            $intmArr[] = $tempArr;
        }
        $resultArr = $this->arrConcatenate($intmArr);
        return $resultArr;


    }
    public function tokenizeStr($str)
    {

        $resultArr = $this->delimitizing($str);
        return $resultArr;
        
    }

    protected function delimitizing($str)
    {
        $resultStr = str_replace('_', '+', $str);
        //$resultStr = preg_replace("/[^\w\d ]/ui", ' ', $resultStr);
        $resultStr = preg_split("/[^\w\d ]/ui", $resultStr);
        return $resultStr;
    }


}

/*
$d = new Delimit_Based_Tokenizer();
$k = $d-> tokenizeStr('a+b+cd-E~G!H*&F');
print_r($k);
echo('<br>');
$j = $d-> tokenizeStr('a+b+cd-E~G!H*&F/史提芬福66_123Alf');
print_r($j);

echo('<br>');
$w = array('a+b+cd-E~G!H*&F', '史提芬福66_123Alf');
$j = $d-> tokenizeArr($w);
print_r($j);
*/