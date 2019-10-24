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
    <div id="song"><p>test</p></div>
HTML
);

$js = <<< HTML

   <script type='text/javascript' src='ajaxrequest.js'></script>
   
    <script type='text/javascript'>
   
        window.onload = function() {

            document.getElementById("alb").addEventListener('change',function(e)
            {
                
               
                charge("song.php",document.getElementById("alb").value,"song");
            });
           
            document.getElementById("genre").addEventListener('change',function(e)
            {
               
                charge("artistes.php",document.getElementById("genre").value,"art");
                
            });
            
            document.getElementById("art").addEventListener('change',function(e)
            {
                
                
                charge("album.php",document.getElementById("art").value,"alb");

                
            });
            
            function viderSelect(sel){
                

                
                var box = document.getElementById(sel);
                while  (box.firstChild) {
                box.removeChild(box.firstChild);
                }

            }
            

            function ajouterOption(sel, txt, val)
            {
                var o = new Option(txt, val);
                document.querySelector('#'+sel).add(o);
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
                                   
                                        
                                        console.log(sel)
                                        if (sel == "song")
                                        {
                                            viderNoeud("div");
                                            
                                            //document.querySelector("div").innerHTML = "<h1>{res[1]['name']}</h1>"
                                            var opt = document.getElementById("alb").options[document.getElementById("alb").selectedIndex];
                                                document.querySelector("div").innerHTML ="<h1>"+opt.text+"</h1>";
                                            for (var i = 0 ; i<res.length;i++)
                                            {
                                               
                                                console.log(res[i]['name'])
                                                document.querySelector("div").innerHTML += "<li>"+res[i]['num']+"-"+res[i]['name']+"-"+res[i]['duration']+"</l1>";

                                            }
                                            
                                        }
                                        else{
                                        viderSelect(sel);
                                        for (var i = 0 ; i<res.length;i++)
                                        {
                                           
                                            console.log(res[i]['id'],res[i]['txt']);

                                            ajouterOption(sel2, res[i]['txt'], res[i]['id']);
                                           
                                        }
                                        }
                                      
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





