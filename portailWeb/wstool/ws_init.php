<?
$Env["pro_info"]="Server Error & SQL Injection Sacnner";
$Env["pro_han_info"]="���� ���� �� ���� ���Կ��� ��ĳ��";
$Env["ver_info"]="0.14001";
////////////////////////////////////////////////////////////////////////////////////////
//		���üũ
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
//		������/XSS ��Ʈ��
////////////////////////////////////////////////////////////////////////////////////////
/*
											
���뿡��:1 and 1<>char(14)	, 1' and 1<>char(14)		
												üũ���� ������	���Ӹ�üũ��		replace��
where [] and [] and a=$a 				$a		1', 5"							3 and
where [] and [] and b='$b'				$b 		'2, "6								
where [] and [] and $c like '%$d%'		$c				
										$d			
select 1,2,$e,4 from []					$e			

	1)' or''=' 
	2) ' or 1=1-- 
	3) ' or 'a'='a-- 
	4) 'or'='or' 
	5) " or 1=1-- 
	6��or 1=1-- 
	7�� or 'a'='a 
	8��" or "a"="a 
	9�� ') or ('a'='a 
	10�� ") or ("a"="a 
	11�� �� or (1=1 

	12)	' and [] and ''='
	13)	' and [] and '%25'='
	14)	and []
	
	webfuzzer
	{ "yop"		,	TFSAP	},
	{ "6,6"		,	TFSAP   },
	{ "'OR"		,	TFSAP   },
	{ "OR'"  	,	TFSAP   },
	{ "yop'"	,	TFSAP   },
	{ "'yop"	,	TFSAP   },


asp ����Ŭ����
Microsoft OLE DB Provider for Oracle error '80040e14' 

ORA-00932: inconsistent datatypes 

/job/HRNewsV.asp, line 30 



	--��밡��
	',", or 1<>Char(14), " or 1<>Char(14), ') or 1<>Char(14), ") or 1<>Char(14),) or 1<>Char(14)
	convert(1,char(14))
	1+char(14)
	page �κ� ������ ����
*/
//$AryInjection["MSSQL"]=array("1 and 1<>char(14) ","1' and 1<>char(14) ","1'", "5\""," 3 and ");
$AryInjection["MSSQL"]=array(
	"�� or char(14)<>1","�� or char(14)<>1--","�� or char(14)<>1)--"					//int
	,"��' or char(14)<>1 or ''='","��' and char(14)<>1--","��' and char(14)<>1)--"	//str
	,"char(14)<>1 and ��","char(14)<>1--","char(14)<>1)--"							//col name
	);

$AryXss=array(//xxs, ���Խ�
			"<script>alert(1)</script>"=>"<script>alert\(1\)<\/script>"
			,"<script>alert('1')</script>"=>"<script>alert\(\'1\'\)<\/script>"
			,"<script>alert(\"1\")</script>"=>"<script>alert\(\"1\"\)<\/script>"
			);
$AryAdminFolder=array("2004","2005","admin","admin_index","admin_admin","index_admin","admin/index","admin/default","admin/manage","admin/login","../admin/index","../admin/default","../admin/manage","../admin/login","manage","login","manage_index","index_manage","wocaonima","admin1","admin_login","login_admin","ad_login","ad_manage","count","login","manage","manager","adminlogin","adminuserlogin","admin_login","adm_login","chklogin","chkadmin","user","users","adduser","adminuser","admin_user","edituser","adduser","adminadduser","member","members","editmember","adminmember","addmember","logout","exit","login_out","edit","adminedit","admin_edit","delete","admindelete","admin_delete","del","admindel","admin_del","up","upload","upfile","backup","config","test","webmaster","root","aadmin","admintab","admin_main","main","art","article","databases","database","db","dbase","devel","file","files","forum","girl","girls","htdocs","htdocs","idea","ideas","include","includeinc","includes","incoming","install","manual","misc","mrtg","private","program","programming","programs","public","secret","secrets","server_stats","server-info","server-status","set","setting","setup","***","snmp","source","sources","sql","stat","statistics","Stats","stats","telephone","temp","temporary","tool","tools","usage","weblog","weblogs","webstats","work","wstats","wwwlog","wwwstats","www"//wis ����
		,"sysadmin" //���� �߰�
		,"adm","administrator" //nkito
		,"Admin","cgi-bin","cgi-local","cgi-win","cgi","includes","java","backup","config","administration","Administration","private","internal","priv","shtml" //wcgichk
		);

