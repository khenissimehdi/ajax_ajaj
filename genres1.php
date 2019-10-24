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
        <option  value="{$genres[$i]['id']}">{$genres[$i]['name']}</option>
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
    <div id="titres"><p>lol</p></div>
HTML
);

$js = <<< HTML

   <script type='text/javascript' src='ajaxrequest.js'></script>
   
    <script type='text/javascript'>
   
        window.onload = function() {


            document.getElementById("genre").addEventListener('click',function(e)
            {
               
                charge("artistes.php",document.getElementById("genre").value,"art");
                var taille = document.querySelector("select#"+"art").options.length;
                console.log(taille)
            });
            document.getElementById("art").addEventListener('click',function(e)
            {
                

                charge("album.php",document.getElementById("art").value,"alb");

                
            });
            //charge("artistes.php", "15","art");
            //ajouterOption("genre","lol","27");
            
            //var taille = document.querySelector("select#"+"art").options.length;
            //console.log(taille)
            function viderSelect(sel){
                var taille = document.querySelector("select#"+sel).options.length;

                for(var i = 1 ; i < taille ; i++){
                    document.querySelector("select#"+sel).options[i]=null;
                }
            }

            function ajouterOption(sel, txt, val)
            {
                var o = new Option(txt, val);
                document.querySelector("select#"+sel).add(o);

            }
            function viderNoeud(noeud)
            {
                var a=document.getElementsByTagName(noeud)[0].id;
                var box = document.getElementById(a);
            while (box.firstChild) {
                box.removeChild(box.firstChild);
                    }
            }
            
            function charge(url, str,sel) {
                req=null;
                sel2=sel;
                req = new AjaxRequest(
                            {
                                url        : url,
                                method     : 'get',
                                handleAs   : 'json',
                                parameters : { q : str },
                                

                                
                                onSuccess  : function(res) {
                                        //var a = res[0];
                                        //console.log(res[0]['id']);*
                                        viderSelect(sel);
                                        for (var i = 0 ; i<res.length;i++)
                                        {
                                           
                                            console.log(res[i]['id']);

                                            ajouterOption(sel2, res[i]['txt'], res[i]['id']);
                                           
                                        }
                                        //ajouterOption(sel, txt, val)
                                        //v_span=document.querySelector("span").innerHTML = res;
                                    },
                                onError    : function(status, message) {
                                        window.alert('Error ' + status + ': ' + message) ;
                                    },
                                    
                                    
                                
                            }) ;


                
                        }
            
        }
    </script>
HTML;

$p->appendContent($js);

echo $p->toHtml();





