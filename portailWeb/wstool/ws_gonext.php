<?
//go Next
function GoNext($EnvCtl,$dataLink,$dataForm){
	GoNextLink($EnvCtl,$dataLink);
	GoNextForm($EnvCtl,$dataForm);
}

//go Link
function GoNextLink($EnvCtl,$dataLink){
	global $Env,$EnvAct;


	//��ũ�� ������ ����
	if($dataLink["link"]=="")return;

	//�˻�� ���ۿ� �߰���
	//$EnvCtl["isAddBuffer"]=true;

	//�̹� ó�� �ߴ��� �˻�(������true����, ������ ������ false����)
	//if(CheckOutExist($EnvCtl,$LinkName=$dataLink["link"],$MergeData=$dataLink["query"],$CheckType="ALL"))return;

	//[���� ȣ��] sockȣ��
	//echo "<BR>sockȣ��:".$dataLink["url"];
	$EnvCtl["isCheckPrint"]=false;
	$EnvCtl["XssLinkDepth"]=null;
	Control(
		$EnvCtl,$LinkName=$dataLink["link"],$OriginQuery=$dataLink["query"],$InjectQuery=$dataLink["query"],$OriginForm=null
		,$InjectForm=null,$FormMethod="GET",$FormEnctype=null
	);

}

//go Form
function GoNextForm($EnvCtl,$dataForm){
	global $Env,$EnvAct;

	//�迭�� �ƴϸ� ����
	if(!is_array($dataForm))return;

	//�˻�� ���ۿ� �߰���
	/*
	$EnvCtl["isAddBuffer"]=true;

	
	//�̹� ó�� �ߴ��� �˻�(������true����, ������ ������ false����)
	if(	CheckOutExist(
			$EnvCtl,$LinkName=$dataForm[0]["actioncgi"],$MergeData=MergeQueryNForm($Query=$dataForm[0]["actionquery"],$aryForm=$dataForm)
			,$CheckType="ALL"
			)
		)return;
	*/	

	//sockȣ��
	//echo "<BR>sockȣ��:".$dataForm[0]["action"];
	$EnvCtl["isCheckPrint"]=false;
	$EnvCtl["XssLinkDepth"]=null;
	Control(
		$EnvCtl,$LinkName=$dataForm[0]["actioncgi"],$OriginQuery=$dataForm[0]["actionquery"],$InjectQuery=$dataForm[0]["actionquery"],$OriginForm=$dataForm
		,$InjectForm=$dataForm,$FormMethod=$dataForm[0]["method"],$FormEnctype=$dataForm[0]["enctype"]
		);

}
?>