<?php
session_start();
if(isset($_POST['motWikiComplement']) && $_POST['motWikiComplement'] != ''){
    if(isset($dataComp) && $data != ''){
        unset($dataComp);
    }

    require "toolbox.php";
    require "simple_html_dom.php";


    function enleveTagsPerso($chaine)
    {
        $search  = array('<i>', '</i>', '<ol>', '</ol>', '<li>', '</li>');
        $replace = array('', '', '', '', '', '');

        $chaine = str_replace($search, $replace, $chaine);
        return $chaine; 
    }

    
    $motWikiComplementTemp = $_POST['motWikiComplement'];
    $nat = $_POST['langue'];

    if($nat=="en" && stristr($motWikiComplementTemp, 'to ')){
        $motWikiComplement = valid_donnees(substr($motWikiComplementTemp, 3));
    }else{
        $motWikiComplement = valid_donnees($motWikiComplementTemp);
    }


    // $nat = "fr";
    // $motWikiComplement = "roue";

    $url = '';
    $errorComp = '';
    if (IFilesExists("https://fr.wiktionary.org/wiki/".$motWikiComplement)){
        $url = "https://fr.wiktionary.org/wiki/".$motWikiComplement;
    } else {
        header('Location: ' .$_SERVER['HTTP_REFERER']);
        $errorComp = "Le mot ".mb_strtoupper($motWikiComplement). " n'apparait pas dans notre dictionnaire de référence, le Wiktionary.";
        exit;
    }
    $naturesGramComp = [];
    $resfinalComp = [];
    $resTempComp = [];
    $resComp = [];
    $nbNaturesGramComp = 0;
    $resFinComp = [];
    $genreTComp = [];
    $genreComp = [];

    $html = new simple_html_dom();
    $html->load_file($url);

    if($nat == "fr"){
        $nbNaturesGramComp=count($html->find('h3 span.titredef[id^=fr-]'));
    }
    if($nat != "fr"){
        $nbNaturesGramComp=count($html->find('h3 span.titredef[id^='.$nat.'-]'));
    }

    if($nbNaturesGramComp == 0){
        header('Location: ' .$_SERVER['HTTP_REFERER']);
        $errorComp = "Le mot ".mb_strtoupper($motWikiComplement). " n'apparait pas dans notre dictionnaire de référence, le Wiktionary.";
        exit;
    }

    /* ###################################################################################### */
    $nbSections = count($html->find('h2 span.sectionlangue'));
    foreach ($html->find('h2 span.sectionlangue') as $i => $v){
       $section[]=$v->plaintext;
       $attributId[] = $v->id; 
    }
    foreach($section as $i => $v){
        $str = $html->save(); 
        if($nbSections>1){
            if($i<$nbSections-1){
                $str1 = strstr($str, '<span class="sectionlangue" id="'.$nat.'">');
                $str2 = strstr($str, '<span class="sectionlangue" id="'.$attributId[$i+1].'">');

                $str1Tab = explode(" ", $str1);
                $str2Tab = explode(" ", $str2);
    
                $nbMotsStr1 = count($str1Tab);
                $nbMotsStr2 = count($str2Tab);
    
                $nbAng = $nbMotsStr1 - $nbMotsStr2;
                $strFin = "";
                for($i=0; $i<$nbAng; $i++){
                    $strFin .= $str1Tab[$i]." ";
                }
            }
            if($i == $nbSections-1){
                $strFin = strstr($str, '<span class="sectionlangue" id="'.$nat.'">');
            }
        }else{
            $strFin = strstr($str, '<span class="sectionlangue" id="'.$nat.'">');
        }

    }
    /* ###################################################################################### */
    
    if($nat == "fr"){
        foreach($html->find('h3 span.titredef[id^=fr-]') as $v){
            $naturesGramComp[] = $v->plaintext;
        }
        $z=0;
        foreach($naturesGramComp as $i => $class){
            if (strpos($class, "commun") !== FALSE){
                $x = $html->find('p span.ligne-de-forme', $z)->plaintext;
                $genreComp[] = [$class, $x];
                $z++;
            }else{
                $genreComp[]=$class;
            }
        }
    }
    if($nat != "fr"){
        foreach($html->find('h3 span.titredef[id^='.$nat.'-]') as $v){
            $naturesGramComp[] = $v->plaintext;
        }
        foreach ($naturesGramComp as $i => $class){
            $genreComp[] = $class;
        }
    }

    $z=0;


    for($z=0; $z<$nbNaturesGramComp; $z++){
        if($z == 0 && $nat == "fr"){
            $teteOk = false;
            $ol_rang = 0;
            if(null != $html->find('div[id=mw-content-text]', 0)){
                if(null != $html->find('div[id=mw-content-text]', 0)->find('dl', 0)){
                    if(null != $html->find('div[id=mw-content-text]', 0)->find('dl', 0)->find('ol', 0)){
                        $nbOl = count($html->find('div[id=mw-content-text]', 0)->find('dl', 0)->find('ol'));
                        $ol_rang = $nbOl; 
                    }
                }
            }

            if(null != $html->find('ol', $ol_rang)){
                if(null != $html->find('ol', $ol_rang)->find('li', 0)){
                    if(null != $html->find('ol', $ol_rang)->find('li', 0)->find('span', 0)){
                        if($html->find('ol', $ol_rang)->find('li', 0)->find('span', 0)->plaintext == 'Linguistique'){
                            $ol_rang++;
                        }
                    }
                }
            }   
        }
        if($z == 0 && $nat != "fr"){
            $ol_rang = 0;
        }

        if($z != 0){
            $ol_rang++;
        }

        if($nat != "fr"){
            $html2 = new simple_html_dom();
            $html2->load($strFin);
            $tete=$html2->find('ol', $ol_rang);
        }else{
            $tete=$html->find('ol', $ol_rang);
        }
        
        
        $str='';
        $str2='';
        $str3='';
        $str4='';
        $ref='';

        $html10 = new simple_html_dom();
        $html10->load($tete);
        
        
        foreach($html10->find('ul') as $ul){
            $ul->innertext="";
        }
        $str=$html10;
        $str2  = str_replace("<ul></ul>", "", $str);

        $html11 = new simple_html_dom();
        $html11->load($str2);
        foreach($html11->find('dl') as $dl){
            $dl->innertext="";
        }
        $str3=$html11;
        $str4  = str_replace("<dl></dl>", "", $str3);

        $html15 = new simple_html_dom();
        $html15->load($str4);

        $t = $html15->find('ol', 0);
 
        $ref = $t->innertext;

        $resTepComp = [];
        $resFinComp = [];
        $resOlComp = [];
        $resTComp = [];
        $resTTComp = [];
        $res2Comp = [];
        $resComp = [];
        $resTTTComp = [];
        $resTemmpComp = [];
        $resTemmp2Comp = [];
        
        $html20 = new simple_html_dom();
        $html20->load($ref);
        $testLi=$html20->find('li');
        foreach($testLi as $li){

            $resComp[]=$li;
        }

        foreach($resComp as $v){
            $test = $v->find('ol', 0);
            if($test != ''){
                foreach($test->find('li') as $li){
                    $resTepComp[]=$li;
                }
            }
            
        }
        $resComp = array_diff($resComp, $resTepComp);

        $resStr = '';

        foreach($resComp as $v){
            $resStr .= $v;
        }

        $resOlComp = explode("<ol>", $resStr);
        // printPre($resOlComp);
        $nbEl = count($resOlComp);

        if ($nbEl == 1){
            $resTemmpComp=explode("<li>", $resOlComp[0]);
                foreach($resTemmpComp as $l){
                    $res2Comp[]=$l;
                }
        }else{
            foreach($resOlComp as $i => $v){
                if (strpos($v, "</ol>") !== FALSE){
                    $resTTTComp=explode("</ol>", $v);

                    $resTemmpComp=explode("<li>", $resTTTComp[0]);
                    foreach($resTemmpComp as $l){
                        $resTComp[]=$l;
                    }
                    $res2Comp[]=[$resTComp];

                    $resTemmp2Comp=explode("<li>", $resTTTComp[1]);
                    foreach($resTemmp2Comp as $l2){
                        $res2Comp[]=$l2;
                    }

                }else{
                    $resTemmpComp=explode("<li>", $v);
                    foreach($resTemmpComp as $l){
                        $res2Comp[]=$l;
                    }
                }
            }
        }
        if($nat == "fr"){
            $nbArrayComp=0;
            foreach($res2Comp as $i => $v){
                if(is_string($v)){
                    $resFinComp[] = strip_tags($v);
                    if($resFinComp[$i] == ''){
                        unset($resFinComp[$i]);
                    }
                }
                if(is_array($v)){
                    $nbArrayComp++;
                    foreach($v[0] as $p => $l){
                        if($p != 0){
                            $resTTComp[]=strip_tags($l);
                        }
                    }
                    if ($p != 0 && $nbArrayComp>1){
                        $restTTUniqueComp =array_values(array_unique($resTTComp));
                        $k=array_search("", $restTTUniqueComp);
                        $resFinComp[]=[array_slice($restTTUniqueComp, $k+1)];
                    }else{

                        $resFinComp[]=[array_keys(array_flip($resTTComp))];        
                    }       
                    
                }
            }
            $ol_rang += $nbArrayComp;
            $resfinalComp[$z][]=$resFinComp;
        }
        // printPre($res2Comp);
        if ($nat != "fr"){
            foreach($res2Comp as $i => $v){
                $resFinComp[] = strip_tags($v);
                if($resFinComp[$i] == ''){
                    unset($resFinComp[$i]);
                }
            }
            $resfinalComp[$z][]=$resFinComp;
            $resFinComp=[];
        }
    }
    // printPre($resfinalComp);
    $dataComp = array();
    $dataComp["direct_link_comp"]=$url;
    $dataComp["motWikiComplement"]=$motWikiComplement;
    $dataComp["natureComp"]=$naturesGramComp;
    $dataComp["genreComp"]=$genreComp;
    $dataComp["natureDefComp"]=$resfinalComp;
    $dataComp["error"]=$errorComp;

    echo json_encode($dataComp);
}