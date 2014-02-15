<?
//��ũ���� CGI��θ� �����ϱ�
function GetLinkName($tmpUrl){
	list($LinkName,$QueryData)=split("\?",$tmpUrl,2);
	return $LinkName;
}

//��ũ���� Query�����͸� �����ϱ�
function GetQueryData($tmpUrl){
	list($LinkName,$QueryData)=split("\?",$tmpUrl,2);
	return $QueryData;
}

//��ũ���� �н���� �����ϱ�
function GetFolderPath($tmp){
	//$RootUrl���� ���� ��� �����ϱ�
	list($h1,$h2)=split("\?",$tmp,2);
	$ParentPath=substr( $h1, 0, strrpos( $h1, '/') )."/";
	return $ParentPath;
}

//������Ʈ��+��ary�� data�� ��ġ��
function MergeQueryNForm($Query,$aryForm){
	$data=$Query;
	for($t=1;$t<count($aryForm);$t++){
		if($data!="")$data.="&";
		$data.=$aryForm[$t]["name"]."=".$aryForm[$t]["value"];
	}
	return $data;
}

//������Ʈ��+��ary�� data�� ��ġ��
function MergeQueryNFormNType($Query,$aryForm){
	$data=$Query;
	for($t=1;$t<count($aryForm);$t++){
		if($data!="")$data.="&";
		$data.=$aryForm[$t]["name"]."=".$aryForm[$t]["value"]."��".$aryForm[$t]["type"];
	}
	return $data;
}

//���� �ð� ���ϱ�
function getmicrotime(){ 
   list($usec, $sec) = explode(" ", microtime()); 
   return ((float)$usec + (float)$sec); 
} 

//�¿� ',",>, ��������
function StripQuota($tmp){
	$tmp=trim($tmp);
	if($tmp==""){
		return $tmp;
	}else if(substr($tmp,0,1)=="\"" || substr($tmp,0,1)=="'"){
		$tmp=substr($tmp,1,strlen($tmp)-2);
	}else if(substr($tmp,strlen($tmp)-1)==">"){
		$tmp=substr($tmp,0,strlen($tmp)-1);
	}else{
		$tmp=$tmp;
	}

	return $tmp;
}

//�Ķ����ͽ�Ʈ���� URL�� urlencode�������κ�ȯ�Ͽ� ����
function GetQueryUrlEncode($tmp,$ForceEncode){
	$ReturnValue="";
	//echo "<BR>\nGetQueryUrlEncode �Է�:".htmlspecialchars($tmp);

	//�̹� ���ڵ� �Ǿ����� �˻�
	//if(!$ForceEncode && eregi("(\%5F|\%2E|\%3F|\%09|\%2F|\%26|\%0D|\+|\%0A|\%3D)",$tmp))return $tmp;
	if(!$ForceEncode && eregi("\%[0-9a-z]{2}",$tmp))return $tmp;

	//�Ķ���� ���� ���ϱ�
	$tary=split("&",$tmp);
	
	//���� ���鼭 AryInjection��� �˻�
	for($k=0;$k<count($tary);$k++){
		//������Ʈ�� �����
		list($tname,$tvalue)=split("=",$tary[$k],2);
		if($tname=="")continue;
		if($ReturnValue!="")$ReturnValue.="&";
		//���ڳ�������_�̿��ǹ��ڰ� ������ urlencode
		if( (eregi("[^a-z0-9\_]",$tvalue) && !eregi("\%[0-9a-z]{2}",$tvalue)) || $ForceEncode){
			$ReturnValue.=$tname."=".urlencode($tvalue);
		}else{
			$ReturnValue.=$tname."=".$tvalue;
		}
	}
	//echo "<BR><BR>\nGetQueryUrlEncode ���:".htmlspecialchars($ReturnValue);
	return $ReturnValue;
}


//�˻��� �н��� �ùٸ� �н� ���� �˻�(������ ���ڳ�/���鹮��""�� ����,false ����(Ÿ����Ʈ�θ�ũ,���ܸ�ũ)
function GetUrlValid($EnvCtl,$path,$ParentPath,$pathType){
	global $Env;
	global $elist,$slist,$EnvAct,$root_folder;
	global $TargetHost;
	
	if($Env["f_debug_yn"])echo "<BR>path A:".$path;

	//��ũ���� cgi��� ������Ʈ�� �и�
	$path=trim($path);

	//��ũ���� ���� ������ ����
	if($path=="")return "";
	
	list($LinkName,$QueryString)=split("\?",$path,2);
	//echo "<BR>LinkName:".$LinkName;
	//echo "<BR>QueryString:".$QueryString;

	//������ ����Ʈ�� ������ false
	if( eregi("\.(".$elist.")$",$LinkName,$tb) )return false;

	//src�� ��ũ��Ʈ �ƴϸ� ����������
	if( eregi("src",$pathType,$ta) && !eregi("\.(".$slist.")$",$LinkName,$tb))return false;
	//echo sprintf("\n %3d src��: [%s]",$i,$path);

	//��ȣ��Ʈ���� �տ� ������� ����
	if( eregi("(http|https)(\:\/\/".$TargetHost.")(.*)",$LinkName,$myreg) ){
		$LinkName=$myreg[3];
	}

	//��ũ�տ� ./������ ./����
	if( eregi("^(\.\/)(.*)",$LinkName,$myreg) ){
		$LinkName=$myreg[2];
	}

	//�ܺ� ��ũ,�̸���,�ڹٽ�ũ��Ʈ �϶�
	if(	!eregi("^(http\:\/\/|https\:\/\/|mailto\:|javascript\:)",$LinkName)){
		//echo sprintf("\n %3d ��Ī��: [%s]",$i,$path);
	
		//../../../�� ���������� �̵�
		$tLink=$LinkName;
		$tmpParent=$ParentPath;
		/*
		echo "<hr><BR>pathAll[".$pathAll."]";
		echo "<hr><BR>ParentPath[".$ParentPath."]";
		echo "<BR>tmpPath[".$tLink."]";
		echo "<BR>tmpParent[".$tmpParent."]";
		echo "<BR>tmpPath[".substr($tLink,0,3)."]";
		echo "<BR>tmpParent[".strlen($tmpParent)."]";
		*/
		while(substr($tLink,0,3)=="../" && strlen($tmpParent)>1){
			//���������� �̵�
			$tLink=substr($tLink,3);
			$tmpParent=substr( substr($tmpParent,0,strlen($tmpParent)-1), 0, strrpos( substr($tmpParent,0,strlen($tmpParent)-1), '/', -2 ) )."/";
		}

		if(substr($tLink,0,1)!="/" && !eregi("http:\/\/",$tLink) )$tLink=$tmpParent.$tLink;			
		if($EnvAct["folder_yn"]=="Y" && !eregi("^".$root_folder,$tLink))return false;//�Է��������ϸ� �˻�
		//echo sprintf("\n %3d ��ȯ: ",$i).$tLink;
		
		if($Env["f_debug_yn"])echo "<BR>path B:".$tLink;
		
		//������ ������Ʈ���� �־����� �ٿ��� ����
		if($QueryString)$tLink.="?".$QueryString;
		return $tLink;
	}
	return false;
}
?>
