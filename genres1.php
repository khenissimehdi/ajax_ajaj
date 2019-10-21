<?php 
require_once('autoload.include.php');
$p = new WebPage("Genre");
$stmt = MyPDO::getInstance()->prepare(<<<SQL
select id,name
from genre 
order by name;
SQL
);
$stmt->setFetchMode (PDO::FETCH_ASSOC);
$stmt->execute();
$genres = $stmt->fetchall();
$size=sizeof($genres);

$Style = <<<HTML
<select name="genre" id="genre" size="5">
    <option value="genre">genre...</option> 
HTML;

//var_dump($genres[0]['name']);

for ($i=1;$i<$size;$i++)
{
    $Style.= <<<HTML
        <option  value="{$i}">{$genres[$i]['name']}</option>
HTML;
}

$Style.="</select>";

$p->appendContent($Style);


$Artist = <<<HTML
<select name="Artist" id="art" size="5">
    <option value="artiste">artiste...</option> 
HTML;

$Artist.="</select>";

$p->appendContent($Artist);


$Album = <<<HTML
<select name="Album" id="alb" size="5">
    <option value="album">album...</option> 
HTML;

$Album .="</select>";

$p->appendContent($Album);

$p->appendContent(<<<HTML
    <div id="titres"></div>
HTML
);

$js = <<< HTML
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type='text/javascript'>
        window.onload = function() {
        /*
        var sel = "genre";
        console.log(document.querySelector("select#"+sel).options.length);
    }
    */
    var sel = "genre";
    var contenu ='<option value="27">lol</option>';
    document.querySelector("select#"+sel).append(contenu);

            function viderSelect(sel){
                var taille = document.querySelector("select#"+sel).options.length;

                for(var i = 1 ; i < taille ; i++){
                    document.querySelector("select#"+sel).options[i]=null;
                }
            }
/*
            function ajouterOption(sel, txt, val)
            {
                document.querySelector("select#"+sel).append(('<option>', { 
        value: val,
        text : txt
                }));



            }
            */
        }
    </script>
HTML;

$p->appendContent($js);

echo $p->toHtml();





