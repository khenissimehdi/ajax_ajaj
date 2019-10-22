<?php 
require_once('autoload.include.php');
$motif=$_GET['q'];

$stmt = MyPDO::getInstance()->prepare(<<<SQL
    select distinct t.number "num" , s.name "name",concat(round((t.duration/60)),":",round((t.duration%60))) "duration"
    from album b,track t,song s 
    where (songId = s.id
    and b.id = albumId
    and albumId like :m);
    
SQL
);
$stmt->setFetchMode (PDO::FETCH_ASSOC);
$stmt->execute([":m"=>$motif]);
$songs = $stmt->fetchall();
header('Content-Type: application/json') ;
echo json_encode($songs);