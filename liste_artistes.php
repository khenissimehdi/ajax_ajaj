<?php
include_once 'autoload.include.php';
$motif='%'.$_GET['q'].'%';

$stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM artist
        WHERE name LIKE :m
        order by name
        
SQL
);
$stmt->setFetchMode (PDO::FETCH_ASSOC);
$stmt->execute([':m'=>$motif]);
$artists = $stmt->fetchall();
//ar_dump($artists);
header('Content-Type: text/plain') ;
echo $_GET['q'] . " => ";
foreach ($artists as $ligne) {
    echo $ligne['name'] . "\n"."<br>";
}




/*
var String_Artistes = new Array() ;
    // Iterate on parameters
for (var i in $artists) {
        // Escape parameter value with encodeURIComponent()
    var paramencode = encodeURIComponent($artists[i]);
        // Store 'parameter_name=escaped_parameter_value' in array 'parameters'
    arameters.push(i+'='+paramencode);
}
*/