<?php
    include 'ClassDbCrud.php';

    /*** a new crud object ***/
    $crud = new DatabaseCRUD();

    /*** The DSN ***/
    $crud->dsn = "mysql:host=140.109.17.46:3307;dbname=X2R";
    
    /*** MySQL username and password ***/
    $crud->username = 'anderson';
    $crud->password = 'openisdm';

    /*** array of values to insert ***/
    $values = array(
        array('animal_name'=>'bruce', 'animal_type'=>'dingo'),
        array('animal_name'=>'bruce', 'animal_type'=>'wombat'),
        array('animal_name'=>'bruce', 'animal_type'=>'kiwi'),
        array('animal_name'=>'bruce', 'animal_type'=>'kangaroo')
    );

    $mappingData = array(
        array(
            'MappingDataID'=>null,
            'TaskID'=>'111',
            'Term'=>'111',
            'OriginalURIMD5'=>'111',
            'OriginalURIText'=>'111',
            'ReplacedURIMD5'=>'111',
            'ReplacedURIText'=>'111',
            'LineNumbers'=>'111',
        )
    );

    /*** insert the array of values ***/
    $crud->dbInsert('mappingData', $mappingData);

    /*** select all records from table ***/
    $records = $crud->rawSelect('SELECT * FROM mappingData');

    /*** fetch only associative array of values ***/
    $rows = $records->fetchAll(PDO::FETCH_ASSOC);

    /*** display the records ***/
    foreach ($rows as $row) {
        foreach ($row as $fieldname=>$value) {
            echo $fieldname.' = '.$value.'<br />';
        }
        echo '<hr />';
    }

    /*** update the kiwi ***/
    $crud->dbUpdate('mappingData', 'Term', 'TEST TERM', 'TaskID', 111); 

    /*** delete the second record ***/
    $res = $crud->dbDelete('mappingData', 'TaskID', 111 );  
?>