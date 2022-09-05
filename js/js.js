//открытие длока меню
// changeCount
function openDepartments()
{
  let departmentsBlock = document.getElementById("departmentsBlock");
  let siteBar = document.getElementById("departmentsBlockSiteBar");
  departmentsBlock.style.display="block";
  departmentsBlock.classList.add("departmentsBlockShow");
  departmentsBlock.classList.remove("departmentsBlockHide");
  siteBar.classList.remove("departmentsBlockSiteBarHide");
  siteBar.classList.add("departmentsBlockSiteBarShow");
}





//открытие подменю
function openSubDepartments(e)
{
  let contentDepartments = document.getElementById('departmentsBlockSiteBarContentDepartments');
  let id = "departmentsBlockSiteBarContentSubDepartments-"+e.target.getAttribute("-data-submenu");
  contentDepartments.classList.add("departmentsBlockSiteBarContentDepartmentsHide");
  contentDepartments.classList.remove("departmentsBlockSiteBarContentDepartmentsShow");
  document.getElementById(id).classList.add("departmentsBlockSiteBarContentSubDepartmentsShow");
  document.getElementById(id).classList.remove("departmentsBlockSiteBarContentSubDepartmentsHide");
}





//закрытие блока меню
function closeSubDepartments()
{
  let departmentsBlock = document.getElementById("departmentsBlock");
  let siteBar = document.getElementById("departmentsBlockSiteBar");
  departmentsBlock.classList.add("departmentsBlockHide");
  departmentsBlock.classList.remove("departmentsBlockShow");
  siteBar.classList.add("departmentsBlockSiteBarHide");
  siteBar.classList.remove("departmentsBlockSiteBarShow");
  setTimeout(displayNoneDepartmentsBlock, 400);
}
function displayNoneDepartmentsBlock() {
  document.getElementById("departmentsBlock").style.display="none";
  document.getElementById('departmentsBlockSiteBarContentDepartments').classList.remove("departmentsBlockSiteBarContentDepartmentsHide");
  let submenu = document.getElementsByClassName("departmentsBlockSiteBarContentSubDepartments");
  for (var i = 0; i < submenu.length; i++) submenu[i].classList.remove("departmentsBlockSiteBarContentSubDepartmentsShow");
}





//возврат в родительское меню
function backDepartments(e)
{
  let departmentsList = document.getElementById('departmentsBlockSiteBarContentDepartments');
  e.target.parentElement.classList.add("departmentsBlockSiteBarContentSubDepartmentsHide");
  e.target.parentElement.classList.remove("departmentsBlockSiteBarContentSubDepartmentsShow");
  departmentsList.classList.add("departmentsBlockSiteBarContentDepartmentsShow");
  departmentsList.classList.remove("departmentsBlockSiteBarContentDepartmentsHide");
}





//клик чекбокс фильтров
function checkboxClick(e)
{
  e.target.classList.toggle("filterFormContentItemCheck");
}





//клик label фильтров
function labelClick(e)
{
  e.target.previousElementSibling.click();
}





//открытие select header
function openSelectHeader()
{
  document.getElementById("form_option_block").style.display="block";
}





//закрытие select header
function closeSelectHeader()
{
  document.getElementById("form_option_block").style.display="none";
}





//клик option select header
function clickHeaderSearchSelect(e)
{
  document.getElementById("searchFormSelect").innerHTML="";
  document.getElementById("searchFormSelect").innerHTML=e.target.innerHTML+"<span></span>";
  document.getElementById("searchHeaderForm").style.paddingLeft = document.getElementById("searchFormSelect").offsetWidth+"px";
  document.getElementById("form_option_block").style.display="none";

  document.getElementById("search_category").value = e.target.getAttribute("-data-category");
}





//проверка ширины select option search form header
document.addEventListener("load", () => {
  document.getElementById("searchHeaderForm").style.paddingLeft = document.getElementById("searchFormSelect").offsetWidth + "px";
},"false");





//выбрать все товары
function selectAllProduct(e) {
  let price = 0;
  let count = 0;
  let totalPrice = 0;

  document.getElementById("cart_list_select_check").style.display = "none";
  document.getElementById("cart_list_select_check_remove").style.display = "block";

  let goods = document.getElementsByClassName("cart_list_goods_item");

  for (var i = 0; i < goods.length; i++)
  {
    goods[i].querySelector(".cart_list_goods_item_check_checkbox").style.display = "none";
    goods[i].querySelector(".cart_list_goods_item_check_checkbox_checked").style.display = "block";

    count = goods[i].querySelector(".cart_list_goods_item_count_form_count").innerHTML;
    price = goods[i].querySelector(".cart_list_goods_item_info_price_number").innerHTML;

    totalPrice = totalPrice + (count * price);
  }

  document.getElementById("cart_check_price_checked_price_number").innerHTML = totalPrice;
}





//отменить выбор всех товаров
function removeselectAllProduct() {
  document.getElementById("cart_list_select_check").style.display = "block";
  document.getElementById("cart_list_select_check_remove").style.display = "none";

  let goods = document.getElementsByClassName("cart_list_goods_item");

  for (var i = 0; i < goods.length; i++)
  {
    goods[i].querySelector(".cart_list_goods_item_check_checkbox").style.display = "block";
    goods[i].querySelector(".cart_list_goods_item_check_checkbox_checked").style.display = "none";
  }

  document.getElementById("cart_check_price_checked_price_number").innerHTML = 0;
}