////////////////////////////////////////////////////////////////////////////////////////
//		���ð���
////////////////////////////////////////////////////////////////////////////////////////
$isExecuteWeb=true;		//������ ���������� ����
if($_SERVER["REMOTE_ADDR"]=="")$isExecuteWeb=false;

if(!$isExecuteWeb){
	//DOS
	$f_host=$argv[1];
	$f_port=$argv[2];
	$f_method=$argv[3];
	$f_html_doc=$argv[4];

	
	$Env["runtime"]=0;					//���ѽð�����
	$Env["CheckNumLimit"]=10000;		//�˻��� ��ü ��
	$Env["form_check_yn"]="Y";			//���˻�


	//�˻��� ����
	$Env["ERR_FILEFORM_YN"]="Y";			//���� ���α� �˻�
	$Env["ERR_2xx_YN"]="N";
	$Env["ERR_3xx_YN"]="N";
	$Env["ERR_4xx_YN"]="N";
	$Env["ERR_5xx_YN"]="N";
	$Env["ERR_500SQL_YN"]="Y";
	$Env["ERR_200XSS_YN"]="N";

}else{
	//WEB

	$Env["runtime"]=60*10;				//120�� ����ð�����
	$Env["CheckNumLimit"]=100;			//�˻��� ��ü ��
	$Env["form_check_yn"]="N";			//���˻�

	//�˻��� ����
	$Env["ERR_FILEFORM_YN"]="Y";
	$Env["ERR_2xx_YN"]="N";
	$Env["ERR_3xx_YN"]="N";
	$Env["ERR_4xx_YN"]="N";
	$Env["ERR_5xx_YN"]="N";
	$Env["ERR_500SQL_YN"]="Y";
	$Env["ERR_200XSS_YN"]="Y";
}


//��� ��ȣ=>�� ��Ī
SetEnvHeader();

$Env["f_debug_yn"]=false;	//true/false
$Env["FormInputDeafultValue"]="1";		//POST��� input��ü���� ���� ������ �̰ɳ־ ��û, GET����� ������ ���µ��� ��û
$Env["f_scrollbar"]="<script>scrollTo(0,document.body.scrollHeight);</script>";
$Env["LimitParamCnt"]=3; //�Ķ���� ������ ��� ���� cgi�� ���ؼ� ������ Ƚ��
$Env["DelayParamTime"]=0;
$Env["CheckNum"]=0;			//ȭ�鿡 �ѷ��� ���� üũ��
$Env["time_load"]="";			//����ð�
//$EnvAct["folder_yn"]="Y";			//���� ������ �˻�
$Env["self_action_yn"]="Y";
$Env["script_action_yn"]="Y";
$Env["force_404_yn"]="N";
$Env["ProcessDotPrint"]="N";
$Env["LinkDepth"]=null;		//null ���Ѵ� �Ǵ� ����
$Env["InjectLinkDepth"]=0;		//null ���Ѵ� �Ǵ� ����
$Env["AttachFile"]="ws_sample.gif";		//÷������ ./�������� �ִ� ����


//������ /admin, /manager �� �˻� 
$Env["ADMIN_FOLDER_YN"]="Y";

////////////////////////////////////////////////////////////////////
//		�ܺ� �Է����� �ҷ�����
////////////////////////////////////////////////////////////////////
$TargetHost=trim($f_host);
$TargetPort=trim($f_port);
$TargetMethod=trim($f_method);
$RootUrl=trim($f_html_doc);
$TargetUrl=$RootUrl;
$EnvAct["folder_yn"]=$f_subfolder_yn;

//��Ʈ���� ���ϱ�
list($h1,$h2)=split("\?",$RootUrl,2);
$root_folder=substr( $h1, 0, strrpos( $h1, '/', -2 ) )."/";
$EnvAct["form_check_yn"]=$f_form_check_yn;
if($EnvAct["form_check_yn"]!="Y" && $EnvAct["form_check_yn"]!="N")$EnvAct["form_check_yn"]=$Env["form_check_yn"];

