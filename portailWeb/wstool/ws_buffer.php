<?
//�˻��� ��ũ �߰�
function fnOutLink($EnvCtl,$tLink,$MergeData,$CheckType){
	global $Env;
	global $outLink;
	global $EnvAct;

	if(strlen($MergeData)>0){
		$ParamYN="Y";
	}else{
		$ParamYN="N";
	}

	//������ ���� �ϴ��� �˻�
	for($j=0;$j<count($outLink);$j++){
		if(strtoupper($outLink[$j][0])==strtoupper($tLink)){
			if($ParamYN=="Y")$outLink[$j][1]="Y";
			//echo sprintf("<br>fnOutLink  %s  %d %d ��",$tLink,$outLink[$j][8][$CheckType],$EnvAct["LimitParamCnt"]);
			
			//�ƿ���ũ�� �߰�
			//echo " �߰�";
			//$outLink[$j][1]="Y";
			$outLink[$j][2]++;
			$outLink[$j][3][count($outLink[$j][3])]=$MergeData;
			$outLink[$j][4]=$EnvCtl["Parent_doc"];
			$outLink[$j][5]=$EnvCtl["TargetHost"];
			$outLink[$j][6]=$EnvCtl["TargetPort"];
			$outLink[$j][7]=$EnvCtl["TargetType"];
			if(is_numeric($outLink[$j][8][$CheckType])){
				$outLink[$j][8][$CheckType]++;
			}else{
				$outLink[$j][8][$CheckType]=1;
			}
			//echo "<BR>fnOutLink �߰�:".$CheckType." ".$tLink."?".$MergeData;

			return;
		}
	}
	//��ũ��,�Ķ���Ϳ���,�Ķ����üũ��,������Ʈ���迭
	//echo "��1";
	//echo "<BR>fnOutLink �ű�:".$CheckType." ".$tLink."?".$MergeData;
	$outLink[count($outLink)]=array(strtoupper($tLink),$ParamYN,1,array($MergeData),$EnvCtl["Parent_doc"],$EnvCtl["TargetHost"],$EnvCtl["TargetPort"],$EnvCtl["TargetType"],array($CheckType => 1));
	//echo "\n�ƿ���ũ ������ :".count($outLink);
}

//���� ����Ʈ�� �̹� �����ϴ��� �˻�
function CheckOutExist($EnvCtl,$LinkName,$MergeData,$CheckType){
	global $Env,$EnvAct;
	global $outLink;

	$LinkName=strtoupper($LinkName);
	if(strlen($MergeData)>0){
		$ParamYN="Y";
	}else{
		$ParamYN="N";
	}
	//echo "<BR>�Ķ����:".strlen($MergeData);
	//������ ���� �ϴ��� �˻�
	for($j=0;$j<count($outLink);$j++){
		if($LinkName==$outLink[$j][0]){
			if($ParamYN=="Y")$outLink[$j][1]="Y";
			//echo sprintf("<br>CheckOutExist %s %s %d %d ��",$LinkName,$MergeData,$outLink[$j][8][$CheckType],$EnvAct["LimitParamCnt"]);
			//echo " <font color=blue>����</font> ";
			if(
				$outLink[$j][1]=="Y" 
				&& is_numeric($outLink[$j][8][$CheckType]) 
				&& $outLink[$j][8][$CheckType]>=$EnvAct["LimitParamCnt"]){//�Ķ���� �����ϰ� �Ķ����üũ���Ѽ�������
				//echo " <font color=gray>�Ķ��ְ� �����ʰ�</font> ";
				return true;
			}else if($outLink[$j][1]=="N" && is_numeric($outLink[$j][8][$CheckType]) && $outLink[$j][8][$CheckType]>0){
				//echo " <font color=gray>�Ķ����� �̹�ó��</font> ";
				return true;				
			}else if($outLink[$j][1]=="Y"){
				//�̹� ��ϵ� ������Ʈ�� ����Ʈ�� �ִ��� �˻�
				for($k=0;$k<count($outLink[$j][3]);$k++)if($outLink[$j][3][$k]==$MergeData){
					//echo " <font color=gray>�����ϰ� �Ķ���ġ</font> ";
					return true;
				}
			}
		}
	}
	//echo " <font color=gray>���� ����</font> ";

	//�������� ���� ��� �߰��ϰ� ����
	if($EnvCtl["isAddBuffer"])fnOutLink($EnvCtl,$LinkName,$MergeData,$CheckType);
	return false;
}

?>