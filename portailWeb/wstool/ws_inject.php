<?
//������ go
function GoInject($EnvCtl,$dataLink,$dataForm){
	global $EnvAct;
	if($EnvAct["ERR_500SQL_YN"]<>"Y")return;

	injectLink($EnvCtl,$dataLink);
	injectForm($EnvCtl,$dataForm);
}

//������ Link
function injectLink($EnvCtl,$dataLink){
	global $Env,$EnvAct;
	global $AryInjection;

	//�Ķ���� ���� ���ϱ�
	$tary=split("&",$dataLink["query"]);

	$ControlReturnValue=true;

	//[inject ȣ��] sock injectȣ�� (urlencode�� http���� ���)
	for($j=0;$j<count($AryInjection["MSSQL"]) && strlen($dataLink["query"])>0;$j++){
		$tInject=$AryInjection["MSSQL"][$j];
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
					if($tvalue=="")$tvalue=$Env["FormInputDeafultValue"];
					$InjectQuery.=$tname."=".str_replace("��",$tvalue,$tInject);
				}else{
					$InjectQuery.=$tname."=".$tvalue;
				}
			}
			//sock injectȣ�� (urlencode�� http���� ���)
			//echo "<BR>sock injectȣ��:".$dataLink["link"]."?".$InjectQuery;
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=null;
			$EnvCtl["LinkDepth"]=$EnvAct["InjectLinkDepth"];
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


//������ Form
function injectForm($EnvCtl,$dataForm){
	global $Env,$EnvAct;
	global $outLink,$AryInjection;

	//�迭�� �ƴϸ� ����
	if(!is_array($dataForm))return;

	$ControlReturnValue=true;

	//���� ���鼭 AryInjection��� �˻�
	for($j=0;$j<count($AryInjection["MSSQL"]) && count($dataForm)>1;$j++){
		$tInject=$AryInjection["MSSQL"][$j];
		//[������ 1] �� ��ü ��ŭ ����
		for($k=1;$k<count($dataForm) && is_array($dataForm);$k++){

			//��Input ���� �����
			if($dataForm[$k]["name"]=="" || $dataForm[$k]["type"]=="FILE")continue; //������ ������ ����

			$InjectForm=$dataForm;
			for($m=1;$m<count($InjectForm);$m++){

				if($InjectForm[$m]["name"]=="")continue;

				$tmpValue=$InjectForm[$m]["value"];
				if($k==$m){
					if($InjectForm[$m]["value"]=="")$InjectForm[$m]["value"]=$Env["FormInputDeafultValue"];
					$InjectForm[$m]["value"]=str_replace("��",$InjectForm[$m]["value"],$tInject);
				}else{
					if($dataForm[$m]["type"]=="FILE"){
						$tmpValue=$Env["AttachFile"];
					}else if($tmpValue=="")$tmpValue=$Env["FormInputDeafultValue"];
					$InjectForm[$m]["value"]=$tmpValue;
				}
			}

			//sockȣ��
			//echo "<BR>sock injectȣ��:".$dataForm[0]["action"]."?".MergeQueryNForm("",$dataForm);
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=null;
			$EnvCtl["LinkDepth"]=$EnvAct["InjectLinkDepth"];

			if($EnvAct["ProcessDotPrint"]=="Y")echo ".";flush();
			$ControlReturnValue=Control(
				$EnvCtl,$tLinkName=$dataForm[0]["actioncgi"],$tOriginQuery=$dataForm[0]["actionquery"],$tInjectQuery=$dataForm[0]["actionquery"],$tOriginForm=$dataForm
				,$InjectForm,$tFormMethod=$dataForm[0]["method"],$tFormEnctype=$dataForm[0]["enctype"]
				);
			if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������
		}
		if($EnvAct["force_404_yn"]<>"Y" && $ControlReturnValue=="404")break; //404���� �̸� 1ȸ��û�ϰ� ������

		//[������ 2] action�� �ִ� ���� Injection
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
					$InjectQuery.=$tname."=".$tInject;
				}else{
					$InjectQuery.=$tname."=".$tvalue;
				}
			}

			//sockȣ��
			//echo "<BR>sock injectȣ��:".$dataForm[0]["action"]."?".MergeQueryNForm("",$dataForm);
			$EnvCtl["isCheckPrint"]=false;
			$EnvCtl["XssLinkDepth"]=null;
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