<?php
/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        dbCrudClass.php

    Abstract:

        dbCrudClass.php is class file of basic database property and operation
        of a database instance.

    Authors:      

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.


    Major Revision History:
    
--*/
namespace \X2R\X2R;

class DatabaseCRUD
{
    private $db;

    /*++
    Function Name:

        __set

    Function Description:
        
        Set variables

    Parameters:
        
        string $name - The variable name. It can be "username", "password" and "dsn"
        (Data Source Name).
        
        string $value - The value of a variable.

    Returned Value:
        
        If the function returned normally, there is no returned value
        otherwise, the function throws an exception.

    Possible Error Code:
        
    --*/

    public function __set($name, $value)
    {
        switch($name)
        {
            case 'username':
            $this->username = $value;
            break;

            case 'password':
            $this->password = $value;
            break;

            case 'dsn':
            $this->dsn = $value;
            break;

            default:
            throw new Exception("$name is invalid");
        }
    }

    /*++
    Function Name:

        __isset

    Function Description:
        
        Reset variables

    Parameters:
        
        string $name - The variable name. It can be "username", "password" and "dsn"
        (Data Source Name).

    Returned Value:
        
        There is no returned value.

    Possible Error Code:
        
    --*/

    public function __isset($name)
    {
        switch($name)
        {
            case 'username':
                $this->username = null;
                break;

            case 'password':
                $this->password = null;
                break;
        }
    }

    /*++
    Function Name:

        conn

    Function Description:
        
        Connect the database with specified username, password, data source name.

    Parameters:

    Returned Value:
        
        If the function returned normally, there is no returned value
        otherwise, the function throws an exception.

    Possible Error Code:
        
    --*/

    public function conn()
    {
        isset($this->username);
        isset($this->password);
        if (!$this->db instanceof PDO) {
            $this->db = new PDO($this->dsn, $this->username, $this->password);

            //
            // ToDo: Validate token
            // Check create $this->db successfully
            //

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /*++
    Function Name:

        dbSelect

    Function Description:
        
        Select values from table.

    Parameters:

        string $table - The name of the table.

        string $fieldname - The field of the table

        string $id

    Returned Value:
        
        Return array on success or throw PDOException on failure

    Possible Error Code:
        
    --*/

    public function dbSelect($table, $fieldname=null, $id=null)
    {
        $this->conn();
        $sql = "SELECT * FROM `$table` WHERE `$fieldname`=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*++
    Function Name:

        rawSelect

    Function Description:
        
        Select by the given sql.

    Parameters:

        string $sql - The sql to select from the database.

    Returned Value:
        
        Return the result of select.

    Possible Error Code:
        
    --*/

    public function rawSelect($sql)
    {
        $this->conn();
        return $this->db->query($sql);
    }

    /*++
    Function Name:

        rawQuery

    Function Description:
        
        Run a raw query.

    Parameters:

        $sql - The sql to select from the database.

    Returned Value:
        
        Return the result of query.

    Possible Error Code:
        
    --*/

    public function rawQuery($sql)
    {
        $this->conn();
        $this->db->query($sql);
    }

    /*++
    Function Name:

        dbInsert

    Function Description:
        
        Insert a value into a table.

    Parameters:

        string $table - The table to search,
     
        array $values - The values to be inserted into the table.


    Returned Value:
        
        int The last Insert Id on success or throw PDOexeption on failure

    Possible Error Code:
        
    --*/

    public function dbInsert($table, $values)
    {
        $this->conn();
        
        //
        // snarg the field names from the first array member
        //
        
        $fieldnames = array_keys($values[0]);
        
        //
        // now build the query
        //
        
        $size = sizeof($fieldnames);
        $i = 1;
        $sql = "INSERT INTO $table";
        
        //
        // set the field names
        //
        
        $fields = '( ' . implode(' ,', $fieldnames) . ' )';
        
        //
        //  set the placeholders
        //
        
        $bound = '(:' . implode(', :', $fieldnames) . ' )';
        
        //
        // put the query together
        //

        $sql .= $fields.' VALUES '.$bound;

        //
        //  prepare and execute
        //
        
        $stmt = $this->db->prepare($sql);
        foreach($values as $vals)
        {
            $stmt->execute($vals);
            echo $this->db->lastInsertId();
        }
    }

    /*++
    Function Name:

        dbUpdate

    Function Description:
        
        Update a value of a filed in a table.

    Parameters:

        string $table - The requested table
     
        string $fieldname - The field to be updated
     
        string $value - The new value
     
        string $pk - The primary key
     
        string $id - The id

    Returned Value:
        
        No return value on success 

    Possible Error Code:
        
        Throw PDOexeption on failure

    --*/

    public function dbUpdate($table, $fieldname, $value, $pk, $id)
    {
        $this->conn();
        $sql = "UPDATE `$table` SET `$fieldname`='{$value}' WHERE `$pk` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }


    /*++
    Function Name:

        dbDelete

    Function Description:
        
        Delete a record from a table.

    Parameters:

        string $table - The requested table
     
        string $fieldname - The field to be updated
     
        string $id - The id


    Returned Value:
        
        No return value on success 

    Possible Error Code:
        
        Throw PDOexeption on failure

    --*/

    public function dbDelete($table, $fieldname, $id)
    {
        $this->conn();
        $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
}
