<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/book/css/global/reset.css">
    <link rel="stylesheet/less" href="/book/css/add_product.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <title>Order</title>
  </head>
  <body>
    <div class="order">

      <?php if ($ifChild): ?>

        <form class="form" action="?" method="post" enctype="multipart/form-data">
          <input type="hidden" name="add_product" value="">
          <input type="hidden" name="category" value="<?= $_GET['add_product'];?>">
          <input type="file" name="file[]" value="">
          <input type="file" name="file[]" value="">
          <input type="file" name="file[]" value="">
          <input type="file" name="file[]" value="">
          <input type="file" name="file[]" value="">
          <input type="text" name="name" value="" placeholder="Name" class="form_input">
          <input type="text" name="price" value="" placeholder="Price" class="form_input">
          <textarea name="description" rows="8" cols="80" placeholder="Description"></textarea>

          <?php foreach ($filters as $name=>$filter): ?>
            <?php if ($name != "author"): ?>
              <select class="" name="<?=$name;?>">
                <option value=""><?=$name;?></option>
                <?php foreach ($filter as $i): ?>
                  <option value="<?=$i[0];?>"><?=$i[1];?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          <?php endforeach; ?>

          <div class="checkboxing">
            <?php foreach ($filters['author'] as $i): ?>
              <div class="checkboxingItem">
                <input type="checkbox" name="author[]" value="<?=$i[0];?>" id="author<?=$i[0];?>">
                <label for="author<?=$i[0];?>"><?=$i[1];?></label>
              </div>
            <?php endforeach; ?>
          </div>

          <input type="submit" name="" value="Send order" class="form_input form_input_submit">
        </form>

      <?php else: ?>

        <div class="category">
          <h1>Categories</h1>
          <?php if (isset($_GET['current_category'])): ?>
            <a href="#" class="back">Back</a>
          <?php endif; ?>
          <ul>
            <?php foreach ($categories as $i): ?>
              <li><a href="?add_product=<?= $i['CategoryID'];?>"><?= $i['category'];?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

      <?php endif; ?>
    </div>
    <script src="/book/js/js.js" ></script>
  </body>
</html>
