<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/book/functions.php";

  if (isset($_COOKIE['user'])) {
    $user = $_COOKIE['user'];
  } else {
    $cookie = random_string(99);
    setcookie('user',"$cookie",time()+3600*24*365);
  }

  try
  {
    $pdo = new PDO('mysql:host=localhost;dbname=book','root','root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
  }
  catch (PDOException $e)
  {
    echo "невозможно подключиться к базе данных".$e->getMessage();
    exit();
  }

  if (isset($_GET['cart']))                           cart();
  else if (isset($_GET['selected_all_delete_check'])) selected_all_delete_check();
  else if (isset($_GET['selected_all_add_check']))    selected_all_add_check();
  else if (isset($_GET['cart_check_add']))            cart_check_add();
  else if (isset($_GET['cart_check_delete']))         cart_check_delete();
  else if (isset($_GET['count_plus']))                count_plus();
  else if (isset($_GET['count_minus']))               count_minus();
  else if (isset($_GET['product']))                   product();
  else if (isset($_GET['add_cart']))                  add_cart();
  else if (isset($_GET['delete_cart']))               delete_cart();
  else if (isset($_GET['add_product']))               add_product_page();
  else if (isset($_POST['add_product']))              add_product();
  else                                                main_page();

  include $_SERVER['DOCUMENT_ROOT'] . "/book/view/$pattern.php";

  // echo phpinfo();
  // display_errors
?>
