<?

//��ũ�� �迭�� �޾ƿ���
function getLinkAry($EnvCtl,$body){
	global $Env,$EnvAct;

	global $slist;
	global $whitespace;
	global $root_folder; //�Է��� ��� ���ϸ� �˻�

	global $linkpattern,$NonQuotaLink,$QuotaLink;//���Խ�1
	global $reg_str_form,$p_method,$p_action,$p_name,$p_type,$p_enctype,$p_onsubmit,$p_value;//���Խ�2
	global $reg_str_form,$reg_str_form_end,$reg_str_formDetail,$reg_str_input,$reg_str_select,$reg_str_textarea;//���Խ�3
	global $reg_link_type;
	global $EnvAct;
	//������ �迭
	$tLink=null;
	$tActionAry=null;

	//$RootUrl���� ���� ��� �����ϱ�
	$ParentPath=GetFolderPath($EnvCtl["Parent_doc"]);


	//��ũ �˻�
	/*

	$reg_str="(".$reg_link_type.")([".$whitespace."]*=[".$whitespace."]*)".
		"(".
			"(\')".$QuotaLink."(\')".
			"|(\")".$QuotaLink."(\")".
			"|()".$NonQuotaLink."([\>".$whitespace."])".
		")";//:����
	*/
	//<META HTTP-EQUIV=Refresh CONTENT="10; URL=http://www.htmlhelp.com/">  �ݿ�
	$reg_str="(".$reg_link_type.")([".$whitespace."]*=[".$whitespace."]*)".
		"(".
			"(\')([^\#\'][^\']*)(\')".
			"|(\")([^\#\"][^\"]*)(\")".
			"|()([^\#".$whitespace."\>\"\'][^".$whitespace."\>\"\']*)([\'\"\>".$whitespace."])".
		")";//:����

	/*
	$reg_str="(href|action|location|src)([".$whitespace."]*=[".$whitespace."]*)".
		"(".
			"(\')([^\']+)(\')".
			"|(\")([^\"]+)(\")".
			"|()([^\>]+)(\>)".
			"|()([^".$whitespace."]+)([".$whitespace."])".
		")";//:����
	*/

	$pos=0;
	$i=0;
	$matched=null;
	//echo "<BR>�Ľ� link:";
	while(eregi($reg_str,$body,$matched)){
		//echo "<BR>��Ī:".$matched[0];
		$pos=strpos($body, $matched[0]);
		$body=substr($body,strlen($matched[0])+$pos);

		$pathAll=trim($matched[0]);
		$pathType=strtoupper(trim($matched[1]));
		$path=StripQuota($matched[3]);

		if($path=="")continue;//���¸�ũ�̸����
		list($link,$query)=split("\?",$path,2);

		//��ũ �ùٸ��� �˻���
		$tmpLink=GetUrlValid($EnvCtl,$link,$ParentPath,$pathType);
		if(is_bool($tmpLink))continue; //����cgi�ų� Ÿ����Ʈ�̸� ����������

		//�ش� ��ũ�� �̹�ó���� �����ϴ��� �˻�
		$EnvCtl["isAddBuffer"]=false;
		if(	!CheckOutExist($EnvCtl,$tLinkName=$tmpLink,$tMergeData=$query,$tCheckType="ALL")){
			$turl=$tmpLink;
			if($pathType=="ACTION"){
				//���� ����Ʈ�� ����
				$tActionAry[count($tActionAry)]=$turl;
				//echo "<br>��ACTION ".$turl;
			}else{
				//��ũ ���� ����
				if(strlen($query)>0)$turl.="?".$query;
				//echo "<BR>�Ľ� URL:".strtoupper($pathType)." " .$turl;
				$tLink[$i]["url"]=$turl;
				$tLink[$i]["link"]=$tmpLink;
				$tLink[$i]["query"]=$query;
				$tLink[$i]["type"]=$pathType;

				//echo "<br>��$pathType ".$turl;
				$i++;
			}
		}else{
			$turl=$tmpLink;
			if(strlen($query)>0)$turl.="?".$query;
			//echo "<BR>���� URL:".$turl;
		}
	}
	return array($tLink,$tActionAry);
}
?>