//вбор товара
function selectProduct(e) {
  let check = 0;
  let product = e.target.closest(".cart_list_goods_item");
  let price = product.querySelector(".cart_list_goods_item_info_price_number").innerHTML;
  let count = product.querySelector(".cart_list_goods_item_count_form_count").innerHTML;
  let totalPrice = (count * price);
  let checkeds = document.getElementsByClassName("cart_list_goods_item_check_checkbox_checked");
  let currentCheckbox = product.querySelector(".cart_list_goods_item_check_checkbox");
  let currentChecked = product.querySelector(".cart_list_goods_item_check_checkbox_checked");
  let checkedsCount = 0;
  let checkboxAll = document.getElementById("cart_list_select_check");
  let checkedAll = document.getElementById("cart_list_select_check_remove");
  let checkPriceBlock = document.getElementById("cart_check_price_checked_price_number");

  if(e.target.getAttribute("data-checkbox") == "checkbox")
  {
    currentCheckbox.style.display = "none";
    currentChecked.style.display = "block";
    check = totalPrice + Number(checkPriceBlock.innerHTML);
    for (var i = 0; i < checkeds.length; i++) if (checkeds[i].style.display=="block") checkedsCount++;
    if (checkedsCount == checkeds.length)
    {
      checkboxAll.style.display="none";
      checkedAll.style.display="block";
    }
  }
  else if (e.target.getAttribute("data-checkbox") == "checked")
  {
    currentCheckbox.style.display = "block";
    currentChecked.style.display = "none";
    check = Number(checkPriceBlock.innerHTML) - totalPrice;
    checkboxAll.style.display="block";
    checkedAll.style.display="none";
  }
  checkPriceBlock.innerHTML = check;
}





//изменить колличество товара в корзине
function changeCount(e)
{
  let product = e.target.closest(".cart_list_goods_item");
  let productCount = product.querySelector(".cart_list_goods_item_count_form_count");
  let productPrice = Number(product.querySelector(".cart_list_goods_item_info_price_number").innerHTML);
  let totalPrice = document.getElementById("cart_check_price_total_price_number");
  let checkedPrice = document.getElementById("cart_check_price_checked_price_number");
  let checkCount = document.getElementById("cart_check_price_count_number");
  let checkedBox = product.querySelector(".cart_list_goods_item_check_checkbox_checked");
  // let cart_count = document.getElementById("cart_count");

  if (e.target.classList == "cart_list_goods_item_count_form_plus")
  {
    if (Number(productCount.innerHTML) < 5)
    {
      // cart_count.innerHTML = Number(cart_count.innerHTML)+1;
      totalPrice.innerHTML = Number(totalPrice.innerHTML)+productPrice;
      productCount.innerHTML = Number(productCount.innerHTML) + 1;
      checkCount.innerHTML = Number(checkCount.innerHTML) + 1;
      if (checkedBox.style.display == "block") checkedPrice.innerHTML = Number(checkedPrice.innerHTML) + productPrice;
    }
  }
  if (e.target.classList == "cart_list_goods_item_count_form_minus")
  {
    if (Number(productCount.innerHTML) > 1)
    {
      // cart_count.innerHTML = Number(cart_count.innerHTML)-1;
      totalPrice.innerHTML = Number(totalPrice.innerHTML)-productPrice;
      productCount.innerHTML = Number(productCount.innerHTML) - 1;
      checkCount.innerHTML = Number(checkCount.innerHTML) - 1;
      if (checkedBox.style.display == "block") checkedPrice.innerHTML = Number(checkedPrice.innerHTML) - productPrice;
    }
  }
}












//добавить в корзину
function add_to_cart()
{
  let cart_count = document.getElementById("cart_count");
  cart_count.innerHTML = Number(cart_count.innerHTML)+1;
}



















// checkLogin = /^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i;
// checkPassword = /.{6,10}/;
//
// login.value.match(loginR);
// password.value.match(passwordR);


//проверка формы авторизации
// function authForm()
// {
//   let form = document.getElementById("enterForm");
//   let login = form.querySelector("input[type=text]");
//   let password = form.querySelector("input[type=password]");
//   let error = document.getElementById("formErrorMessage");
//
//   if (login.value == "" || password.value == "")
//     error.innerHTML = "Не все поля заполнены";
//   else if (!login.value.match(/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i))
//     error.innerHTML = "Не верный формат электронной почты";
//   else if (!password.value.match( /.{6,10}/ ))
//     error.innerHTML = "Пароль должен содержать не менее 6 символов";
//   else
//     error.innerHTML = "";
// }

//проверка формы регистрации
// function create_account()
// {
//   let login = document.getElementById("create_account_form").querySelector("input[type=text]");
//   let password1 = document.getElementById("password1");
//   let password2 = document.getElementById("password2");
//   let error = document.getElementById("formCreateAccountErrorMessage");
//
//   if (login.value == "" || password1.value == "" || password2.value == "")
//     error.innerHTML = "Не все поля заполнены";
//   else if (!login.value.match(/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i))
//     error.innerHTML = "Не верный формат электронной почты";
//   else if (!password1.value.match( /.{6,10}/ ))
//     error.innerHTML = "Пароль должен содержать не менее 6 символов";
//   else if (password1.value != password2.value)
//     error.innerHTML = "Пароль не совпадает";
//   else
//     error.innerHTML = "";
// }














//
