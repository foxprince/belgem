<?php
require_once ('getaccesstoken.php');
// $theaccesstoken

$data = '{
     "button":[
      {
           "name":"欢迎预约",
           "sub_button":[
           {
               "type":"view",
               "name":"来访预约",
               "url":"https://mp.weixin.qq.com/s?__biz=MzIyNzA2NjE1OQ==&mid=2653292260&idx=3&sn=f6ae6153032a87fd8fbc6ecf846f8d48&chksm=f3b44ea4c4c3c7b2cfbae3be71174772e7ffaf9faf530fe2c87ce016d588ff14a6ad801eda66&scene=21#wechat_redirect"
            },
            {
               "type":"view",
               "name":"为什么安特卫普会成为世界钻石之都",
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=209757354&idx=1&sn=9dd5ddd2a5f142d3cde5b8a449993c5f&scene=18#rd"
            },
            {
               "type":"view",
               "name":"常见问题",
               "url":"https://mp.weixin.qq.com/s/alv3deeAYZJr7aHiLJoUcA"
            },
			{
               "type":"click",
               "name":"用户名密码",
               "key":"KEY_PASSWEBACCOUNT"
            },
			{
               "type":"view",
               "name":"登录网站",
               "url":"http://www.lumiagem.com/m/"
            }]
       },

			 {
           "name":"关于我们",
           "sub_button":[
           {
               "type":"view",
               "name":"创始人褚潇",
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=209685507&idx=1&sn=67376fd3ff6ee8db7d5129132c462492&scene=18#rd"
            },
            {
               "type":"view",
               "name":"利美钻石",
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=209685593&idx=1&sn=da74472433fa1318ccb01817d80a0b1b&scene=18#rd"
            },
			{
               "type":"view",
               "name":"钻石史上第一家钻石交易所",
               "url":"https://mp.weixin.qq.com/s?__biz=MzIyNzA2NjE1OQ==&mid=2653291300&idx=3&sn=c240c9c30367937bc106e733c7a387bb"
            },
			{
               "type":"view",
               "name":"比利时安特卫普的钻石街",
               "url":"https://mp.weixin.qq.com/s?__biz=MzIyNzA2NjE1OQ==&mid=2653291300&idx=2&sn=af4aef8c359e4fd1bf79008ffe5efea3"
            },
			{
               "type":"click",
               "name":"我的二维码",
               "key":"KEY_QRCODE"
            }]
       },

			 {
           "name":"钻石报价",
           "sub_button":[
           {
               "type":"click",
               "name":"输入预算",
               "key":"KEY_BUDGET"
            },
            {
               "type":"click",
               "name":"库存编号",
               "key":"KEY_STOCK_REF"
            },
            {
               "type":"click",
               "name":"4Cs查询",
               "key":"KEY_4CS"
            },
            {
               "type":"click",
               "name":"异形钻",
               "key":"KEY_FANCYSHAPE"
            },
            {
               "type":"click",
               "name":"精美首饰",
               "key":"KEY_JEWLERY"
            }]
       },
			 ]
 }';

$MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $theaccesstoken;

$ch = curl_init ();

curl_setopt ( $ch, CURLOPT_URL, $MENU_URL );
curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

$info = curl_exec ( $ch );

if (curl_errno ( $ch )) {
	echo 'Errno' . curl_error ( $ch );
}

curl_close ( $ch );

var_dump ( $info );

