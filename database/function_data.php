<?php
//===================================== FUNCTION Tự định nghĩa ============================================
//=========================================================================================================
//=========================================================================================================
//=========================================================================================================

//--------- Kết nối cở sở dữ liệu mysql --------------------------------------------------------

	function CONNECT_MYSQL($dsn,$account,$passw)
	{
		$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		// Create a new PDO instanace
		try {
		$db = new PDO($dsn, $account, $passw, $options);
		
		return $db;
		}
		// Catch any errors
		catch (PDOException $e) {
		
		echo '<lable style="color : red">'.$e->getMessage().'</lable>';
		
		exit();
		}
	}
//----------------

// ------- Fetch_assoc trả kiểu dữ liệu về kiểu mảng ['tên_cột_trong_table'=>'giá_trị']---------
	
	 function FETCH_ASSOC( $query)
	 {
	 	GLOBAL $conn;
	 	try {
				$stmt = $conn->prepare($query);
				//Thiết lập kiểu dữ liệu trả về
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$resultSet = $stmt->fetchAll();
				/*Trong trường hợp chưa setFetchMode() bạn có thể sử dụng
				$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);*/
				
				return $resultSet;
			}
		catch (PDOException $e) {
			
			echo '<lable style="color : red">'.$query.'</br>'. $e->getMessage().'</lable>';
			
			exit();
			}
	 }
// -----------------

// ------- Fetch_assoc trả kiểu dữ liệu về kiểu mảng ['tên_cột_trong_table'=>'giá_trị']---------
	 function FETCH_ALL( $query)
	 {
	 	GLOBAL $conn;
	 	try {
				$stmt = $conn->prepare($query);
				//Thiết lập kiểu dữ liệu trả về
				//$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$resultSet = $stmt->fetchAll();
				/*Trong trường hợp chưa setFetchMode() bạn có thể sử dụng
				$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);*/
				
				return $resultSet;
			}
		catch (PDOException $e) {
			
			echo '<lable style="color : red">'.$query.'</br>'. $e->getMessage().'</lable>';
			
			exit();
			}
	 }
// -----------------
	 function query($query)
	 {
	 	 	GLOBAL $conn;
		try {
				$query_prepare = $conn->prepare($query);
				
				$query_prepare->execute();
				
				return $query_prepare;
		}
		catch (PDOException $e) {

			echo '<lable style="color : red">'.$query.'</br>'. $e->getMessage().'</lable>';

			
			}
	 }
 function insert($query)
 {
 	 	GLOBAL $conn;
	try {
			$query_prepare = $conn->prepare($query);
			
			$query_prepare->execute();
			
			return $query_prepare;
	}
	catch (PDOException $e) {

		

		
		}
 }

 function SQL_INJECTION($var)
 {
	$result		= 	stripslashes($var);
	$result		= 	preg_replace("/[\"'%()@$.!&?_:#\/]/","", $result);
	return $result;
}

function base64UrlEncode($data)
{
    $urlSafeData = strtr(base64_encode($data), '+/', '-_');
 
    return rtrim($urlSafeData, '='); 
} 
 
function base64UrlDecode($data)
{
    $urlUnsafeData = strtr($data, '-_', '+/');
 
    $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
 
    return base64_decode($paddedData);
}

function generateJWT($algo,$header,$payload, $secret)
 {
    $headerEncoded = base64UrlEncode(json_encode($header));
 
    $payloadEncoded = base64UrlEncode(json_encode($payload));
 
    // Delimit with period (.)
    $dataEncoded = "$headerEncoded.$payloadEncoded";
 
    $rawSignature = hash_hmac($algo, $dataEncoded, $secret, true);
 
    $signatureEncoded = base64UrlEncode($rawSignature);
 
    // Delimit with second period (.)
    $jwt = "$dataEncoded.$signatureEncoded";
 
    return $jwt;
}
function verifyJWT( $algo,  $jwt,  $secret)
{
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
 
    $dataEncoded = "$headerEncoded.$payloadEncoded";
 
    $signature 	= base64UrlDecode($signatureEncoded);
	$data 		= base64UrlDecode($payloadEncoded);
    
    $rawSignature = hash_hmac($algo, $dataEncoded, $secret, true);
 	$kiemtra = hash_equals($rawSignature, $signature);
    return array(
    			'kiemtra'=> $kiemtra,
    			'data_user' => $data
    	) ;
}

if(!function_exists('hash_equals'))
{
	function hash_equals($str1, $str2)
	{
	    if(strlen($str1) != strlen($str2))
	    {
	        return false;
	    }
	    else
	    {
	        $res = $str1 ^ $str2;
	        $ret = 0;
	        for($i = strlen($res) - 1; $i >= 0; $i--)
	        {
	            $ret |= ord($res[$i]);
	        }
	        return !$ret;
	    }
	}
}
?>