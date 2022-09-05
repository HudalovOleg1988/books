<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/book/css/global/reset.css">
    <link rel="stylesheet/less" href="/book/css/shot/header.less">
    <link rel="stylesheet/less" href="/book/css/shot/footer.less">
    <link rel="stylesheet/less" href="/book/css/shot/departments.less">
    <link rel="stylesheet/less" href="/book/css/order.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <title>Order</title>
  </head>
  <body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/header.php"; ?>
    <div class="order">
      <div class="order_cancel">
        <a href="#">Cancel</a>
      </div>
      <form class="form" action="" method="get">
        <div class="form_title">Order form</div>
        <input type="text" name="" value="" placeholder="Country, city, street, flat" class="form_input">
        <input type="text" name="" value="" placeholder="address@mail.com" class="form_input">
        <input type="text" name="" value="" placeholder="Youre name" class="form_input">
        <input type="text" name="" value="" placeholder="Phone number" class="form_input">
        <input type="submit" name="" value="Send order" class="form_input form_input_submit">
      </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/footer.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/departments.php"; ?>
    <script src="/book/js/js.js" ></script>
  </body>
</html>
