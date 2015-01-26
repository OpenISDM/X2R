<?php
	file_put_contents("log/extractor.txt", "taskID");
	// file_put_contents("log/extractor.txt", $_GET["taskID"]);
	// file_put_contents("log/extractor.txt", $_POST["taskID"]);
	echo file_get_contents("./files/extractorResult_ToFrontEnd v0.3.json");
?>