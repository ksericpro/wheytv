<?php
//Generate API Url
function generateAPIURL($url_ext)
{
  $url = "http://www.wheytv.com/api2/" . $url_ext;
  return $url;
}

//send Curl Data
function executeCurl($url, $action, $data, $timeout = 15){
  $ch = curl_init($url);
  $headers= array('Accept: application/json','Content-Type: application/json');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action); 

  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
  $result = curl_exec($ch);
  curl_close($ch); 
  return $result;
}

/*function executeCURLx($url, $method = 'get', $header = null, $postdata = null, $files = false, $image_array="" ,$timeout = 15) {
        $s = curl_init();
        if($files){
        foreach($image_array as $value){
			if(!empty($files[$value]['tmp_name'])){
				$postdata[$value]['rname'] = $files[$value]['name'];
				$filePath = $files[$value]['tmp_name'];
				$postdata[$value]= "@$filePath" . ';filename='.$files[$value]['name'].';type='.$files[$value]['type'];
			}
		}
	  }
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_SAFE_UPLOAD, false); // this is need to do for 5.5+ version

        if ($header) {
            curl_setopt($s, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($s, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($s, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($s, CURLOPT_MAXREDIRS, 5);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);

        if (strtolower($method) == 'post') {
            curl_setopt($s, CURLOPT_POST, true);
            curl_setopt($s, CURLOPT_POSTFIELDS, $postdata);
        } else if (strtolower($method) == 'delete') {
            curl_setopt($s, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($s, CURLOPT_CUSTOMREQUEST, 'DELETE');
        } else if (strtolower($method) == 'put') {
            //curl_setopt($s, CURLOPT_CUSTOMREQUEST, 'PUT');
            //curl_setopt($s, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($s, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($s, CURLOPT_POSTFIELDS,http_build_query($data));
        }

        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
	

        $html = curl_exec($s);

        curl_close($s);
        return $html;
}*/
    
 ?>