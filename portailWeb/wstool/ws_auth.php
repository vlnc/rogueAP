<?
//���� ��Ű ��������
function AuthCookie(){
	global $Env;
	global $TargetHost,$f_auth_host,$f_auth_url,$f_auth_port,$f_auth_method,$f_auth_input_name,$f_auth_input_value;
	$result = "";
	
	//����Input�迭�� �����
	$FormAryInput;
	//�� ������(������Ʈ��) �����
	for( $i = 0 ; $i < count ( $f_auth_input_name ); $i ++){
		$FormAryInput[$i+1]["name"]=$f_auth_input_name[$i];
		$FormAryInput[$i+1]["value"]=$f_auth_input_value[$i];
		$FormAryInput[$i+1]["tag"]="INPUT";
	}

	//Ÿ�ٸ�ũ �и�
	list($LinkName,$QueryString)=split("\?",$f_auth_url,2);

	//������ ��������
	$TargetHost=$f_auth_host;
	$msg=MakeContent($TargetHost,$LinkName,$QueryString,"",strtoupper($f_auth_method),"",$FormAryInput);

	if($Env["f_debug_yn"])echo "<BR>������û������:".$msg;

	$tmpCookie="";
	if(intval($f_auth_port)==443){
		$fp = fsockopen("ssl://".$f_auth_host, $f_auth_port, $errno, $errstr, 30);
	}else{
		$fp = fsockopen($f_auth_host, $f_auth_port, $errno, $errstr, 3);
	}
	if (!$fp) {
		return "$errstr ($errno)";
	} else {
		fputs ( $fp , $msg );
		while (!feof($fp)) {
			$j++;
			$tmps =fgets($fp,128);
			$matched=null;
			if(eregi("^Set\-Cookie\:(.*)",$tmps,$matched)  ){
				list($NameValue,$Ext)=split(";",$matched[1],2);
				$tmpCookie.=$NameValue.";";
			}
		}
	}
	fclose($fp);
	return $tmpCookie;
}
?>