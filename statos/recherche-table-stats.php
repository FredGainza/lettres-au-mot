<!-- ############################################################### -->
<!-- START - SECTION TABLE RECHERCHE -->
<!-- ############################################################### -->
<section class="user container-fluid">
  <?php 
      require('app-stats/function-table-bootstrap.php');
      $dbname = 'anagrammes;charset=UTF8';
      $host = 'localhost';
      $user = 'root';
      $pass = '';

      $table= 'recherche';
      $limit_par_default = 25;
      $nb_autour = 5;
      $nb_par_page = [3, 5, 10, 25, 50, 100, 500]; 
      $columnsSelected = ['id', 'visiteur_id', 'mot', 'maxpo', 'nb_car_final', 'ip', 'date_realisation'];
      $colDate = 'date_realisation';
      $cols = null;

      tableBootstrap($dbname, $table, $limit_par_default, $nb_autour, $nb_par_page, $host, $user, $pass, $columnsSelected, $colDate, $cols);
  ?>

</section>
<!-- ############################################################### -->
<!-- END - SECTION TABLE RECHERCHE -->
<!-- ############################################################### -->