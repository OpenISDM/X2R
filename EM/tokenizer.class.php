<?php

abstract class Tokenizer
{
    public abstract function tokenizeArr(array $arr);
    public abstract function tokenizeStr($arr);

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