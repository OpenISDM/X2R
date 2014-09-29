<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        Tokenizer.class.php

    Abstract:

        Tokenizer.class.php is an abstract class .  
        




    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/

abstract class Tokenizer
{
    public abstract function tokenizeArr(array $arr);
    public abstract function tokenizeStr($str);

    protected function arrConcatenate(array $arrs)
    {
    	$newArr = array();
    	foreach ($arrs as $arr)
    	{
    		foreach ($arr as $value)
    		{
    			$newArr[] = $value;

    		}
    	}
    	return $newArr;
    }

    public function arrToString(array $arr)
    {
    	$newStr = '';
    	foreach ($arr as $value)
    	{
            try
            {
            	$newStr = $newStr.' '.$value;
            }
            catch (Exception $e)
            {
            	//ToDo: Exceptional Handling
            }
    		    

    	}
    	return $newStr;
    }

}