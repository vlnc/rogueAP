<?
//������ go
function GoCheck($EnvCtl,$dataLink,$dataForm){
	global $EnvAct;

	CheckLink($EnvCtl,$dataLink);
	CheckForm($EnvCtl,$dataForm);
}

//üũ Link
function CheckLink($EnvCtl,$dataLink){
	global $Env,$EnvAct;
	global $AryInjection;

	//�迭�� �ƴϸ� ����
	if(!is_array($dataLink))return;

	//�˻�� ���ۿ� �߰���
	$EnvCtl["isAddBuffer"]=true;

	//��ũ ���� ���鼭ó��
	for($i=0;$i<count($dataLink);$i++){

		//�̹� ó�� �ߴ��� �˻�(������true����, ������ ������ false����)
		if(
			$EnvAct["EXCEPT_URL"][strtoupper($dataLink[$i]["link"])] == "Y" || 
			CheckOutExist($EnvCtl,$tLinkName=$dataLink[$i]["link"],$tMergeData=$dataLink[$i]["query"],$tCheckType="ALL")
			)continue;

		//�˻��׸� ���
		PrintCheckNum($dataLink[$i]["url"],$EnvCtl["Parent_doc"],$FormMethod="GET");

		//inject check
		GoInject($EnvCtl,$dataLink[$i],$dataForm=null);

		//xss check
		GoXss($EnvCtl,$dataLink[$i],$dataForm=null);

		//nextgo�� ������
		GoNext($EnvCtl,$dataLink[$i],$dataForm=null);

	}
}


//üũ Form
function CheckForm($EnvCtl,$dataForm){
	global $Env,$EnvAct;
	global $outLink,$AryInjection;

	//�迭�� �ƴϸ� ����
	if(!is_array($dataForm))return;

	//�˻�� ���ۿ� �߰�����
	$EnvCtl["isAddBuffer"]=true;

	//������ ��ŭ ����
	for($i=0;$i<count($dataForm);$i++){		
		//echo "<BR>dataForm $i:".$dataForm[$i][0]["action"];

		//�̹� ó�� �ߴ��� �˻�(������true����, ������ ������ false����)
		if(	$EnvAct["EXCEPT_URL"][strtoupper($dataForm[$i][0]["actioncgi"])] == "Y" ||
			CheckOutExist(
				$EnvCtl
				,$tLinkName=$dataForm[$i][0]["actioncgi"]
				,$tMergeData=MergeQueryNForm($tQuery=$dataForm[$i][0]["actionquery"],$taryForm=$dataForm[$i])
				,$tCheckType="ALL"
				)
			)continue;

		//�˻��׸� ���
		PrintCheckNum(
			$tTargetUrl=$dataForm[$i][0]["action"]
			,$tParent_doc=$EnvCtl["Parent_doc"]
			,$tFormMethod=$dataForm[$i][0]["method"]
			);

		//inject check
		GoInject($EnvCtl,$tdataLink=null,$dataForm[$i]);

		//xss check
		GoXss($EnvCtl,$tdataLink=null,$dataForm[$i]);

		//nextgo�� ������
		GoNext($EnvCtl,$tdataLink=null,$dataForm[$i]);
	}
}
?>