<?php 
class noticeerp{
	 /**
 * get提交数据
 * @param  string $url  请求地址
*/
	function getData($url){
   $header = array(
       'Accept: application/json',
    );
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 超时设置,以秒为单位
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
 
    // 超时设置，以毫秒为单位
    // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
 
    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //执行命令
    $data = curl_exec($curl);
 
    // 显示错误信息
    if (curl_error($curl)) {
        print "Error: " . curl_error($curl);
    } else {
        // 打印返回的内容
        var_dump($data);
        curl_close($curl);
    }
}

 /**
 * post提交数据
 * @param  string $url  请求地址
 * @param  array $data 请求参数
 * @return json       请求响应
 */
function submitData($url,$data){
	$header = array(
       'Accept: application/json',
    );
 
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 超时设置
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
 
    // 超时设置，以毫秒为单位
    // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
 
    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE );
 
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //执行命令
    $data = curl_exec($curl);
 
    // 显示错误信息
    if (curl_error($curl)) {
        print "Error: " . curl_error($curl);
    } else {
        // 打印返回的内容
        return $data;
        curl_close($curl);
    }
}



	function ASCII($params = array()){
	
		//ksort()对数组按照键名进行升序排序
		$params =array_keys($params);
		
		sort($params);
	
        //reset()内部指针指向数组中的第一个元素
		reset($params);
	
		$str =strtoupper(implode(',',$params));
		
		return $str;
	}
 



	/*推送订单api*/
	function pushorderapi($url,$ak,$push_companyId,$data,$as)
	{
		$param=array();
	$param['ak']=$ak;
	$param['push_companyId']=$push_companyId;
$param['data']=json_encode($data,JSON_UNESCAPED_UNICODE);

	$noticeerp1=new noticeerp();
	$paramsKey=$noticeerp1->ASCII($param);

	$param['access_token']=strtoupper(md5($as.",".$paramsKey.",".$as)); 
	$notifyresult=$noticeerp1->submitData($url,$param);

file_put_contents(dirname(__FILE__) . '/my_logger.txt', $notifyresult,FILE_APPEND);
	
		
		
		
	}
	
	
	
	
	/*物流api*/
	function pushshipapi($url,$ak,$tid,$outSid,$expressCode)
	{
		$param=array();
	$param['ak']=$ak;
	$param['tid']=$tid;
	$param['outSid']=$outSid;
    $param['expressCode']=$expressCode;
	$noticeerp1=new noticeerp();
	$paramsKey=$noticeerp1->ASCII($param);

	$param['access_token']=strtoupper(md5($as.",".$paramsKey.",".$as)); 
	echo $noticeerp1->submitData($url,$param);
	
	}
	
	
	
		/*物流轨迹api*/
	function pushshiphistoryapi($url,$ak,$data)
	{
		$param=array();
	$param['ak']=$ak;
	$param['data']=$data;
	
	$noticeerp1=new noticeerp();
	$paramsKey=$noticeerp1->ASCII($param);

	$param['access_token']=strtoupper(md5($as.",".$paramsKey.",".$as)); 
	echo $noticeerp1->submitData($url,$param);
	
	}
	
	
	
	
	
	
	
	
}


?>