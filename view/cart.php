<?php
  // $cartList = array(
  //   array("img"=>"1.jpg","name"=>"Where the Crawdads Sing","category"=>"Educational","price"=>"1900","count"=>"1"),
  //   array("img"=>"2.jpg","name"=>"Reminders of Him: A Novel","category"=>"Ancient literature","price"=>"950","count"=>"2"),
  //   array("img"=>"3.jpg","name"=>"Энциклопедия DC Comics | Нет автора","category"=>"Sentimental prose","price"=>"2250","count"=>"3"),
  //   array("img"=>"4.jpg","name"=>"Beauty and the Baller","category"=>"Adventures","price"=>"4500","count"=>"1"),
  //   array("img"=>"5.jpg","name"=>"The Last Eligible Billion","category"=>"Detectives","price"=>"3500","count"=>"2")
  // );
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/book/css/global/reset.css">
    <link rel="stylesheet/less" href="/book/css/shot/header.less">
    <link rel="stylesheet/less" href="/book/css/shot/footer.less">
    <link rel="stylesheet/less" href="/book/css/shot/departments.less">
    <link rel="stylesheet/less" href="/book/css/cart.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <title>Catalog</title>
  </head>
  <body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/header.php"; ?>
    <div class="cart" id="cart">
      <div class="cart_list">
        <div class="cart_list_title"><span>Cart</span><span>Total items in the basket</span><span><?=COUNT($cart_count);?></span></div>
        <div class="cart_list_select">
          <div>
            <span class="cart_list_select_check" id="cart_list_select_check" onclick="selectAllProduct(event)" <?php if(count($cartList) != $count_check) echo "style='display:block'"; ?>><a href="?selected_all_add_check"></a></span>
            <span class="cart_list_select_checked" id="cart_list_select_check_remove" onclick="removeselectAllProduct(event)" <?php if(count($cartList) == $count_check) echo "style='display:block'"; ?>><a href="?selected_all_delete_check"></a></span>
          </div>
          <div>Select all items</div>
          <div>13100</div>
        </div>
        <div class="cart_list_goods">

          <?php foreach ($cartList as $i): ?>
            <div class="cart_list_goods_item">
              <div class="cart_list_goods_item_check">

                <a href="?cart_check_add=<?=$i['BookID'];?>" class="cart_list_goods_item_check_checkbox" onclick="selectProduct(event)" data-checkbox="checkbox" <?php if($i['checked'] == 0) echo "style='display:block'"; ?>></a>
                <a href="?cart_check_delete=<?=$i['BookID'];?>" class="cart_list_goods_item_check_checkbox_checked" onclick="selectProduct(event)" data-checkbox="checked" <?php if($i['checked'] == 0) echo "style='display:none'"; ?>></a>

              </div>
              <div class="cart_list_goods_item_image"><img src="/book/image/<?=$i['image']['image'];?>" alt=""></div>
              <div class="cart_list_goods_item_info">
                <div class="cart_list_goods_item_info_category_dlete"><span><?=$i['category'];?></span><a href="#">Delete</a></div>
                <div class="cart_list_goods_item_info_name"><?=$i['name'];?></div>
                <div class="cart_list_goods_item_info_price"><span class="cart_list_goods_item_info_price_number"><?=$i['price'];?></span></div>
              </div>
              <div class="cart_list_goods_item_count">
                <div class="cart_list_goods_item_count_form">
                  <div class="cart_list_goods_item_count_form_minus" onclick="changeCount(event)"><a href="?count_minus=<?=$i['BookID'];?>"></a></div>
                  <div class="cart_list_goods_item_count_form_count"><?=$i['count'];?></div>
                  <div class="cart_list_goods_item_count_form_plus" onclick="changeCount(event)"><a href="?count_plus=<?=$i['BookID'];?>"></a></div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>
      <div class="cart_check">
        <div class="cart_check_price">
          <div class="cart_check_price_count"><span>Youre cart</span><span id="cart_check_price_count_number"><?=COUNT($cart_count);?></span></div>
          <div class="cart_check_price_total_price"><span>Total price</span><span id="cart_check_price_total_price_number"><?=$total_sum;?></span></div>
          <div class="cart_check_price_checked_price"><span>Checked price</span><span id="cart_check_price_checked_price_number"><?php if($check_sum) echo $check_sum; ?></span></div>
          <div class="cart_check_price_order_button">Make an order</div>
        </div>
      </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/footer.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/departments.php"; ?>
    <script src="/book/js/js.js" ></script>
  </body>
</html>
