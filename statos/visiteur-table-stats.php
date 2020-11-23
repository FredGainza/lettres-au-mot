<!-- ############################################################### -->
<!-- START - SECTION TABLE VISITEUR -->
<!-- ############################################################### -->
<section class="user container-fluid">
  <?php 
      require('app-stats/function-table-bootstrap.php');

      $dbname = 'anagrammes;charset=UTF8';
      $host = 'localhost';
      $user = 'root';
      $pass = '';

      $table= 'visiteur';
      $limit_par_default = 25;
      $nb_autour = 5;
      $nb_par_page = [3, 5, 10, 25, 50, 100, 500]; 
      $columnsSelected = ['id', 'ip', 'pays', 'ville', 'language', 'width', 'height', 'error_code', 'date_connexion'];
      $colDate = 'date_connexion';
      $cols = null;

      tableBootstrap($dbname, $table, $limit_par_default, $nb_autour, $nb_par_page, $host, $user, $pass, $columnsSelected, $colDate, $cols);
  ?>

</section>
<!-- ############################################################### -->
<!-- END - SECTION TABLE VISITEUR -->
<!-- ############################################################### -->