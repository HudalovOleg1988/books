<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/book/css/global/reset.css">
    <link rel="stylesheet/less" href="/book/css/shot/header.less">
    <link rel="stylesheet/less" href="/book/css/shot/footer.less">
    <link rel="stylesheet/less" href="/book/css/shot/departments.less">
    <link rel="stylesheet/less" href="/book/css/product.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <title>Catalog</title>
  </head>
  <body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/header.php"; ?>
    <div class="main">
      <div class="main_map">
        <div>Main</div> <span></span>
        <div>Artistic literature</div> <span></span>
        <div><a href="">Fighters</a></div> <span></span>
        <div>Sentimental prose</div> <span></span>
      </div>
      <div class="main_name">
        The Last Eligible Billionaire
      </div>
      <div class="main_product">
        <div class="main_product_info">
          <?php if (!empty($cart_count) && in_array($book['BookID'],$cart_count)): ?>
            <a href="?delete_cart=<?=$book['BookID'];?>" class="delete_cart">Delete from cart</a>
          <?php else: ?>
            <a href="?add_cart=<?=$book['BookID'];?>">
              <div class="main_product_info_add_cart" onclick="add_to_cart()"><div><span>Add to cart</span></div><div><span>1750</span></div></div>
            </a>
          <?php endif; ?>

          <ul class="main_product_info_specifications">
            <li><div>Publisher</div><div><?=$publisher['publisher'];?></div></li>
            <?php foreach ($author as $i): ?>
              <li><div>Author</div><div><?=$i['author'];?></div></li>
            <?php endforeach; ?>
            <li><div>Type</div><div><?=$type['covertype'];?></div></li>
            <li><div>Age</div><div><?=$age['age'];?></div></li>
            <li><div>Format cover</div><div><?=$format['mediaformat'];?></div></li>
          </ul>


          <div class="main_product_info_descriptions">
            <div class="main_product_info_descriptions_header">Description</div>
            <div class="main_product_info_descriptions_text">
              <?=$book['description'];?>
              <!-- JavaScript — ключевой инструмент создания современных сайтов, и благодаря данному руководству, ориентированному на новичков, вы сможете изучить язык в короткие сроки и с минимумом усилий. Узнайте, какова структура языка, как правильно записывать его инструкции, как применять CSS, работать с онлайн-графикой и подключать -->
            </div>
          </div>
        </div>
        <div class="main_product_gallery">
          <div class="main_product_gallery_big_mini_image">
            <div class="main_product_gallery_big_mini_image_img"><img src="/book/image/9.jpg" alt="" class="main_product_gallery_big_mini_image_img_img_height"></div>
            <div class="main_product_gallery_big_mini_image_img"><img src="/book/image/17.jpg" alt="" class="main_product_gallery_big_mini_image_img_img_height"></div>
            <div class="main_product_gallery_big_mini_image_img"><img src="/book/image/18.jpg" alt="" class="main_product_gallery_big_mini_image_img_img_height"></div>
            <div class="main_product_gallery_big_mini_image_img"><img src="/book/image/19.jpg" alt="" class="main_product_gallery_big_mini_image_img_img_height"></div>
            <div class="main_product_gallery_big_mini_image_img"><img src="/book/image/20.jpg" alt="" class="main_product_gallery_big_mini_image_img_img_height"></div>
          </div>
          <div class="main_product_gallery_big_image"><img src="/book/image/<?=$images[0]['image'];?>" alt="" class="main_product_gallery_big_image_img_height"></div>
        </div>
      </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/footer.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/departments.php"; ?>
    <script src="/book/js/js.js" ></script>
  </body>
</html>
