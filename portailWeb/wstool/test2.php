<?
//echo "<BR>".$_SERVER["SERVER_NAME"];


echo urlencode("1' or 1=1--");

echo urldecode("%27");
echo urldecode("%5F");

echo "<BR>urlencode:".urlencode("abc_001�ѱ�?=&/%+@");
echo "<BR>rawurlencode:".urlencode("abc_001�ѱ�?=&/%+@");
echo "<BR>".eregi("[^a-z0-9]","qiewrsdfsdkfhsh2��342y432421");

echo "<BR>�ѱ��־�?:".eregi("^[��-�R]+$","�ѱ�");
?>