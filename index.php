<?php
    /**
     * www.dingdanxia.com
     * qq交流群：953832391
     */

    //============== 用户配置区域 ================

    //请配置你的订单侠开放平台apikey 
    //注册地址 https://www.dingdanxia.com/user/register/index.html
    //秘钥获取：登录订单侠开放平台 - 系统设置 - 接口管理

    $apikey  = "这里填写您的apikey秘钥";

    //首页展现商品
    $keyword = "女装";

    //每页显示多少个商品
    $page_size = 20 ;


    //============== 非专业人士下方代码请勿进行修改 ================

    $q = !empty($_GET['q'])?trim($_GET['q']) : $keyword;
    $p = isset($_GET['p'])?trim($_GET['p']):1;
   

    $domain           = 'http://api.tbk.dingdanxia.com';
    $super_search_url = $domain . '/tbk/super_search';
    $id_privilege_url = $domain . '/tbk/id_privilege';

    //点击领券
    $id = isset($_GET['id'])?trim($_GET['id']):'';
    if (!empty($id)) {
        $res =json_decode(http_post($id_privilege_url,array('id'=>$id,'apikey'=>$apikey)),true);
         if ($res['code'] == 200) {
            $jump = '';
            if (isset($res['data'])) {
                $jump=$res['data']['coupon_click_url'];
            }
            if (empty($jump)) {
                $jump=$res['data']['item_url'];
            }
            header("Location:$jump");die;
         }else{
            echo '<div style="margin-top:100px;color:red;font-size:20px;"><center>'.$res['msg'].'<a href="javascript:history.go(-1);">返回上一页</a></center></div>';die;
         }
    }


    $param=array(
        'apikey'   => $apikey,
        'q'        => $q,
        'page_no'  => $p,
        'page_size'=> $page_size
        );
    
    $res =json_decode(http_post($super_search_url,$param),true);



    if ($res['code'] !=200 ) {
        $res =json_decode(http_post($super_search_url,$param),true);
        if ($res['code'] !=200 ) {
            echo '<div style="margin-top:100px;color:red;font-size:20px;"><center>'.$res['msg'].'<a href="javascript:history.go(-1);">返回上一页</a></center></div>';die;
        }
    }
   
    $data = $res['data'];



    $totalPageCount = intval($res['total_results']/$page_size); //总页数
    
    if ($p<$totalPageCount) {
       $next_p=$p+1;
    }else{
       $next_p=$totalPageCount;
    }



