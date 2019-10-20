<?php 
require_once('autoload.include.php');
$motif='%'.$_GET['q'].'%';

$stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT  DISTINCT artistId "id" , a.name "txt"
    FROM album b , artist a
    WHERE a.id = artistId
    AND genreId LIKE :m
    order by a.name;
SQL
);
$stmt->setFetchMode (PDO::FETCH_ASSOC);
$stmt->execute([':m'=>$motif]);
$artists = $stmt->fetchall();
echo '<pre>';
print_r(json_encode($artists,JSON_PRETTY_PRINT));
echo '</pre>';