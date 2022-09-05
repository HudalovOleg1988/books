<?php

  function product(){
    get_product();
    cart_count();
  }

  function main_page(){
    get_filter();
    catalog();
    get_parent_category();
    cart_count();
    pattern_include("catalog");
  }

  function cart(){
    get_product_cart_list();
    pattern_include("cart");
  }


  function html($text)
  {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }

  function htmlout($text)
  {
    echo html($text);
  }











  //распаковка
  function fetchAll($sql)
  {
    global $pdo;
    $result = $pdo->query($sql);
    return $result->fetchAll();
  }











  //распаковка
  function fetch($sql)
  {
    global $pdo;
    $result = $pdo->query($sql);
    return $result->fetch();
  }











  //внесение нужного значения в переменную для подключение соответствующего паттерна html
  function pattern_include($file)
  {
    global $pattern;
    $pattern = $file;
  }











  //изъятие всех филтров
  function get_filter()
  {
    global $filters;
    $filters['publisher']    = fetchAll("SELECT * FROM Publisher");
    $filters['author']       = fetchAll("SELECT * FROM Author");
    $filters['covertype']    = fetchAll("SELECT * FROM Covertype");
    $filters['language']     = fetchAll("SELECT * FROM Language");
    $filters['age']          = fetchAll("SELECT * FROM Age");
    $filters['mediaformat']  = fetchAll("SELECT * FROM Mediaformat");
  }










  //функция запроса родительских категорий
  function get_parent_category() {
    GLOBAL $parent_category;
    $parent_category = fetchAll("SELECT * FROM Category WHERE degree = '1'");
  }










  //добавдение товара
  function add_product_page()
  {
    global $ifChild;

    get_category();

    if ($ifChild) {
      get_filter();
    }

    pattern_include("add_product");
  }











  //случайный набо символов
  function random_string($n)
  {
    $symbol = array(
      'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m',
      '1','2','3','4','5','6','7','8','9','0');
    $string = "";
    for ($i=0; $i < $n; $i++)
    {
      $index = rand(0, count($symbol)-1);
      $string .= $symbol[$index];
    }
    return $string;
  }











  //добавление товара
  function add_product()
  {
    global $pdo;

    $name         = $_POST['name'];
    $price        = $_POST['price'];
    $description  = $_POST['description'];
    $description  = htmlspecialchars($description);
    $publisher    = $_POST['publisher'];
    $covertype    = $_POST['covertype'];
    $language     = $_POST['language'];
    $age          = $_POST['age'];
    $mediaformat  = $_POST['mediaformat'];
    $author       = $_POST['author'];
    $category     = $_POST['category'];

    $s = $pdo->prepare("INSERT INTO Book SET name=:name,price=:price,description=:description");
    $s->bindValue(":name", $name);
    $s->bindValue(":price", $price);
    $s->bindValue(":description", $description);
    $s->execute();

    $id = $pdo->lastInsertId();

    $pdo->query("INSERT INTO Book_category SET Book='$id',Category='$category'");
    $pdo->query("INSERT INTO Book_Publisher SET Book='$id',Publisher='$publisher'");
    $pdo->query("INSERT INTO Book_Covertype SET Book='$id',Covertype='$covertype'");
    $pdo->query("INSERT INTO Book_Language SET Book='$id',Language='$language'");
    $pdo->query("INSERT INTO Book_Age SET Book='$id',Age='$age'");
    $pdo->query("INSERT INTO Book_Mediaformat SET Book='$id',Mediaformat='$mediaformat'");

    foreach ($author as $i)
      $pdo->query("INSERT INTO Book_Author SET Book='$id',Author='$i'");

    for ($i=0; $i < COUNT($_FILES['file']['tmp_name']); $i++)
    {
      if ($_FILES['file']['tmp_name'][$i] != "")
      {
        $file = $_FILES['file']['tmp_name'][$i];
        $unique = rand(1000000000,1999999999).random_string(101).".jpg";
        $link = $_SERVER['DOCUMENT_ROOT'].'/book/image/'.$unique;
        move_uploaded_file($file,$link);
        $pdo->query("INSERT INTO Image SET Image='$unique',Book='$id'");
      }
    }
  }











  //запрос категорий для добавления товара
  function get_category()
  {
    global $categories;
    global $currentCategory;
    global $ifChild;

    if ($_GET['add_product'] != "") {
      $requestId  = $_GET['add_product'];
      $currentCategory  = fetch("SELECT * FROM Category WHERE CategoryID = '$requestId'");
      $degree           = $currentCategory['degree'] + 1;
      $id               = $currentCategory['CategoryID'];
      $sql              = "SELECT * FROM Category INNER JOIN Category_tree ON CategoryID = Child
                           WHERE Category_tree.Category = '$id' AND degree = '$degree'";
      $categories = fetchAll("SELECT * FROM Category
                              INNER JOIN Category_tree ON CategoryID = Child
                              WHERE Category_tree.Category = '$id' AND degree = '$degree'");

      if (COUNT($categories) == 0) {
        $ifChild = true;
      } else {
        $ifChild = false;
      }
    } else {
      $categories = fetchAll("SELECT * FROM Category WHERE degree = '1'");
    }
  }











  //изъятие всех товаров для главной страницы
  function catalog()
  {
    GLOBAL $books, $currentCategoryCatalog;

    $sql = "SELECT * FROM Book ";
    $where = " WHERE TRUE ";
    $inner = " ";

    if (isset($_GET['category'])&& $_GET['category'] != "")
    {
      $categoryId = $_GET['category'];

      get_child_category();


      $currentCategoryCatalog = fetch("SELECT * FROM Category WHERE CategoryID = '$categoryId'");

      $sqlCategory = "SELECT CategoryID FROM Category INNER JOIN Category_tree ON
                      Category.CategoryID = Category_tree.Child
                      WHERE Category_tree.Category = '$categoryId'";
      $childCategory = fetchAll($sqlCategory);

      if (!empty($childCategory))
      {
        $in = "";
        foreach ($childCategory as $i)
          $in .= $i['CategoryID'] . ",";

        $in = substr($in,0,-1);
        $diapazon = "IN($in)";
      }
      else
        $diapazon = " = ".$_GET['category'];

      $inner .= " INNER JOIN Book_Category ON BookID = Book_Category.Book";
      $where .= " AND Book_Category.Category " . $diapazon;
    }


    $filters = array(
      "mediaformat" => "Mediaformat",
      "age"         => "Age",
      "language"    => "Language",
      "covertype"   => "Covertype",
      "publisher"   => "Publisher",
      "author"      => "Author"
    );

    if (isset($_GET['filters'])) {
      foreach ($filters as $name => $table) {
        if (!empty($_GET[$name]))
        {
          $in = "";
          $inner .= " INNER JOIN  Book_$table ON BookID = Book_$table.Book ";
          foreach ($_GET[$name] as $i) $in .= "$i,";
          $in = substr($in,0,-1);
          $where .=  " AND Book_$table.$table" . " IN($in)";
        }
      }
    }

      $min = 0;
      $max = 1000000000;

      if (isset($_GET['min']) && $_GET['min'] != "") {
        $min = $_GET['min'];
      }
      if (isset($_GET['max']) && $_GET['max'] != "") {
        $max = $_GET['max'];
      }
      $where .= " AND price  BETWEEN $min AND $max";

      if (isset($_GET['search_book']) && $_GET['search_book'] != "") {
        $bookName = $_GET['search_book'];
        $where .= " AND Book.name LIKE '%$bookName%'";
      }

      if (isset($_GET['search_book']) && $_GET['search_book'] == "") {
        header("Location: /book/");
      }


    $sql .= $inner . $where;
    $books = fetchAll($sql);

    for ($i=0; $i < COUNT($books); $i++)
    {
      $id = $books[$i]['BookID'];
      $books[$i]['images'] = fetchAll("SELECT * FROM Image WHERE Book = '$id'");
    }

    for ($i=0; $i < COUNT($books); $i++) {
      $id = $books[$i]['BookID'];
      $books[$i]['author'] = fetchAll("SELECT * FROM Author INNER JOIN book_author ON AuthorID = book_author.Author WHERE Book = '$id'");
    }
  }










  // запрос дрчерних категорий при запросе товаров по категории
    function get_child_category()
    {
      GLOBAL $childCategories, $currentCategoryCatalog;

      $categoryChild = $_GET['category'];

      $currentCategoryCatalog = fetch("SELECT * FROM Category WHERE CategoryID = '$categoryChild'");
      $degree = $currentCategoryCatalog['degree'] + 1;
      $id = $currentCategoryCatalog['CategoryID'];
      $sql = "SELECT CategoryID, Category.category, Category.degree FROM Category
              INNER JOIN Category_tree ON CategoryID = Category_tree.Child
              WHERE Category_tree.Category = '$id'
              AND Category.degree = '$degree'";
      $childCategories = fetchAll($sql);

      return $childCategories;
    }









    // запрос информации о товаре
    function get_product() {
      GLOBAL $book, $images, $publisher, $author, $type, $age, $format;

      if ($_GET['product'] != "") {
        $id = $_GET['product'];

        $book       = fetch("SELECT * FROM Book WHERE BookID = $id");
        $images     = fetchAll("SELECT * FROM Image WHERE Book = $id");

        if (empty($book)) {
          header("Location: /book/");
        }
        $publisher  = fetch("SELECT Publisher.publisher FROM Publisher INNER JOIN Book_Publisher ON PublisherID = Book_Publisher.Publisher WHERE Book = $id");
        $author     = fetchAll("SELECT Author.author FROM Author INNER JOIN Book_Author ON AuthorID = Book_Author.Author WHERE Book = $id");
        $type       = fetch("SELECT Covertype.covertype FROM Covertype INNER JOIN Book_Covertype ON CovertypeID = Book_Covertype.Covertype WHERE Book = $id");
        $age        = fetch("SELECT Age.age FROM Age INNER JOIN Book_Age ON AgeID = Book_Age.Age WHERE Book = $id");
        $format     = fetch("SELECT Mediaformat.mediaformat FROM Mediaformat INNER JOIN Book_Mediaformat ON MediaformatID = Book_Mediaformat.Mediaformat WHERE Book = $id");

      }

      pattern_include("product");
    }








    //колличество товаров в корзине
    function cart_count() {
      GLOBAL $cart_count, $pdo;
      // $cart_count = array();
      $user = $_COOKIE['user'];

      $result = fetchAll("SELECT Book FROM Cart_Cookie WHERE cookie = '$user'");

      foreach ($result as $i) {
        $cart_count[] = $i['Book'];
      }
    }










    //функция добавления товара в корзину
    function add_cart() {
      global $pdo;

      if ($_GET['add_cart'] == "") {
        header("Location: /book/");
        exit;
      }

      $id = $_GET['add_cart'];
      $user = $_COOKIE['user'];

      $pdo->query("INSERT INTO Cart_Cookie SET cookie='$user', Book='$id', count='1', checked='0'");

      header("Location: /book/?product=$id");
      exit;
    }










    //функция удаления из карты
    function delete_cart() {
      global $pdo;

      if ($_GET['delete_cart'] == "") {
        header("Location: /book/");
        exit;
      }

      $id = $_GET['delete_cart'];
      $user = $_COOKIE['user'];

      $pdo->query("DELETE FROM Cart_Cookie WHERE cookie='$user' and Book='$id'");

      header("Location: /book/?product=$id");
      exit;
    }











    //функция запроса товаров для корзины
    function get_product_cart_list() {
      global $cartList, $cart_count, $user, $total_sum, $count_check, $check_sum;
      cart_count();

      foreach ($cart_count as $i)
      {
        $sql = "SELECT Book.BookID, Book.name, Book.price, Cart_Cookie.count, Cart_Cookie.checked, Category.category
                FROM Book
                INNER JOIN Cart_Cookie ON BookID = Cart_Cookie.Book
                INNER JOIN Book_Category ON Book_Category.Book = Book.BookID
                INNER JOIN Category ON Book_Category.Category = Category.CategoryID
                WHERE BookID = $i AND cookie = '$user'";
        $cartList[] = fetch($sql);
      }

      for ($i=0; $i < COUNT($cartList); $i++)
      {
        $id = $cartList[$i]['BookID'];
        $cartList[$i]['image'] = fetch("SELECT image FROM Image WHERE Book = $id LIMIT 1");

        $total_sum = $total_sum + ($cartList[$i]['price']*$cartList[$i]['count']);

        if ($cartList[$i]['checked'] == 1)
        {
          $count_check = $count_check + 1;
          $check_sum = $check_sum + ($cartList[$i]['price']*$cartList[$i]['count']);
        }
      }
    }














    //фугкция выбора товара в корзине
    function cart_check_add()
    {
      global $pdo;

      if ($_GET['cart_check_add'] == 0)
      {
        header("Location: /book/");
        exit;
      }

      $user = $_COOKIE['user'];
      $id = $_GET['cart_check_add'];

      $pdo->query("UPDATE Cart_Cookie SET checked = 1 WHERE Book = '$id' AND cookie = '$user'");

      header("Location: /book/?cart");
      exit;
    }













    //фугкция снятия галочки товара в корзине
    function cart_check_delete()
    {
      global $pdo;

      if ($_GET['cart_check_delete'] == "")
      {
        header("Location: /book/");
        exit;
      }

      $user = $_COOKIE['user'];
      $id = $_GET['cart_check_delete'];

      $pdo->query("UPDATE Cart_Cookie SET checked = 0 WHERE Book = '$id' AND cookie = '$user'");

      header("Location: /book/?cart");
      exit;
    }














    //функция увеличения колличества товаров в корзине
    function count_plus()
    {
      global $pdo;
      if ($_GET['count_plus'] == "")
      {
        header("Location: /book/");
        exit;
      }

      $user = $_COOKIE['user'];
      $id = $_GET['count_plus'];

      $count = fetch("SELECT count from Cart_Cookie WHERE Book = '$id' AND cookie = '$user'");

      if ($count['count'] < 5)
      {
        $pdo->query("UPDATE Cart_Cookie SET count = count+1 WHERE Book = '$id' AND cookie = '$user'");
      }


      header("Location: /book/?cart");
      exit;
    }











    //функция уменьшения колличества товаров в корзине
    function count_minus()
    {
      global $pdo;
      if ($_GET['count_minus'] == "")
      {
        header("Location: /book/");
        exit;
      }

      $user = $_COOKIE['user'];
      $id = $_GET['count_minus'];

      $count = fetch("SELECT count from Cart_Cookie WHERE Book = '$id' AND cookie = '$user'");

      if ($count['count'] > 1)
      {
        $pdo->query("UPDATE Cart_Cookie SET count = count-1 WHERE Book = '$id' AND cookie = '$user'");
      }

      header("Location: /book/?cart");
      exit;
    }








    //функция выделения всех товаров в корзине
    function selected_all_delete_check()
    {
      global $pdo;

      $user = $_COOKIE['user'];

      $pdo->query("UPDATE Cart_Cookie SET checked = 0 WHERE cookie = '$user'");

      header("Location: /book/?cart");
      exit;
    }













    //функция удаления выления всех товаров в корзине
    function selected_all_add_check()
    {
      global $pdo;

      $user = $_COOKIE['user'];

      $pdo->query("UPDATE Cart_Cookie SET checked = 1 WHERE cookie = '$user'");

      header("Location: /book/?cart");
      exit;
    }



?>
