<?php

/**
 * TABLES BOOTSTRAP et AFFICHAGE BDD - PAGINATION ET TRI
 * le 27.03.2020
 * 
 * Fonction qui crée un tableau à partir de données extraites d'une base de données,
 * avec une pagination et une possibilité de tri à partir de chaque colonne 
 * (nécessite Bootstrap et Font Awesome)
 * 
 * Exemple commenté : "test/exemple-bootstrap-table-bdd.php"
 * Version html : "version_html/html-table-bootstrap.php"
 *
 * @package     TABLES BOOTSTRAP et AFFICHAGE BDD
 * @version     1.0.0
 * @license     GNU General Public License v3.0
 * @author      Frédéric Gainza <contact@fgainza.fr>
 * @link        https://github.com/FredGainza/table-boostrap-pagination-tri
 * 
 * 
 */

use OpenCloud\Common\Constants\Datetime;

/**
 * @param string $dbname
 * @param string $table
 * @param int $limit_par_default
 * @param int $nb_autour
 * @param array $nb_par_page
 * @param string $user
 * @param string $pass
 * @param null $columnsSelected
 * @param null $colDate
 * @param null $cols
 */
function tableBootstrap($dbname, $table, $limit_par_default = 25, $nb_autour = 5, $nb_par_page = [3, 5, 10, 25, 50, 100], $host = 'localhost', $user = 'root', $pass = '', $columnsSelected=NULL, $colDate=null, $cols=NULL)
{
    /******DEBUT DES ELEMENTS A RENSEIGNER ******/
    /* Nom de la table */
    $table;

    /* Nb éléments par page par défaut */
    $limit_par_default;

    /* Nb max de pagination autour de la page active */
    $nb_autour;

    /* Tableau nb éléments par page possibles  */
    $nb_par_page;

    /* Optionnel : Tableau des colonnes sélectionnées [field_bdd_1, field_bdd_4...] */
    $columnsSelected;

    /* Optionnel : Si une colonne est au format timestamp et que l'on veut la formater en fr */
    $colDate;
    
    /* Optionnel : Tableau  à 2 dim [field_bdd, intitulé th] */
    // $cols = [['id', 'Id'], ['firstname', 'Prénom'], ['lastname', 'Nom'], ['email', 'Email'], ['tel', 'Téléphone']];
    $cols;

    // Connexion à la base de données
    $host;
    $dbname;
    $user;
    $pass;

    try {
        $dbh = new PDO('mysql:host='.$host.';dbname=' . $dbname, $user, $pass);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }



/*
===================================================
#                                                 #
#                Partie Pagination                #
#                                                 #
===================================================
*/
    $testCol=true;
    // if(!isset($columnsSelected)){
        $prepare = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table . "'";
        $q = $dbh->prepare($prepare);
        $q->execute();
        while ($donnees = $q->fetch(PDO::FETCH_OBJ)) {
            $columnsTemp[] = $donnees->COLUMN_NAME;
        }
    // }
    if(isset($columnsSelected) && count($columnsSelected) != 0){
        foreach($columnsSelected as $col){
            if (!in_array($col, $columnsTemp)){
                $testCol=false;
            }
        }
        if($testCol){
            foreach($columnsSelected as $col){
                $columns[]=$col;
            }
        }else{
            $columns = $columnsTemp;
        }
    }else{
        $columns = $columnsTemp;
    }
    // print_r($columns[0]);exit;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

    if (isset($_GET['nb_items']) && $_GET['nb_items'] > 0) {
        $limit = intval($_GET['nb_items']);
    } elseif (isset($_SESSION['limit'])) {
        $limit = intval($_SESSION['limit']);
    } else {
        $limit = $limit_par_default;
    }
    $_SESSION['limit'] = $limit;
    $debut = (!isset($debut)) ? 0 :  $page * $limit;

    $requete = "SELECT * FROM " . $table;
    $select_temp = $dbh->prepare($requete);
    $select_temp->execute();
    $nb_total = $select_temp->rowCount();

    $limite = $dbh->prepare($requete . " limit $debut,$limit");
    $limit_str = "LIMIT " . $page * $limit . ",$limit";

    /*
===================================================
#                                                 #
#              Partie Tri du Tableau              #
#                                                 #
===================================================
*/

    $last = count($columns) - 1;
    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[$last];
    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
    if ($resultat = $dbh->prepare($requete . ' ORDER BY ' .  $column . ' ' . $sort_order . ' ' . $limit_str)) {
        $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
        $add_class = ' class="select_col"';
        $resultat->execute();
        $res = $resultat->fetchAll(PDO::FETCH_OBJ);
    }


    /*  
===================================================
#                                                 #
#                 Partie Affichage                #
#                   HTML et CSS                   #
#                                                 #
===================================================
*/

    echo '<div class="container-fluid w-90i mx-auto">';
    echo '<h3 class="text-center titre-table text-danger mt-4 mb-0">Table '.$table.'</h3>';
    echo '<div class="row mt-3 mb-3 justify-content-arround">';
    echo '<form action="" method="GET">';
    echo '<div class="form-group form-select row w-100 align-items-center flex-nowrap">';
    echo '<label class="col-auto col-form-label col-form-label-lg" for="&nb_items">Eléments par page</label>';
    echo '<div class="col-auto pad-l-0 ">';
    echo '<select name="nb_items" class="form-control form-control-lg pad-r-0 custom-select">';
    for ($i = 0; $i < count($nb_par_page); $i++) {
        if ($nb_par_page[$i] > 0 && $nb_par_page[$i] <= $nb_total) {
            echo '<option value="'.$nb_par_page[$i].'"';
            echo $limit == $nb_par_page[$i] ? ' selected="selected"' : '';
            echo '>' . $nb_par_page[$i] . '</option>';
        }
    }
    echo '</select>';
    echo '</div>';
    echo '<input type="hidden" value="'.$table.'" name="table">';
    echo '<div class="form-group form-select w-25 pl-3 valid">';
    echo '<button type="submit" class="btn btn-success btn-valid px-3 pady-0-1">Valider</button>';
    echo '</div>';
    echo '</div>';
    echo '</form>';

    echo '</div>';

    echo '<div class="row align-items-center justify-content-between">';
    echo '<div>';
    echo '<span class="fz-110r-f font-weight-700">Nombre total d\'éléments : <span class="fz-110r-f text-info font-weight-bold">'.$nb_total.'</span></span>';
    echo '</div>';
    echo "<nav aria-label=\"Partie Pagination mx-auto\">";
    echo "<ul class=\"pagination\">";
    $nb_pages = ceil($nb_total / $limit);
    $nb_pages_index = $nb_pages - 1;
    if ($page > 0) {
        $precedent = $page - 1;
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?table=".$table."&nb_items=" . $limit . "&page=" . $precedent . "&column=" . $column . "&order=" . strtolower($sort_order) . "\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span></a></li>";
    } else {
        $page = 0;
    }
    $i = 0;
    $j = 1;

    if ($nb_total > $limit) {
        while ($i < ($nb_pages)) {
            if ($i != $page && abs($page - $i) < $nb_autour) {
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?table=".$table."&nb_items=" . $limit . "&page=" . $i . "&column=" . $column . "&order=" . strtolower($sort_order) . "\">$j</a></li>";
            }
            if (abs($page - $i) >= $nb_autour) {
                if ($page - $i >= $nb_autour) {
                    if ($page - $i - 1 < $nb_autour) {
                        if ($page != 0) {
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?table=".$table."&nb_items=" . $limit . "&page=0&column=" . $column . "&order=" . strtolower($sort_order) . "\">1</a></li>";
                        }
                        echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" tabindex=\"-1\">&hellip;</a></li>";
                    }
                }
            }
            if ($i == $page) {
                echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\"><b>$j</b></a></li>";
            }
            if (abs($page - $i) >= $nb_autour) {
                if ($i - $page >= $nb_autour) {
                    if ($i - $page - 1 < $nb_autour) {
                        echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" tabindex=\"-1\">&hellip;</a></li>";
                        if ($page != $nb_pages_index) {
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?table=".$table."&nb_items=" . $limit . "&page=" . $nb_pages_index . "&column=" . $column . "&order=" . strtolower($sort_order) . "\">$nb_pages</a></li>";
                        }
                    }
                }
            }
            $i++;
            $j++;
        }
    }
    if ($debut + $limit < $nb_total) {
        $suivant = $page + 1;
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?table=".$table."&nb_items=" . $limit . "&page=" . $suivant . "&column=" . $column . "&order=" . strtolower($sort_order) . "\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></a></li>";
    }
    echo "</ul></nav>";

    echo '</div>';
    echo '</div>';

    echo '<div class="table-responsive">';
    echo '<table class="mb-5 border-dark">';
    echo '<thead>';
    echo '<tr>';
    for ($i = 0; $i < count($columns); $i++) {
        echo '<th';
        echo $column == (isset($cols) ? $cols[$i][0] : $columns[$i]) ? $add_class : "";
        echo '><a href="?table='.$table.'&nb_items=' . $limit . '&page=' . $page . '&column=';
        echo isset($cols) ? $cols[$i][0] : $columns[$i];
        echo '&order=' . $asc_or_desc . '">';
        echo isset($cols) ? $cols[$i][0] : $columns[$i];
        echo '<i class="fas fa-sort';
        echo $column == (isset($cols) ? $cols[$i][0] : $columns[$i]) ? '-' . $up_or_down . ' color-darky ml-2' : ' text-warning ml-2';
        echo '"></i></a></th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($res as $v) {
        echo '<tr class="border-bot">';
        for ($i = 0; $i < count($columns); $i++) {
            $x = $columns[$i];
            if($x == $colDate){
                $dateRes = $v->$x;
                $dateJ = date("d/m/Y", strtotime($dateRes));
                $dateH = date("H:i:s", strtotime($dateRes));
                echo '<td class="border-bot">' . $dateJ. ' - ' .$dateH.'</td>';
            }else{
                echo '<td class="border-bot">' . $v->$x . '</td>';
            }
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}