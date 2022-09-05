<?php
  // $filter = array(
  //   "Publishing house" => array("1"=>"Altani","2"=>"AMEX Ltd","3"=>"Aspect Press Ltd.","4"=>"Ballantine Books","5"=>"Bubble","6"=>"Clever","7"=>"Concordia","8"=>"AMEX Ltd"),
  //   "Cover" => array("9"=>"Paperback","10"=>"Hardcover"),
  //   "Format" => array("11"=>"Printed book","12"=>"Audiobook","13"=>"Electronic format"),
  //   "Authors" => array("14"=>"Tieghan Gerard","15"=>"Adam Wallace","16"=>"Margaret Atwood.","17"=>"Delia Owens","18"=>"Shannon Bream","19"=>"James Clear","20"=>"Dolly Parton","21"=>"Delia Owens"),
  //   "Age" => array("22"=>"6+","23"=>"12+","24"=>"16+","25"=>"18+"),
  //   "Languages" => array("26"=>"Russian","27"=>"English")
  // );

  // $books = array(
  //   array("author"=>"Tieghan Gerard","name"=>"Where the Crawdads Sing","price"=>"2250", "image"=>"1"),
  //   array("author"=>"Margaret Atwood","name"=>"Reminders of Him: A Novel","price"=>"950", "image"=>"2"),
  //   array("author"=>"Delia Owens","name"=>"Beauty and the Baller","price"=>"4500", "image"=>"3"),
  //   array("author"=>"Adam Wallace","name"=>"The Last Eligible Billion","price"=>"3500", "image"=>"4"),
  //   array("author"=>"Tieghan Gerard","name"=>"Энциклопедия DC Comics | Нет автора","price"=>"3500", "image"=>"5"),
  //   array("author"=>"Margaret Atwood","name"=>"Реализация методов предметно-ориентиро","price"=>"2250", "image"=>"6"),
  //   array("author"=>"Delia Owens","name"=>"Мятежная королева | Нони Линетт","price"=>"950", "image"=>"7"),
  //   array("author"=>"Adam Wallace","name"=>"Благословение небожителей. Том 1","price"=>"4500", "image"=>"8"),
  //   array("author"=>"Tieghan Gerard","name"=>"Ночная смена | Поляринов Алексей В","price"=>"1500", "image"=>"9"),
  //   array("author"=>"Margaret Atwood","name"=>"Братья Карамазовы | Достоевский Федор ","price"=>"2250", "image"=>"10"),
  //   array("author"=>"Delia Owens","name"=>"Бессердечная | Мейер Марисса","price"=>"950", "image"=>"11"),
  //   array("author"=>"Adam Wallace","name"=>"Сезон отравленных плодов | Богданова Ве","price"=>"4500", "image"=>"12"),
  //   array("author"=>"Tieghan Gerard","name"=>"HTML5 + CSS3. Основы современного WEB-диза","price"=>"1500", "image"=>"13"),
  //   array("author"=>"Margaret Atwood","name"=>"JavaScript и jQuery. Исчерпывающее руково","price"=>"2 250", "image"=>"14"),
  //   array("author"=>"Delia Owens","name"=>"SQL за 10 минут, 5-е издание","price"=>"950", "image"=>"15"),
  //   array("author"=>"Adam Wallace","name"=>"Изучаем Java | Сьерра Кэти, Бэйтс Берт","price"=>"4500", "image"=>"16")
  // );
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/book/css/global/reset.css">
    <link rel="stylesheet/less" href="/book/css/shot/header.less">
    <link rel="stylesheet/less" media="(max-device-width: 800px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="/book/css/shot/header_board.less">
    <link rel="stylesheet/less" href="/book/css/shot/footer.less">
    <link rel="stylesheet/less" media="(max-device-width: 800px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="/book/css/shot/footer_board.less">
    <link rel="stylesheet/less" href="/book/css/shot/departments.less">
    <link rel="stylesheet/less" media="(max-device-width: 800px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="/book/css/shot/departments_board.less">
    <link rel="stylesheet/less" href="/book/css/catalog.less">
    <link rel="stylesheet/less" media="(max-device-width: 800px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="/book/css/catalog_board.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <script src="/book/js/js.js" ></script>
    <title>Catalog</title>
  </head>
  <body>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/header.php"; ?>

      <div class="main">
          <!-- sitebar -->
          <div class="siteBarNav">

              <?php if (!empty($childCategories)): ?>
                <ul class="siteBarNavCategory">
                  <div class="siteBarNavCategoryTitle"><?= $currentCategoryCatalog['category']; ?></div>
                  <?php foreach ($childCategories as $i): ?>
                    <li><a href="?category=<?= $i['CategoryID']; ?>"><?= $i['category']; ?><a></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

            <form class="filter" action="" method="get">
              <?php if (isset($_GET['category'])): ?>
                <input type="hidden" name="category" value="<?= $_GET['category']; ?>">
              <?php endif; ?>
              <input type="hidden" name="filters" value="">

              <div class="filterPrice">
                <div class="filterHeader">Price</div>
                <div class="filterPriceContent">
                  <input type="text" name="min" value="<?php if(isset($_GET['filters'])) echo $_GET['min']; ?>" placeholder="Min">
                  <input type="text" name="max" value="<?php if(isset($_GET['filters'])) echo $_GET['max']; ?>" placeholder="Max">
                  <input type="submit" name="" value="Go">
                </div>
              </div>

              <?php foreach ($filters as $i => $y): ?>
                <div class="filterCheckbox">
                  <div class="filterHeader"><?= $i; ?></div>
                  <div class="filterCheckboxContent">
                    <?php foreach ($y as $z): ?>
                      <div class="filterCheckboxContentItem">
                        <input type="checkbox" name="<?= $i; ?>[]" value="<?= $z[0]; ?>" onclick="checkboxClick(event)"
                        <?php
                          if (isset($_GET['filters']) && !empty($_GET[$i]) && in_array($z[0],$_GET[$i]))
                          {
                            echo " checked class='filterFormContentItemCheck'";
                          }
                        ?>
                        >
                        <label for="" onclick="labelClick(event)"><?= $z[1]; ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <input type="submit" name="" value="Go">
                </div>
              <?php endforeach; ?>

            </form>

          </div>
        <!-- sitebar -->

        <!-- product -->
        <div class="mainContent">
          <?php if (!empty($books)): ?>
            <?php foreach ($books as $i): ?>
              <a href="?product=<?=$i['BookID'];?>">
                <div class="product">
                  <div class="productImage">
                    <img src="/book/image/<?=$i['images'][0]['image'];?>" alt="">
                  </div>
                  <div class="productInfo">
                    <div class="productAuthor"><?=$i['author'][0]['author'];?></div>
                    <div class="productName"><?=$i['name'];?></div>
                    <div class="productPrice"><span><?=$i['price'];?></span><span></span></div>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <!-- product -->

      <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/footer.php"; ?>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/book/view/shot/departments.php"; ?>
  </body>
</html>
