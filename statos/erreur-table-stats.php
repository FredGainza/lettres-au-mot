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

      $table= 'erreur';
      $limit_par_default = 25;
      $nb_autour = 5;
      $nb_par_page = [3, 5, 10, 25, 50, 100, 500]; 
      $columnsSelected = ['id', 'referer', 'uri', 'code_erreur', 'visiteur_id', 'session_id', 'ip_visiteur', 'created_at'];
      $colDate = 'created_at';
      $cols = null;

      tableBootstrap($dbname, $table, $limit_par_default, $nb_autour, $nb_par_page, $host, $user, $pass, $columnsSelected, $colDate, $cols);
  ?>

</section>
<!-- ############################################################### -->
<!-- END - SECTION TABLE RECHERCHE -->
<!-- ############################################################### -->