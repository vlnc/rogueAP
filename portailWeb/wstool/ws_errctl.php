<?
function ErrCtl($EnvCtl,$LinkName,$OriginQuery,$InjectQuery,$OriginForm,$InjectForm,$FormMethod,$tAry){
	global $Env,$EnvAct;
	global $whitespace;
	global $AryXss;
	global $p_type,$reg_str_form,$reg_str_input,$p_typefile;//���Խİ���

	//�迭�� �ƴϸ� �Լ� ����
	if(!is_array($tAry)) return;

	$HeaderStatusCode=$tAry["HEADER"]["STATUSCODE"];

	$OriginMergeData=MergeQueryNForm($OriginQuery,$OriginForm);
	$InjectMergeData=MergeQueryNForm($InjectQuery,$InjectForm);

	//������ ���� ��ũ�� ���� 4xx,5xx
	if($EnvAct["ERR_2xx_YN"]=="Y" && eregi("[2][0-9]{2}",$HeaderStatusCode) &&$tAry["HEADER"][strtoupper("Content-Length")]!=0){
		ErrMsg($HeaderStatusCode,$FontColor="black");
		errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
	//������� �м��ؼ� ������� ������ 404�� ���� ���
	}else if($EnvAct["ERR_4xx_YN"]=="Y" && $tAry["HEADER"][strtoupper("Content-Length")]==0){
		$HeaderStatusCode="404";
		ErrMsg($HeaderStatusCode,$FontColor="black");
		errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
	}else if($EnvAct["ERR_4xx_YN"]=="Y" && eregi("[4][0-9]{2}",$HeaderStatusCode)){
		ErrMsg($HeaderStatusCode,$FontColor="black");
		errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
	}else if($EnvAct["ERR_5xx_YN"]=="Y" && eregi("[5][0-9]{2}",$HeaderStatusCode)){
		ErrMsg($HeaderStatusCode,$FontColor="black");
		errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
	}
	
	//���� ���ε� �˻��϶�
	if($EnvAct["ERR_FILEFORM_YN"]=="Y" 
		&& eregi($reg_str_form,$tAry["BODY"]) 
		&& eregi($p_typefile,$tAry["BODY"])
		){
		$HeaderStatusCode="200FILE";
		ErrMsg($HeaderStatusCode,$FontColor="vilot");
		errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);		
	}

	//if($EnvAct["ERR_500SQL_YN"]=="Y" && eregi("[5][0-9]{2}",$HeaderStatusCode)){
	if($EnvAct["ERR_500SQL_YN"]=="Y"){
		//sql server����
		if(eregi("varchar",$tAry["BODY"]) && eregi("",$tAry["BODY"]) ){
			$HeaderStatusCode="500SQLP";
			ErrMsg($HeaderStatusCode,$FontColor="red");
			errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
		}else //sql server����
		if(eregi("80040e14",$tAry["BODY"]) || eregi("SQL Server error",$tAry["BODY"]) ){
			$HeaderStatusCode="500SQL";
			ErrMsg($HeaderStatusCode,$FontColor="red");
			errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,$HeaderStatusCode,$FormMethod,$InjectQuery,$InjectForm);
		}
		//Access Driver ����(���������)
		if(eregi("Access Driver",$tAry["BODY"]) ){
			$HeaderStatusCode="500Access";
			ErrMsg($HeaderStatusCode,$FontColor="black");
		}
		//ADODB 800a0d5d ����(���������)
		if(eregi("800a0d5d",$tAry["BODY"]) || eregi("ADODB",$tAry["BODY"]) ){
			$HeaderStatusCode="500ADO";
			ErrMsg($HeaderStatusCode,$FontColor="black");
		}
		//ADODB 800a0d5d ����(���������)
		if(eregi("JET Database",$tAry["BODY"]) ){
			$HeaderStatusCode="500JET";
			ErrMsg($HeaderStatusCode,$FontColor="black");
		}
	}

	//xss���� �˻�
	if(!is_null($EnvCtl["XssLinkDepth"]) && $EnvCtl["XssLinkDepth"]>0 && $EnvAct["ERR_200XSS_YN"]){
		//echo "<BR>Xss�˻����";
		foreach ($AryXss as $Str => $Reg){
			if(eregi($Reg,$tAry["BODY"])){
				ErrMsg($HeaderStatusCode="200XSS",$FontColor="black");
				errLink($EnvCtl,$LinkName,"Y",$OriginMergeData,$InjectMergeData,"200XSS",$FormMethod,$InjectQuery,$InjectForm);
			}
		}
	}
}



//500���� ��ũ ����
function errLink($EnvCtl,$tLink,$ParamYN,$OriginMergeData,$InjectMergeData,$ErrCode,$FormMethod,$InjectQuery,$InjectForm){
	global $Env;
	global $errLink;

	if($Env["f_debug_yn"]){
		echo "<BR><BR>errLink";
		echo "<BR>tLink:".$tLink;
		echo "<BR>$ParamYN:".$ParamYN;
		echo "<BR>OriginMergeData:".$OriginMergeData;
		echo "<BR>ErrQueryString:".$ErrQueryString;
		echo "<BR>Parent_doc:".$EnvCtl["Parent_doc"];
	}

	//������ ���� �ϴ��� �˻�
	for($j=0;$j<count($errLink);$j++){
		if(strtoupper($errLink[$j][0])==strtoupper($tLink)){
			//�Ķ���Ͱ� �����ϸ� �ֱ�
			if( ($ParamYN=="Y"||$errLink[$j][1]=="Y")){
				//�̹� ������ �����ڵ�� �Ķ���Ͱ� ������ ��ũ�� ������ ���
				for($t=0;$t<count($errLink[$j][3]);$t++)
					if($ErrCode==$errLink[$j][3][$t][1] && $InjectMergeData==$errLink[$j][3][$t][0])return;
				//echo " ������ũ(�Ķ�)���� ";

				$errLink[$j][1]="Y";
			}else if($ParamYN=="N" && $errLink[$j][1]=="N"){
				//�Ķ���Ͱ� ������� �����ڵ尡 �ٸ���� �߰�
				for($t=0;$t<count($errLink[$j][3]);$t++)
					if($ErrCode==$errLink[$j][3][$t][1])return;
				//echo " ������ũ���� ";

				$errLink[$j][1]="N";
			}

			//�����ڵ� �����ͱ��� ������ �߰�
			if($Env["f_debug_yn"])echo "<BR>������ũ �߰�1:".$EnvCtl["Parent_doc"];

			$errLink[$j][2]++;
			$errLink[$j][3][count($errLink[$j][3])]=array($InjectMergeData,$ErrCode,$InjectQuery,$InjectForm);
			$errLink[$j][4]=$EnvCtl["Parent_doc"];
			$errLink[$j][5]=$OriginMergeData;
			$errLink[$j][6]=$FormMethod;

			return;
		}
	}
	//��ũ��,�Ķ���Ϳ���,�Ķ����üũ��,������Ʈ���迭
	if($Env["f_debug_yn"])echo "<BR>������ũ �ű�2:".$EnvCtl["Parent_doc"];
	//echo "<BR>$ErrCode �߰�";	
	$errLink[count($errLink)]=array($tLink,$ParamYN,1,array(array($InjectMergeData,$ErrCode,$InjectQuery,$InjectForm)),$EnvCtl["Parent_doc"],$OriginMergeData,$FormMethod);
	//echo "\n�ƿ���ũ ������ :".count($errLink);
}
?>