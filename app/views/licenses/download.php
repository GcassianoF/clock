<?/** @author Giceu Cassiano **/?>
<?
      auth("yes");
      $licenses_controller = new Licenses_Controller();
      $licenses_controller->download(@$params[0]);

      header('location:'.$_SERVER['HTTP_REFERER']);
?>
