var $sitecore = $sitecore || {};

$sitecore.urls = $sitecore.urls || {};
var strings="http://localhost:8080/GoGoTown/trunk/crm/index.php" //自己的配置地址
$sitecore.urls.base = strings ;
$sitecore.urls.add = function (name, url) {
    $sitecore.urls[name] = $sitecore.urls.base + "?url=" + url;
};

// 主模块
$sitecore.urls.add("Register", "Login/register_action");
$sitecore.urls.add("Login", "Login/login");


// 客户管理

$sitecore.urls.add("LoadOwnCustomersList", "ShopCustomers/searchPrivateBP"); //分页获取商家自有客户信息
$sitecore.urls.add("LoadGoGoCustomerList", "ShopCustomers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
$sitecore.urls.add("AddOwnCustomer", "")

//基本信息设置
$sitecore.urls.add("GetMerchantInfo", "ShopRank/get"); //获取商家基本信息
$sitecore.urls.add("EditMerchantInfo","ShopRank/Edit");//编辑商家信息



