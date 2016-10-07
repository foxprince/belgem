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
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=209685743&idx=1&sn=6439fb43d695360b84c799078a1ed69b&scene=18#rd"
            },
            {
               "type":"view",
               "name":"安特卫普...",
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=209757354&idx=1&sn=9dd5ddd2a5f142d3cde5b8a449993c5f&scene=18#rd"
            },
            {
               "type":"view",
               "name":"常见问题",
               "url":"http://mp.weixin.qq.com/s?__biz=MjM5MTkzNDIxOA==&mid=210299516&idx=1&sn=65cb3b49eca26b501c050ff9ce0b0cca&scene=18#rd"
            },
			{
               "type":"click",
               "name":"登录网站",
               "key":"KEY_PASSWEBACCOUNT"
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

