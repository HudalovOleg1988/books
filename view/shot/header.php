<header>
  <div class="departmentsButton" id="departmentsButton" onclick="openDepartments()"></div>
  <a href="?" class="logo"></a>
  <form action="" method="get" id="searchHeaderForm">
    <div class="searchFormSelect" id="searchFormSelect" onclick="openSelectHeader()">
      <?php
        if (isset($_GET['search_book']) && $_GET['category'] != '') {
          echo $currentCategoryCatalog['category'];
        } else {
          echo "All";
        }
      ?>
      <span></span>
    </div>
    <div class="searchFormSelectBoard" id="searchFormSelectBoard" onclick="openSelectHeader()"> <span></span></div>
    <input type="text" name="search_book" value="<?php if(isset($_GET['search_book'])) echo $_GET['search_book'];?>" placeholder="Search books">
    <input type="submit" name="" value="Search">
    <input type="hidden" name="category" value="" id="search_category">
    <!-- <input type="hidden" name="search_category" value=""> -->
  </form>

  <a href="?cart" class="header_cart">
    <div>
      <?=COUNT($cart_count);?>
    </div>
  </a>

</header>

<div class="form_option_block" id="form_option_block" onclick="closeSelectHeader()">
  <div class="form_option_block_close" id="form_option_block_close">

  </div>
  <div class="form_option_block_list">
    <div class="form_option_block_list_item" onclick="clickHeaderSearchSelect(event)">All</div>
    <?php foreach ($parent_category as $i): ?>
      <div class="form_option_block_list_item" -data-category="<?= $i['CategoryID']; ?>" onclick="clickHeaderSearchSelect(event)"><?= $i['category']; ?></div>
    <?php endforeach; ?>
  </div>
</div>