/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
function http_post($url,$param,$post_file=false,$header = null){
    $oCurl = curl_init();
    if (is_array($header)) {
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header); 
    }
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    if (is_string($param) || $post_file) {
        $strPOST = $param;
    } else {
        $aPOST = array();
        foreach($param as $key=>$val){
            $aPOST[] = $key."=".urlencode($val);
        }
        $strPOST =  join("&", $aPOST);
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes">
<title>优惠券,大额优惠券,优惠券查询,优惠券榜单</title>
<style type="text/css">
body{margin:0;padding:0;color:#333;font-size:12px;font-family:Microsoft YaHei; background:url(https://img.alicdn.com/imgextra/i2/797273728/O1CN013AFIhn1dPT5jqxkYT_!!797273728.png) no-repeat center 650px #ffbc48; background-attachment:fixed;}
a{color:#333;text-decoration:none;cursor:pointer;}
img{border:none;}
ul,li{margin:0;padding:0;list-style:none;}
p,span{margin:0;padding:0;}
div,ul,li,p,span{overflow:hidden;}
.wrapper{ margin:0px auto; width:100%; height:auto; background:url(https://img.alicdn.com/imgextra/i2/797273728/O1CN01fDWZQI1dPT5k4KviC_!!797273728.png) no-repeat center top; background-attachment:fixed;}
.logo{margin:50px auto 0px auto; width:500px; height:180px; background:url(https://img.alicdn.com/imgextra/i2/797273728/O1CN01KllwWW1dPT5jqvffo_!!797273728.png) no-repeat center top;}
.search{ margin:50px auto 30px auto; width:475px;height:36px; border-radius:20px; background-color:#fff; box-shadow:0px 3px 6px 0px #999;}
.search .q{float:left;padding:0 10px 0 20px;width:336px;height:36px;border:none;font:400 15px/30px Microsoft YaHei;outline:none;}
.search .search-btn{float:left; margin:4px 4px 4px 0px;width:105px;height:28px;border:none;background-color:#ff4046;color:#fff; font-size:14px; cursor:pointer;outline:none; border-radius:20px; line-height:26px;}
.search .search-btn:hover{background-color:#fd6a2f;}





.quan-list{ margin:0px auto; width:500px; height:auto; }
.quan{ float:left; width:500px; height:155px; margin:16px 0px 0px 0px; background:url(https://img.alicdn.com/imgextra/i1/797273728/O1CN01QWtCpo1dPT5ookXTQ_!!797273728.png) no-repeat 0px 0px; background-size:500px 155px;}
.quan a{ float:left; width:500px; height:155px; outline:none;}
.quan .top-tag{ float:left; position:absolute; margin-top:10px; margin-left:10px; padding-top:1px; width:30px; height:35px; color:#fff; background:url(https://img.alicdn.com/imgextra/i1/797273728/O1CN01hYNHiu1dPT5nMewsu_!!797273728.png) no-repeat 0px 0px; background-size:30px 35px; text-align:center; font-size:12px; line-height:14px;}
.quan .quan-img{ float:left; margin:10px; width:135px; height:135px;}
.quan .quan-info{ float:left; margin-top:10px; width:195px; height:135px;}
.quan .quan-info .title{float:left; margin-top:5px; width:195px; height:40px; font-size:16px; line-height:20px;display:-webkit-box;text-overflow:ellipsis;word-break:break-all;-webkit-box-orient:vertical;-webkit-line-clamp:2;}
.quan .quan-info .price-1{float:left;  margin-top:35px; width:195px; height:20px; font-size:14px; color:#999; line-height:20px;}
.quan .quan-info .price-1 span{ margin-right:10px; text-decoration:line-through;}
.quan .quan-info .price-2{float:left; margin-top:5px;  width:195px; height:20px; font-size:16px; color:#fb3434; line-height:20px;}
.quan .quan-info .price-2 span{ line-height:24px; padding:0px 2px; font-weight:bold;}
.quan .quan-price{ float:right; margin-top:10px; margin-right:16px; width:115px; height:135px; text-align:center;}
.quan .quan-price .price-01{ padding-top:15px; font-size:22px; color:#fb3434; font-weight:bold;}
.quan .quan-price .price-02{ color:#999; font-size:11px; line-height:30px;}
.quan .quan-price .price-03{ margin-top:10px; color:#fff; font-size:14px; line-height:32px;border-radius:20px; background-color:#fb3434;}
.page-list{ margin:30px auto 40px auto; width:500px;height:50px;}
.page-list a{ float:left; margin-left:60px; width:160px;height:36px; font-size:14px; line-height:36px; text-align:center; border-radius:20px; background-color:#fff; color:#fb3434; box-shadow:0px 3px 6px 0px #999;}
.page-list a:hover{background-color:#ff4046;color:#fff;}
.page-list .txt{color:#ccc;}
.page-list .txt:hover{background-color:#fff;color:#ccc;}
.footer{ margin:0px auto; width:100%; height:auto; text-align:left; line-height:26px; text-indent:10px;}
.footer a{ color:#999;}
</style>
</head>
<body>
<div class="wrapper">
    <div class="logo"></div>
    <div class="search">
    	<form name="searchForm" method="get" action="?" target="_self">
        	<input type="text" id="q" name="q" placeholder="查找全网优惠券..." value="<?php echo $q; ?>" class="q">
            <button type="submit" class="search-btn">查找优惠券</button>
    	</form>
    </div>
    <div class="quan-list">

                <?php foreach($data as $k=>$v){ ?>
                <div class="quan">
                    <a href="?id=<?php echo $v['item_id']; ?>" target="_blank">
                        <div class="top-tag"><p>TOP</p><p><?php echo  $k+1 ?></p></div>
                        <div class="quan-img"><img src="<?php echo $v['pict_url']; ?>" height="135" width="135"></div>
                        <div class="quan-info">
                            <div class="title"><?php echo $v['short_title']; ?></div>
                            <div class="price-1">现价<span> ¥<?php echo $v['zk_final_price']; ?> </span>已售<?php echo $v['volume']; ?>万件</div>
                            <div class="price-2">券后<span><?php echo $v['zk_final_price']-$v['coupon']; ?></span>元</div>
                        </div>
                        <div class="quan-price">
                            <div class="price-01"><?php echo $v['coupon']; ?>元</div>
                            <div class="price-02"><?php echo $v['coupon_info']; ?></div>
                            <div class="price-03">领券买</div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                
            </div>
    <div class="page-list">
        <?php if($p==1){ ?>
		  <a href="javascript:;" target="_self" class="txt">上一页</a>
        <? }else{?>  
            <a href="?q=<?php echo $q; ?>&p=<?php echo $p-1; ?>" target="_self">上一页</a>
        <?php }?>

        <?php if($p == $totalPageCount){?>
            <a href="javascript:;" target="_self" class="txt">下一页</a>
        <?php }else{ ?>
            <a href="?q=<?php echo $q; ?>&p=<?php echo $next_p; ?>" target="_self">下一页</a> 
        <?php } ?>
           
    </div>
</div> 
</body>
</html>
