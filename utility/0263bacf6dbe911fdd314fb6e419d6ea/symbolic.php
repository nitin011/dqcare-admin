<?php
$env = "Local";
// Local / Production

if($env == "Production"){
    $folderName = '../core/storage/app/public';
    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/'.$folderName;
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder,$linkFolder);
    echo 'Symlink process successfully completed';
}else{
    $projectFolderName = 'projects/zStarter';
    $folderName = $projectFolderName.'/core/storage/app/public';
      $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/'.$folderName;
     $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/'.$projectFolderName.'/public_html/storage';
    symlink($targetFolder,$linkFolder);
    echo 'Symlink process successfully completed';
}