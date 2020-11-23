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

      $table= 'message';
      $limit_par_default = 25;
      $nb_autour = 5;
      $nb_par_page = [3, 5, 10, 25, 50, 100, 500]; 
      $columnsSelected = ['id', 'nom', 'email', 'sujet', 'msg', 'visiteur_id', 'ip', 'date_envoi'];
      $colDate = 'date_envoi';
      $cols = null;

      tableBootstrap($dbname, $table, $limit_par_default, $nb_autour, $nb_par_page, $host, $user, $pass, $columnsSelected, $colDate, $cols);
  ?>

</section>
<!-- ############################################################### -->
<!-- END - SECTION TABLE RECHERCHE -->
<!-- ############################################################### -->