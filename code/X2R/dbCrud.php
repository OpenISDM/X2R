<?php    
/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        dbCrud.php

    Abstract:

        dbCrud.php takes the requests from X2R clients and perform the actions of
        Create/Read/Update/Delete (CRUD) of the VR database.

        dbCrud.php uses the class in dbCrudClass.php

    Authors:      

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com
    
    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.


    Major Revision History:
    
--*/
namespace X2R\

include 'dbCrudClass.php';

//
// Save the log in dbCrud.txt
//

file_put_contents("log/dbCrud.txt", " Start");
file_put_contents(
    "log/dbCrud.txt",
    " taskID ".$_POST["taskID"],
    FILE_APPEND
);
file_put_contents(
    "log/dbCrud.txt",
    " token ".$_POST["token"],
    FILE_APPEND
);

//
// Set up the arguments to connect the database.
// A new crud object
//

$crud = new X2R\DatabaseCRUD();

//
// Setup the DSN
//
// TODO:
// Make user name, password and database address to read from file
//

$crud->dsn = "mysql:host=140.109.17.52:3307;dbname=X2R";

//
//  Setup MySQL username and password
//

$crud->username = 'Gentry';
$crud->password = 'openisdm';

if(isset($_POST["taskID"]) && isset($_POST["token"])) {
    
    //
    // 1. Get token by taskID from X2R.task
    //

    $targetToken = "";
    $results = $crud->rawSelect(
        'SELECT `token` FROM `task` WHERE `taskID` = '.$_POST["taskID"]
    );
    $rows = $results->fetchAll(PDO::FETCH_ASSOC);
    
    if (sizeof($rows) == 1) {
        
        $targetToken = $rows[0]["token"];
        
    } else {
    
        //
        // TODO:
        // Error handling: mulitple instances with same taskID.
        // Should be impossible. taskID in X2R.task is a primary key
        //

    }

    //
    // 2. Compare with taskID, extract methods and perform CRUD.
    //

    if ($_POST["token"] == $targetToken) {

        if (isset($_POST["method"])) { 
            
            switch ($_POST["method"]) {
                case "create":
                    
                    //
                    // TODO:
                    // Validate $_POST["data"]
                    // createRow($crud, $data);
                    //
                    
                    break;

                case "read":                    
                    echo readRows($crud, $_POST["taskID"]);
                    break;

                case "update":
                    
                    if (
                        isset($_POST["fieldName"]) &&
                        isset($_POST["value"]) &&
                        isset($_POST["mappingDataID"])
                    ) {
                        
                        $fieldName = $_POST["fieldName"];
                        $value = $_POST["value"];
                        $mappingDataID = $_POST["mappingDataID"];
                        updateRow(
                            $crud,
                            $fieldName,
                            $value,
                            $mappingDataID
                        );

                    } else {
                        echo "fileName or value or mappingDataID is not set";
                    }
                    
                    break;

                case "delete":
                    
                    if (isset($_POST["mappingDataID"])) {
                        
                        $mappingDataID = $_POST["mappingDataID"];
                        deleteRow($crud, $mappingDataID);

                    } else {
                        
                        //
                        // TODO:
                        //

                    }
                    
                    break;

                default:
                    echo "Invalid method";
                    return;
            }

        } else {
            echo "method or data is not set";
        }
    } else {
        echo "Invalid token";
    }

} else {
    echo "taskID or token is not set";
}

/*++
Function Name:

    createRow

Function Description:
    
    Create a entry in the specified table.

Parameters:
    
    handle $crud - The handle of database operation.
    
    string $taskID - The task ID related to specified task.
    
    string $values - An array of values needed to be insert to the table.

Returned Value:
    
    If the function returned normally, the returned value is mapping Data 
    ID; otherwise, the returned value is null.

Possible Error Code:        
    
--*/

function createRow($crud, $taskID, $values)
{
    //
    // ToDo: Validate token
    // Assume only one item needs to be inputed.
    //
    
    $term = $values["term"];        
    $originalURIText = $values["originalURI"];
    $originalURIMD5 = md5($originalURIText);
    
    //
    // Initial check the existence of "replacedURI" field
    //
    
    if ($values["replacedURI"] != "") {
        
        $replacedURIText = $values["replacedURI"];
        $replacedURIMD5 = md5($replacedURIText);

    } else {
        
        $replacedURIText = null;
        $replacedURIMD5 = null;            
    }

    $status = $values["status"];
    $lineNumbers = json_encode($values["lineNumbers"]);
    
    $mappingData = array(
        array(
            'mappingDataID'=>null,
            'taskID'=>$taskID,
            'term'=>$term,
            'originalURIMD5'=>$originalURIMD5,
            'originalURIText'=>$originalURIText,
            'replacedURIMD5'=>$replacedURIMD5,
            'replacedURIText'=>$replacedURIText,
            'lineNumbers'=>$lineNumbers,
        )
    );

    //
    // Insert the array of values into the mappingData table
    //
    // TODO:
    // Check success/fail of dbInsert
    //

    $mappingDataID = $crud->dbInsert("mappingData", $mappingData);
    echo $mappingDataID;
}

/*++
Function Name:

    readRow

Function Description:
    
    Read a row in the mappingData table.

Parameters:
    
    handle $crud - The handle of database operation.
    
    string $taskID - The task ID related to specified task.        

Returned Value:

    If the function returned normally, the returned value is the 
    values of the entry; otherwise, the returned value is null.

Possible Error Code:        
    
--*/

function readRows($crud, $taskID)
{        
    $results = $crud->dbSelect('mappingData', 'taskID', $taskID);
    $returnArray = array("mapping" => $results);

    echo json_encode($returnArray);
}

/*++
Function Name:

    updateRow

Function Description:
    
    Update a value of a field in the mappingData table.

Parameters:
    
    handle $crud - The handle of database operation.
    
    string $filedName - The filed name of the table want to update.

    string $value - The value of the update filed.

    string $mappingDataID - The unique ID to specify the row

Returned Value:
    
    If the function returned normally, the returned value is the 
    values of the entry; otherwise, the returned value is null.

Possible Error Code:        
    
--*/

function updateRow($crud, $fieldName, $value, $mappingDataID)
{        
    //ToDo: need to check the $fieldName existence
    $crud->dbUpdate("mappingData", $fieldName, $value, "mappingDataID", $mappingDataID); 
}

/*++
Function Name:

    deleteRow

Function Description:
    
    Delete a row in the mappingData table.

Parameters:
    
    handle $crud - The handle of database operation.        

    string $mappingDataID - The unique ID to specify the row

Returned Value:
    
    If the function returned normally, the returned value is the 
    values of the entry; otherwise, the returned value is null.

Possible Error Code:        
    
--*/

function deleteRow($crud, $mappingDataID)
{
    $crud->dbDelete("mappingData", "mappingDataID", $mappingDataID);
}
?>