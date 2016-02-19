<?php

    require_once "classes_php/BdClass.php";
    require_once "classes_php/LoadFilesClass.php";

    $host            = "localhost";
    $user            = "root";
    $pass            = "";
    $db              = "bd_prices";
    $table           = "prices";
    $file_name_mask  = "prices";
    $file_extension  = "txt";
    $dir             = "upload";

    $bd = new BdClass($host, $user, $pass, $db, $table);
    $loadfiles = new LoadFilesClass($dir, $file_name_mask, $file_extension, $table);

    $data_files=$loadfiles->load_files();
    if($data_files){
        $bd->insert_records($data_files);
    }
    require_once "html/form.php";
?>