$EnvAct["CheckNumLimit"]=$f_CheckNumLimit;
if(!is_numeric($EnvAct["CheckNumLimit"]))$EnvAct["CheckNumLimit"]=$Env["CheckNumLimit"];
$EnvAct["runtime"]=$f_runtime;
if(!is_numeric($EnvAct["runtime"]))$EnvAct["runtime"]=$Env["runtime"];
set_time_limit($EnvAct["runtime"]);
$EnvAct["LimitParamCnt"]=$f_LimitParamCnt;
if(!is_numeric($EnvAct["LimitParamCnt"]))$EnvAct["LimitParamCnt"]=$Env["LimitParamCnt"];
$EnvAct["self_action_yn"]=trim($f_self_action_yn);
if($EnvAct["self_action_yn"]!="Y" && $EnvAct["self_action_yn"]!="N")$EnvAct["self_action_yn"]=$Env["self_action_yn"];
$EnvAct["ADMIN_FOLDER_YN"]=trim($f_ADMIN_FOLDER_YN);
if($EnvAct["ADMIN_FOLDER_YN"]=="")$EnvAct["ADMIN_FOLDER_YN"]=$Env["ADMIN_FOLDER_YN"];
$tmp=split(",",trim($f_EXCEPT_URL));
for($i=0;$i<count($tmp);$i++){
	if($tmp[$i]=="")continue;
	$EnvAct["EXCEPT_URL"][strtoupper($tmp[$i])]="Y";
}
$EnvAct["script_action_yn"]=trim($f_script_action_yn);
if($EnvAct["script_action_yn"]!="Y" && $EnvAct["script_action_yn"]!="N")$EnvAct["script_action_yn"]=$Env["script_action_yn"];
$EnvAct["force_404_yn"]=trim($f_force_404_yn);
if($EnvAct["force_404_yn"]!="Y" && $EnvAct["force_404_yn"]!="N")$EnvAct["force_404_yn"]=$Env["force_404_yn"];
$EnvAct["ProcessDotPrint"]=trim($f_ProcessDotPrint);
if($EnvAct["ProcessDotPrint"]!="Y" && $EnvAct["ProcessDotPrint"]!="N")$EnvAct["ProcessDotPrint"]=$Env["ProcessDotPrint"];
$EnvAct["LinkDepth"]=trim($f_LinkDepth);
if(!is_numeric($EnvAct["LinkDepth"]))$EnvAct["LinkDepth"]=$Env["LinkDepth"];
$EnvAct["InjectLinkDepth"]=trim($f_LinkDepth);
if(!is_numeric($EnvAct["InjectLinkDepth"]))$EnvAct["InjectLinkDepth"]=$Env["InjectLinkDepth"];


//��������
$EnvAct["ERR_4xx_YN"]=trim($f_ERR_4xx_YN);
if($EnvAct["ERR_4xx_YN"]!="Y" && $EnvAct["ERR_4xx_YN"]!="N")$EnvAct["ERR_4xx_YN"]=$Env["ERR_4xx_YN"];
$EnvAct["ERR_5xx_YN"]=trim($f_ERR_5xx_YN);
if($EnvAct["ERR_5xx_YN"]!="Y" && $EnvAct["ERR_5xx_YN"]!="N")$EnvAct["ERR_5xx_YN"]=$Env["ERR_5xx_YN"];
$EnvAct["ERR_500SQL_YN"]=trim($f_ERR_500SQL_YN);
if($EnvAct["ERR_500SQL_YN"]!="Y" && $EnvAct["ERR_500SQL_YN"]!="N")$EnvAct["ERR_500SQL_YN"]=$Env["ERR_500SQL_YN"];
$EnvAct["ERR_200XSS_YN"]=trim($f_ERR_200XSS_YN);
if($EnvAct["ERR_200XSS_YN"]!="Y" && $EnvAct["ERR_200XSS_YN"]!="N")$EnvAct["ERR_200XSS_YN"]=$Env["ERR_200XSS_YN"];
$EnvAct["ERR_FILEFORM_YN"]=trim($f_ERR_FILEFORM_YN);
if($EnvAct["ERR_FILEFORM_YN"]!="Y" && $EnvAct["ERR_FILEFORM_YN"]!="N")$EnvAct["ERR_FILEFORM_YN"]=$Env["ERR_FILEFORM_YN"];


////////////////////////////////////////////////////////////////////
//		���Խ�
////////////////////////////////////////////////////////////////////
//�����ҽ�ũ��Ʈ ����Ʈ
$elist="zip|pdf|zip|rar|gz|tar|doc|ppt|xls|msi|txt|log|swf|alz|xls|txt|tgz";

