<?
//go Xss
function GoXss($EnvCtl,$dataLink,$dataForm){
	global $EnvAct;
	if($EnvAct["ERR_200XSS_YN"]<>"Y")return;

	inXssLink($EnvCtl,$dataLink);
	inXssForm($EnvCtl,$dataForm);
}

//Xss Link
function inXssLink($EnvCtl,$dataLink){
	global $Env,$EnvAct;
	global $AryXss;


	//�Ķ���� ���� ���ϱ�
	$tary=split("&",$dataLink["query"]);

	$ControlReturnValue=true;

	//���� ���鼭 AryXss��� �˻�
	foreach ($AryXss as $Str => $Reg){
		$tXss=$Str;
		$ControlReturnValue=true;
		for($k=0;$k<count($tary) && is_array($tary);$k++){
			//������Ʈ�� �����
			list($tname,$tvalue)=split("=",$tary[$k],2);
			if($tname=="")continue;
			$InjectQuery="";
			for($m=0;$m<count($tary);$m++){
				list($tname,$tvalue)=split("=",$tary[$m],2);
				if($tname=="")continue;

				if(strlen($InjectQuery)>0)$InjectQuery.="&";
				//������Ʈ��: �������Ҷ��� ��������, �����Ǿ��°��� �װ� �״��
				if($k==$m){
					$InjectQuery.=$tname."=".$tXss;
				}else{
					$InjectQuery.=$tname."=".$tvalue;
				}
			}
			//sock injectȣ�� (urlencode�� http���� ���)
			//echo "<BR>sock injectȣ��:".$dataLink["link"]."?".$InjectQuery;
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=3;
			if($EnvAct["ProcessDotPrint"]=="Y")echo ".";flush();
			$ControlReturnValue=Control(
				$EnvCtl,$tLinkName=$dataLink["link"],$tOriginQuery=$dataLink["query"],$InjectQuery,$tOriginForm=null
				,$tInjectForm=null,$tFormMethod="GET",$tFormEnctype=null
				);
			if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
		}
		if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
	}


}


//Xss Form
function inXssForm($EnvCtl,$dataForm){
	global $Env,$EnvAct;
	global $outLink,$AryXss;
	$ParamYN="N";

	//�迭�� �ƴϸ� ����
	if(!is_array($dataForm))return;

	$ControlReturnValue=true;

	//���� ���鼭 AryXss��� �˻�
	foreach ($AryXss as $Str => $Reg){
		$tXss=$Str;
		//[xss 1] input��ĵ
		$ControlReturnValue=true;
		for($k=1;$k<count($dataForm) && is_array($dataForm);$k++){

			//��Input ���� �����
			if($dataForm[$k]["name"]=="" || $dataForm[$k]["type"]=="FILE")continue;

			$InjectForm=$dataForm;
			//echo "<BR>InjectForm:".count($InjectForm);
			//echo "<BR>Xss:".$tXss;
			for($m=1;$m<count($InjectForm);$m++){
				
				if($InjectForm[$m]["name"]=="")continue;
				$tmpValue=$InjectForm[$m]["value"];
				if($k==$m){
					$InjectForm[$m]["value"]=$tXss;
				}else{
					if($InjectForm[$m]["type"]=="FILE"){
						$tmpValue=$Env["AttachFile"];
					}else if($tmpValue==""){
						$tmpValue=$Env["FormInputDeafultValue"];
					}
					$InjectForm[$m]["value"]=$tmpValue;
				}
			}

			//sockȣ��
			//echo "<BR>sock injectȣ��:".$dataForm[0]["actioncgi"]."?".htmlspecialchars(MergeQueryNForm($dataForm[0]["actionquery"],$InjectForm));
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=3;
			if($EnvAct["ProcessDotPrint"]=="Y")echo ".";flush();
			$ControlReturnValue=Control(
				$EnvCtl,$LinkName=$dataForm[0]["actioncgi"],$OriginQuery=$dataForm[0]["actionquery"],$InjectQuery=$dataForm[0]["actionquery"],$OriginForm=$dataForm,
				$InjectForm,$FormMethod=$dataForm[0]["method"],$FormEnctype=$dataForm[0]["enctype"]
				);
			if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
		}
		if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������

		//[xss 2] action�� �ִ� ���� Injection
		$tary=split("&",$dataForm[0]["actionquery"]);
		for($k=0;$k<count($tary) && is_array($tary);$k++){
			//������Ʈ�� �����
			list($tname,$tvalue)=split("=",$tary[$k],2);
			if($tname=="")continue;
			$InjectQuery="";
			for($m=0;$m<count($tary);$m++){
				list($tname,$tvalue)=split("=",$tary[$m],2);
				if($tname=="")continue;

				if(strlen($InjectQuery)>0)$InjectQuery.="&";
				//������Ʈ��: �������Ҷ��� ��������, �����Ǿ��°��� �װ� �״��
				if($k==$m){
					$InjectQuery.=$tname."=".$tXss;
				}else{
					$InjectQuery.=$tname."=".$tvalue;
				}
			}

			//sockȣ��
			//echo "<BR>sock injectȣ��:".$dataForm[0]["actioncgi"]."?".htmlspecialchars(MergeQueryNForm($InjectQuery,$dataForm));
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=3;
			if($EnvAct["ProcessDotPrint"]=="Y")echo ".";flush();
			$ControlReturnValue=Control(
				$EnvCtl,$tLinkName=$dataForm[0]["actioncgi"],$tOriginQuery=$dataForm[0]["actionquery"],$tInjectQuery=$InjectQuery,$tOriginForm=$dataForm
				,$dataForm,$tFormMethod=$dataForm[0]["method"],$tFormEnctype=$dataForm[0]["enctype"]
				);
			if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
		}
		if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
	}


}
?>