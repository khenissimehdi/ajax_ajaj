<?php 
require_once('autoload.include.php');
$motif='%'.$_GET['q'].'%';

$stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT  DISTINCT b.id "id" , CONCAT(b.year," - ",b.name) "txt"
    FROM album b , artist a
    WHERE a.id = artistId
    AND artistId LIKE :m
    order by year ;
SQL
);
$stmt->setFetchMode (PDO::FETCH_ASSOC);
$stmt->execute([':m'=>$motif]);
$albums = $stmt->fetchall();

header('Content-Type: application/json') ;
echo json_encode($albums);