//��ũ��Ʈ ����Ʈ
$slist="asp|php|php3|jsp|htm|html|aspx|cgi|nhn|js|css";
//The hex codes are space, tab, line feed, vertical tab, form feed, carriage return
$whitespace = "\x20\x09\x0a\x0b\x0C\x0d";
$linkpattern = ":#\/\=\&a-zA-Z0-9\-\_\?\.\%\+\;\(\)";
$NonQuotaLink=	"(http://".$TargetHost."|https://".$TargetHost."){0,1}([^\#\"][".$linkpattern."]*)";
$QuotaLink=		"(http://".$TargetHost."|https://".$TargetHost."){0,1}([^\#\"][".$linkpattern.$whitespace."]*)";

//��ũ ����
$reg_link_type="href|action|location|src|url";		//url�� ��Ÿ�ױ� reflash���� ���

//���˻� ���Խ�
$p_qvalue ="[".$whitespace."]*(\"[^\"]*\"|\'[^\']*\'|[^\>\'\"".$whitespace."]*[".$whitespace."\>])";
$p_qvaluefile ="[".$whitespace."]*(\"FILE\"|\'FILE\'FILE[".$whitespace."\>])";

$p_method	="method[".$whitespace."]*\=".$p_qvalue;
$p_action	="action[".$whitespace."]*\=".$p_qvalue;
$p_name		="name[".$whitespace."]*\=".$p_qvalue;
$p_enctype	="enctype[".$whitespace."]*\=".$p_qvalue;
$p_onsubmit	="onsubmit[".$whitespace."]*\=".$p_qvalue;
$p_type		="type[".$whitespace."]*\=".$p_qvalue;
$p_typefile	="type[".$whitespace."]*\=".$p_qvaluefile;

$p_value		="value[".$whitespace."]*\=".$p_qvalue;

$reg_str_form="\<form[^\>]+\>";
$reg_str_form_end="\<\/form[^\>]*\>";
$reg_str_formDetail="\<(input|textarea|select)[".$whitespace."]+([^\>]+)\>";

$reg_str_input="\<input[".$whitespace."]+([^\>]+)\>";
$reg_str_select="\<select[".$whitespace."]+([^\>]+)\>";
$reg_str_textarea="\<textarea[".$whitespace."]+([^\>]+)\>";

//500���� ��ũ ����
$errLink=array();
//ó���� ��ũ��
$outLink=array();


//��� ����
function SetEnvHeader(){
	global $Env;
	$Env["HeaderStatusCode"]=array(
		"100" => "Continue"
		,"101" => "Switching Protocols"
		,"200" => "OK"
		,"201" => "Created"
		,"202" => "Accepted"
		,"203" => "Non-Authoritative Information"
		,"204" => "No Content"
		,"205" => "Reset Content"
		,"206" => "Partial Content"
		,"300" => "Multiple Choices"
		,"301" => "Moved Permanently"
		,"302" => "Found"
		,"303" => "See Other"
		,"304" => "Not Modified"
		,"305" => "Use Proxy"
		,"306" => "(Unused)"
		,"307" => "Temporary Redirect"
		,"400" => "Bad Request"
		,"401" => "Unauthorized"
		,"402" => "Payment Required"
		,"403" => "Forbidden"
		,"404" => "Not Found"
		,"405" => "Method Not Allowed"
		,"406" => "Not Acceptable"
		,"407" => "Proxy Authentication Required"
		,"408" => "Request Timeout"
		,"409" => "Conflict"
		,"410" => "Gone"
		,"411" => "Length Required"
		,"412" => "Precondition Failed"
		,"413" => "Request Entity Too Large"
		,"414" => "Request-URI Too Long"
		,"415" => "Unsupported Media Type"
		,"416" => "Requested Range Not Satisfiable"
		,"417" => "Expectation Failed"
		,"500" => "Internal Server Error"
		,"501" => "Not Implemented"
		,"502" => "Bad Gateway"
		,"503" => "Service Unavailable"
		,"504" => "Gateway Timeout"
		,"505" => "HTTP Version Not Supported"
		,"500SQL" => "SQL Server Error"
		,"500SQLP" => "SQL Server Perfect"
		,"500SQLS" => "SQL Server Syntax"
		,"500ACCESS" => "Access Driver"
		,"500ADO" => "ADODB"
		,"500JET" => "JET Database"
		,"200XSS" => "Cross Site Scripting"
		,"200FILE" => "File Upload Form"
		);
}
?>