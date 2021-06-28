<?
session_start();?>
<html>
<head>
	<META content="text/html; charset=windows-1251" http-equiv=Content-Type />

	<SCRIPT LANGUAGE="JavaScript">
		function Search_Text(ID_Data, ID_Docum, TextDoc, Target) {
			SearchText = window.open("../SearchText_View.php?ID_Data=" + ID_Data + "&ID_Docum=" + ID_Docum + "&TextDoc=" + TextDoc, Target, "toolbar=no,location=no,directoties=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=" + (screen.width-10) + ",height=" + (screen.height-55) + ",left=0,top=0");
		}

		function OpenHREF(S_DELO,TIPDELA,VIDDELA,ID_DELO,TIP_DOCUM){
			var WND=window.open("Kartochka.php"+"?ID="+S_DELO+"&TIP_DELA="+TIPDELA+"&VID_DELA="+VIDDELA+"&TIP_DOCUM="+TIP_DOCUM+"&ID_DELO="+ID_DELO, "KART", "toolbar=no,location=no,directoties=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=400,left=400,top=200");
			WND.focus();

		}

		function Search_ConnectDocum(ID_DocSr, ID_Docum, nTypeDocum, UniqNum) {
			if (nTypeDocum == 1) {
				SearchConnectDocum = window.open("../l_form_edit.php?0.2.." + ID_Docum + ".", "_blank", "toolbar=no,location=no,directoties=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=" + (screen.width-10) + ",height=" + (screen.height-55) + ",left=0,top=0");
			}
			else {
				SearchConnectDocum = window.open("../sp_view_jour.php?id=" + ID_DocSr, "_blank", "toolbar=no,location=no,directoties=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=" + (screen.width-10) + ",height=" + (screen.height-55) + ",left=0,top=0");
			}
		}
		function close_button() {

		document.getElementById('pbSave').style.display='none';

		}
	</SCRIPT>
</head>
<?

include('../common.func');

function sv_VERDICT_BY_BSR($VERDICT_ID_AGORA, $VERDICT_ID_AGORA2, &$DOC_TYPE){
$VNCODE=0;
/*Административка 1-ой инстанции*/
if ($VERDICT_ID_AGORA==70090002){ return $VNCODE=103;}
else if ($VERDICT_ID_AGORA==70090003){ $DOC_TYPE="Постановление"; return $VNCODE=104;}
else if ($VERDICT_ID_AGORA==70090004){ $DOC_TYPE="Определение"; return $VNCODE=105;}
else if ($VERDICT_ID_AGORA==70090005){ return $VNCODE=106;}
else if ($VERDICT_ID_AGORA==70090006){ $DOC_TYPE="Определение"; return $VNCODE=107;}

else if ($VERDICT_ID_AGORA==70090000 or $VERDICT_ID_AGORA==40030000){$DOC_TYPE="Постановление"; return $VNCODE=101; }
else if ($VERDICT_ID_AGORA==70090001 or $VERDICT_ID_AGORA==40030001){ $DOC_TYPE="Постановление"; return $VNCODE=102;}
else if ($VERDICT_ID_AGORA==40030002){$DOC_TYPE="Определение"; return $VNCODE=105; }
else if ($VERDICT_ID_AGORA==40030003){ $DOC_TYPE="Определение"; return $VNCODE=107;}
else if ($VERDICT_ID_AGORA==40030004){ $DOC_TYPE="Определение";  return $VNCODE=104;}

/*Административка 1-ый пересмотр, 2-ой пересмотр, надзор*/
if ($VERDICT_ID_AGORA==70100000 or $VERDICT_ID_AGORA==70030002 or $VERDICT_ID_AGORA==70050002){ $DOC_TYPE="Решение"; return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==70200000 ){return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==70100001 or $VERDICT_ID_AGORA==70030003 or $VERDICT_ID_AGORA==70050003){$DOC_TYPE="Решение";  return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==70100002 or $VERDICT_ID_AGORA==70030004 or $VERDICT_ID_AGORA==70050004){$DOC_TYPE="Решение";  return $VNCODE=203;}
else if ($VERDICT_ID_AGORA==70100003 or $VERDICT_ID_AGORA==70030005 or $VERDICT_ID_AGORA==70050005){$DOC_TYPE="Решение";  return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==70100004 or $VERDICT_ID_AGORA==70030006 or $VERDICT_ID_AGORA==70050006){ return $VNCODE=205;}

else if ($VERDICT_ID_AGORA==70200008 and $VERDICT_ID_AGORA2==70100000){$DOC_TYPE="Решение"; return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==70200008 and $VERDICT_ID_AGORA2==70200000){ $DOC_TYPE="Решение"; return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==70200008 and $VERDICT_ID_AGORA2==70100002){ $DOC_TYPE="Решение"; return $VNCODE=203;}


else if ($VERDICT_ID_AGORA==331010001){return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==331010005 or $VERDICT_ID_AGORA==331010007 or $VERDICT_ID_AGORA==331010009 or $VERDICT_ID_AGORA==70005){return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==331010002 or $VERDICT_ID_AGORA==70007){return $VNCODE=203;}
else if ($VERDICT_ID_AGORA==331010003 or $VERDICT_ID_AGORA==70006){return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==331010004){return $VNCODE=205;}

/*Уголовка 1-ая инстанция*/
if ($VERDICT_ID_AGORA==51230000){$DOC_TYPE="Приговор"; return $VNCODE=101;}
else if ($VERDICT_ID_AGORA==51230001){$DOC_TYPE="Приговор"; return $VNCODE=102;}
else if ($VERDICT_ID_AGORA==51230004){$DOC_TYPE="Постановление"; return $VNCODE=117;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240000){ return $VNCODE=105;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240001){ return $VNCODE=105;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240002){ return $VNCODE=114;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240003){ return $VNCODE=115;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240004){ return $VNCODE=111;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240006){ return $VNCODE=110;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240008){ return $VNCODE=106;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240009){ return $VNCODE=108;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240011){ return $VNCODE=116;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240015){ return $VNCODE=109;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240017){ return $VNCODE=110;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240019){ return $VNCODE=112;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240020){ return $VNCODE=107;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240021){ return $VNCODE=113;}
else if ($VERDICT_ID_AGORA==51230004 and $VERDICT_ID_AGORA2==51240022){ return $VNCODE=109;}
else if ($VERDICT_ID_AGORA==51230005){ return $VNCODE=103;}

/*Уголовка апелляционная инстанция*/
else if ($VERDICT_ID_AGORA==51220000){return $VNCODE=401;}
else if ($VERDICT_ID_AGORA==51220001){return $VNCODE=402;}
else if ($VERDICT_ID_AGORA==51220011){return $VNCODE=403;}
else if ($VERDICT_ID_AGORA==51220012){return $VNCODE=404;}
else if ($VERDICT_ID_AGORA==51220014){return $VNCODE=405;}
else if ($VERDICT_ID_AGORA==51220013){return $VNCODE=406;}
else if ($VERDICT_ID_AGORA==51220015){return $VNCODE=407;}
else if ($VERDICT_ID_AGORA==51220016){return $VNCODE=408;}
else if ($VERDICT_ID_AGORA==51220017){return $VNCODE=409;}
else if ($VERDICT_ID_AGORA==51220003){return $VNCODE=410;}
else if ($VERDICT_ID_AGORA==51220018){return $VNCODE=410;}
else if ($VERDICT_ID_AGORA==51220019){return $VNCODE=411;}
else if ($VERDICT_ID_AGORA==51220004){return $VNCODE=411;}
else if ($VERDICT_ID_AGORA==51220100){return $VNCODE=413;}
else if ($VERDICT_ID_AGORA==51220100 and $VERDICT_ID_AGORA2==51240003){return $VNCODE=415;}

/*Уголовка Кассация*/
else if ($VERDICT_ID_AGORA==50170000){$DOC_TYPE="Определение"; return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==50170001 and $VERDICT_ID_AGORA2==50170002){ $DOC_TYPE="Определение"; return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==50170001 and $VERDICT_ID_AGORA2==50170003){ $DOC_TYPE="Определение"; return $VNCODE=205;}
else if ($VERDICT_ID_AGORA==50170001 and $VERDICT_ID_AGORA2==50170011){ $DOC_TYPE="Определение"; return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170015){ $DOC_TYPE="Определение"; return $VNCODE=209;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170016){ $DOC_TYPE="Определение"; return $VNCODE=209;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170018){ $DOC_TYPE="Определение"; return $VNCODE=209;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170013){ $DOC_TYPE="Определение"; return $VNCODE=208;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170014){ $DOC_TYPE="Определение"; return $VNCODE=207;}
else if ($VERDICT_ID_AGORA==50170012 and $VERDICT_ID_AGORA2==50170025){ $DOC_TYPE="Определение"; return $VNCODE=206;}
else if ($VERDICT_ID_AGORA==50170033){ $DOC_TYPE="Определение"; return $VNCODE=212;}

/*Уголовка Надзор*/
else if ($VERDICT_ID_AGORA==11070001 and $VERDICT_ID_AGORA2==11080001){ return $VNCODE=302;}
else if ($VERDICT_ID_AGORA==11070001 and $VERDICT_ID_AGORA2==11080002){ return $VNCODE=303;}
else if ($VERDICT_ID_AGORA==11070001 and $VERDICT_ID_AGORA2==11080003){ return $VNCODE=304;}
else if ($VERDICT_ID_AGORA==11070001 and $VERDICT_ID_AGORA2==11080004){ return $VNCODE=305;}
else if ($VERDICT_ID_AGORA==11070002 and $VERDICT_ID_AGORA2==11080011){ return $VNCODE=308;}
else if ($VERDICT_ID_AGORA==11070002 and $VERDICT_ID_AGORA2==11080012){ return $VNCODE=309;}
else if ($VERDICT_ID_AGORA==11070002 and $VERDICT_ID_AGORA2==11080010){ return $VNCODE=307;}
else if ($VERDICT_ID_AGORA==11070003 and $VERDICT_ID_AGORA2==11080020){ return $VNCODE=310;}
else if ($VERDICT_ID_AGORA==11070003 and $VERDICT_ID_AGORA2==11080021){ return $VNCODE=311;}
else if ($VERDICT_ID_AGORA==11070004 and $VERDICT_ID_AGORA2==11080030){ return $VNCODE=312;}
else if ($VERDICT_ID_AGORA==11070004 and $VERDICT_ID_AGORA2==11080031){ return $VNCODE=313;}
else if ($VERDICT_ID_AGORA==11070005 and $VERDICT_ID_AGORA2==11080040){ return $VNCODE=314;}
else if ($VERDICT_ID_AGORA==11070005 and $VERDICT_ID_AGORA2==11080041){ return $VNCODE=315;}
else if ($VERDICT_ID_AGORA==11070006){ return $VNCODE=317;}
else if ($VERDICT_ID_AGORA==11070006 and $VERDICT_ID_AGORA2==11080050){ return $VNCODE=320;}
else if ($VERDICT_ID_AGORA==11070006 and $VERDICT_ID_AGORA2==11080051){ return $VNCODE=321;}
else if ($VERDICT_ID_AGORA==11070007 and $VERDICT_ID_AGORA2==11080001){ return $VNCODE=302;}

/*Гражданка 1-ая инстанция*/
else if ($VERDICT_ID_AGORA==50640000){ return $VNCODE=101;}
else if ($VERDICT_ID_AGORA==50640001){ return $VNCODE=101;}
else if ($VERDICT_ID_AGORA==50640005 or $VERDICT_ID_AGORA==50640002){ return $VNCODE=102;}
else if ($VERDICT_ID_AGORA==50640007){ return $VNCODE=104;}
else if ($VERDICT_ID_AGORA==50640112 or $VERDICT_ID_AGORA==50640004){ return $VNCODE=105;}
else if ($VERDICT_ID_AGORA==50640003 or $VERDICT_ID_AGORA==50640113){$DOC_TYPE="Определение"; return $VNCODE=103;}

else if ($VERDICT_ID_AGORA==50640100){ return $VNCODE=401;}
else if ($VERDICT_ID_AGORA==50640101){ return $VNCODE=402;}
else if ($VERDICT_ID_AGORA==50640102){ return $VNCODE=402;}
else if ($VERDICT_ID_AGORA==50640103){ return $VNCODE=203;}
else if ($VERDICT_ID_AGORA==50640104){ return $VNCODE=206;}
else if ($VERDICT_ID_AGORA==50640105){ return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==50640106){ return $VNCODE=404;}
else if ($VERDICT_ID_AGORA==50640107){ return $VNCODE=205;}
else if ($VERDICT_ID_AGORA==50640200){ return $VNCODE=408;}
else if ($VERDICT_ID_AGORA==11020002){ return $VNCODE=102;}
else if ($VERDICT_ID_AGORA==11020003){ return $VNCODE=103;}

/*Гражданка апелляция*/
else if ($VERDICT_ID_AGORA==50640100){$DOC_TYPE="Определение"; return $VNCODE=401;}
else if ($VERDICT_ID_AGORA==50640104){$DOC_TYPE="Решение"; return $VNCODE=407;}
else if ($VERDICT_ID_AGORA==50640103 or $VERDICT_ID_AGORA==50640111){$DOC_TYPE="Определение"; return $VNCODE=403;}
else if ($VERDICT_ID_AGORA==50640105  or $VERDICT_ID_AGORA==50640106){return $VNCODE=404;}
else if ($VERDICT_ID_AGORA==50640107  or $VERDICT_ID_AGORA==50640108){return $VNCODE=405;}

/*Гражданка кассация*/
else if ($VERDICT_ID_AGORA==50440000){ return $VNCODE=201;}
else if ($VERDICT_ID_AGORA==50440001){ return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==50440002){ return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==50440003){ return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==50440004){ return $VNCODE=204;}
else if ($VERDICT_ID_AGORA==50440005){ return $VNCODE=205;}
else if ($VERDICT_ID_AGORA==50440006){ return $VNCODE=205;}
else if ($VERDICT_ID_AGORA==50440007){ return $VNCODE=206;}
else if ($VERDICT_ID_AGORA==50440020){ return $VNCODE=206;}
else if ($VERDICT_ID_AGORA==50440008){ return $VNCODE=203;}
else if ($VERDICT_ID_AGORA==50440021){ return $VNCODE=203;}
else if ($VERDICT_ID_AGORA==50440009){ return $VNCODE=202;}
else if ($VERDICT_ID_AGORA==50440010){ return $VNCODE=207;}
else if ($VERDICT_ID_AGORA==50440011){ return $VNCODE=207;}
else if ($VERDICT_ID_AGORA==50440012){ return $VNCODE=204;}

/*Гражданка надзор*/
else if ($VERDICT_ID_AGORA==11020001){ return $VNCODE=302;}
else if ($VERDICT_ID_AGORA==11020002){ return $VNCODE=304;}
else if ($VERDICT_ID_AGORA==11020003){ return $VNCODE=303;}
else if ($VERDICT_ID_AGORA==11020004){ return $VNCODE=305;}
else if ($VERDICT_ID_AGORA==11020006){ return $VNCODE=309;}
else if ($VERDICT_ID_AGORA==11020007){ return $VNCODE=308;}
else if ($VERDICT_ID_AGORA==11020008){ return $VNCODE=310;}
else if ($VERDICT_ID_AGORA==11020010){ return $VNCODE=312;}
else if ($VERDICT_ID_AGORA==11020090){ return $VNCODE=304;}
else if ($VERDICT_ID_AGORA==11020091){ return $VNCODE=313;}
else if ($VERDICT_ID_AGORA==11020100){ return $VNCODE=301;}

else {return $VNCODE=-1;}
}

function GetNameByCod($dbcnx,$nCod){
	if ($nCod<>""){
		$stmt1 = JosPrepareAndExecute($dbcnx,'SELECT USERNAME FROM GroupContent@IBASEDATA where GROUPcontentid='.$nCod);
		ocifetch($stmt1);
		if (ociresult($stmt1,"USERNAME")<>""){
			//oci_free_statement($stmt1);
			return ociresult($stmt1,"USERNAME");
		}
		else {
			$stmt1 = JosPrepareAndExecute($dbcnx,"select NAME from CatalogContent@IBASEDATA where contentid=".$nCod);
			ocifetch($stmt1);
			//oci_free_statement($stmt1);
			return ociresult($stmt1,"NAME");
		}
	}
}

function svFindParamMater($dbcnx,&$Date_Validite,$value,&$TypeID,&$NUMDELA,&$VERDICTDELA,&$DELOVERDICT,&$STATYA,&$FIO,&$status){
	$r=0;
	$Date_Validite='';
	while ($r<15){
		$FIO[$r]="";
		$status[$r]="";
		$r=$r+1;
	}
	$stmt = JosPrepareAndExecute($dbcnx,"SELECT M_TYPE,TO_CHAR(VALIDITY_DATE,'dd.MM.yyyy') as VALIDITY_DATE,JUDICIAL_POSITION_ID,NAME,DEPTOR,DEPOSITOR,M_SUB_TYPE,CLERK_ID,DECLARANT,
	BAILIFF,ID,FULL_NUMBER,TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,VERDICT_ID,JUDGE_ID,null as CASE_NUMBER_I FROM M_CASE@ibasedata I WHERE I.ID=".$value);
	ocifetch($stmt);

	$DELOTYPE=ociresult($stmt,"M_TYPE");//вид материала
	if (ociresult($stmt,"VALIDITY_DATE") == ''){}
	else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"VALIDITY_DATE")));}

	$stmt1 = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND vncode='04'");
	$TypeID = ociresult($stmt1,"IDITEM");
	oci_free_statement($stmt1);

	$NUMDELA=ociresult($stmt,"FULL_NUMBER");//номер дела
	$VERDICTDELA=ociresult($stmt,"VERDICT_ID");//результат рассмотрения дела
	$DELOVERDICT=DATE('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE")));//дата вынесения постановления
	$STATYA=ociresult($stmt,"M_SUB_TYPE");
	$i=0;
	if (ociresult($stmt,"JUDGE_ID")<>""){
		$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
		$status[$i]='Судья';
		$i=$i+1;
	}

	if (ociresult($stmt,"DECLARANT")<>""){
		$FIO[$i]=ociresult($stmt,"DECLARANT");
		$status[$i]='Лицо, заявившее ходатайство';
		$i=$i+1;
	}
	if (ociresult($stmt,"NAME")<>""){
		$FIO[$i]=ociresult($stmt,"NAME");
		$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDICIAL_POSITION_ID"));
		if ($status[$i]=='') {$status[$i]='Осужденный';}
		$i=$i+1;
	}
}

function svFindParamUgol($dbcnx,&$Date_Validite,$TIP_DELA,$AgoraID,&$NUM_DOC,&$DATE_DOC,&$Stage,&$RESULT_AGORA,&$RESULT_AGORA2,&$KSA_SUD,&$TypeID,&$FIO,&$status,&$statya,&$NumDocFirst,&$STATYA_ALL,&$UID){
	$r=0;
	while ($r<15){
		$FIO[$r]="";
		$status[$r]="";
		$r=$r+1;
	}
	$Date_Validite='';
	 $stmt = OCIParse($dbcnx, "select ZAVNUMKSA from PARAM_NASTR");
ociexecute($stmt, OCI_DEFAULT);
while(ocifetch($stmt)){
	$ZAVNUMK = ociresult($stmt,'ZAVNUMKSA');
	$ZAVNUMK = substr ($ZAVNUMK,2,2);
}

	$RESULT_AGORA=0;
	$RESULT_AGORA2=0;
	//$TypeID=731201;
	$stmt = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND vncode='01'");
	$TypeID = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	$i=0;
	if ($TIP_DELA=='115'){
		$Stage="Надзор";
		if ($_SESSION["SXEMA"]==1){
			$STR_SELECT_UGOL="SELECT FULL_NUMBER,(select t.VERDICT_ID from U33_COMPLAINT@IBASEDATA t where t.PROC_ID = I.ID and t.ENTRY_DATE=I.LAST_UPDATED) as GALOBA_VERDICT,
            (select TO_CHAR(t.VERDICT_DATE,'dd.MM.yyyy') from U33_COMPLAINT@IBASEDATA t where t.PROC_ID = I.ID and t.ENTRY_DATE=I.LAST_UPDATED)
                as GALOBA_DATA,VERDICT_BY_PROTEST as VERDICT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,null as CASE_NUMBER_I,
            null as CERTIORARI_JUDGE_ID,COURT_I_JUDGE_ID as JUDGE_I,PRESIDING_JUDGE as SPEAKER,null as VALIDITY_DATE,
            CASS_SPEAKER_ID as SPEAKER_II,PRESIDING_JUDGE_III as PRESIDING_JUDGE,null as CASE_NUMBER_I,
            CASS_PRESIDING_ID as    PRESIDING_JUDGE_II,null as JUDGE_PEACE,null as THIRD_JUDGE_ID2,null as THIRD_JUDGE_ID,
            null as JUDGE_PEACE FROM U33_PROCEEDING@IBASEDATA I where I.ID=".$AgoraID;

			$STRSELECT='select NAME,LAW_ARTICLE,VERDICT_I_1 as VERDICT_1,VERDICT_I_2 as VERDICT_2 from U33_PARTS@IBASEDATA where PROC_ID='.$AgoraID;
		}
		else {
			$STRSELECT='SELECT NAME,LOW_ARTICLE as LAW_ARTICLE,VERDICT_I_1 as VERDICT_1,VERDICT_I_2 as VERDICT_2 FROM U3_CASE_DEFENDANT@IBASEDATA where CASE_ID='.$AgoraID;
			$STR_SELECT_UGOL="select PROTEST_FULL_NUMBER as FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,null as VALIDITY_DATE,
			VERDICT_BY_PROTEST as VERDICT_ID,CASE_NUMBER_I,CERTIORARI_JUDGE_ID,JUDGE_I,PRESIDING_JUDGE as SPEAKER,
			PRESIDING_JUDGE_II,PRESIDING_JUDGE_III as PRESIDING_JUDGE,SPEAKER_II,THIRD_JUDGE_ID,THIRD_JUDGE_ID2,JUDGE_PEACE
			from U3_CASE@IBASEDATA where id=".$AgoraID;}
		}
	else if (($TIP_DELA==114 and ($ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV')) or
			 ($TIP_DELA==112 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV'))) {

		if ($TIP_DELA==114) {
			$Stage="Кассация";
		} else {
			$Stage="Апелляция";
		}
		$STR_SELECT_UGOL="select FULL_NUMBER,VERDICT_II_ID as VERDICT_ID, TO_CHAR(VERDICT_II_DATE,'dd.MM.yyyy') as VERDICT_DATE,
		INCOMMING_I_NUMBER as CASE_NUMBER_I,ACCUSER,JUDGE_I,CLERK,JUDGE_PEACE_ID as JUDGE_PEACE,PRESIDING_APP_JUDGE,PRESIDING_JUDGE,SPEAKER,null as VALIDITY_DATE,
		THIRD_JUDGE_ID,THIRD_JUDGE_ID2 from U2_CASE@IBASEDATA where id=".$AgoraID;

		$STRSELECT='SELECT NAME,LOW_ARTICLE_I as LAW_ARTICLE,VERDICT_II_ID as VERDICT_1,VERDICT_II_ID2 as VERDICT_2 FROM U2_DEFENDANT@IBASEDATA where CASE_ID='.$AgoraID;


	}
    	else if ($TIP_DELA==114 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV')){
             $Stage="Кассация";

            $STR_SELECT_UGOL="SELECT FULL_NUMBER,(select t.VERDICT_ID from U33_COMPLAINT@IBASEDATA t where t.PROC_ID = I.ID and t.ENTRY_DATE=I.LAST_UPDATED) as GALOBA_VERDICT,
            (select TO_CHAR(t.VERDICT_DATE,'dd.MM.yyyy') from U33_COMPLAINT@IBASEDATA t where t.PROC_ID = I.ID and t.ENTRY_DATE=I.LAST_UPDATED)
                as GALOBA_DATA,VERDICT_BY_PROTEST as VERDICT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,null as CASE_NUMBER_I,
            null as CERTIORARI_JUDGE_ID,COURT_I_JUDGE_ID as JUDGE_I,PRESIDING_JUDGE as SPEAKER,null as VALIDITY_DATE,
            CASS_SPEAKER_ID as SPEAKER_II,PRESIDING_JUDGE_III as PRESIDING_JUDGE,null as CASE_NUMBER_I,
            CASS_PRESIDING_ID as    PRESIDING_JUDGE_II,null as JUDGE_PEACE,null as THIRD_JUDGE_ID2,null as THIRD_JUDGE_ID,
            null as JUDGE_PEACE FROM U33_PROCEEDING@IBASEDATA I where I.ID=".$AgoraID;

			$STRSELECT='select NAME,LAW_ARTICLE,VERDICT_I_1 as VERDICT_1,VERDICT_I_2 as VERDICT_2 from U33_PARTS@IBASEDATA where PROC_ID='.$AgoraID;

	}



	else if (($TIP_DELA==112 and $ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV') or ($TIP_DELA==113)){
       if ($TIP_DELA==112)    {
	   $Stage="Апелляция";
	   }
	   else              {
	   $Stage="Первая инстанция";
	   }

		$STRSELECT='SELECT NAME,VERDICT_LAW_ART as LAW_ARTICLE,VERDICT_ID as VERDICT_1,VERDICT_ID2 as VERDICT_2 FROM U1_DEFENDANT@IBASEDATA where CASE_ID='.$AgoraID;
		$STR_SELECT_UGOL="select FULL_NUMBER, JUDICIAL_UID, TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,VERDICT_ID,CASE_TYPE_ID,A_CASE_NUMBER_I as CASE_NUMBER_I,null as SPEAKER, null as PRESIDING_JUDGE,
		ADJUTANT_ID,A_JUDGE_I_ID as JUDGE_PEACE,A_RET_JUDGE_ID,CLERK_ID,JUDGE_ID, TO_CHAR(VALIDITY_DATE,'dd.MM.yyyy') as VALIDITY_DATE
		from U1_CASE@IBASEDATA where id=".$AgoraID;

	}


	$stmt1 = JosPrepareAndexecute($dbcnx,$STRSELECT);
	while(ocifetch($stmt1)){
	if (ociresult($stmt1,"NAME") <> ""){
		$FIO[$i]=ociresult($stmt1,"NAME");
		if ($TIP_DELA=='115'){$status[$i]='Осужденный';}
		else {$status[$i]='Подсудимый';}
		$statya[$i]=ociresult($stmt1,"VERDICT_1").'.'.ociresult($stmt1,"VERDICT_2");
		$i=$i+1;
	}
		$STATYA_ALL=ociresult($stmt1,"LAW_ARTICLE");
		$RESULT_AGORA=ociresult($stmt1,"VERDICT_1");
		$RESULT_AGORA2=ociresult($stmt1,"VERDICT_2");
	}
	oci_free_statement($stmt1);

	$stmt=JosPrepareAndExecute($dbcnx,$STR_SELECT_UGOL);
	ocifetch($stmt);
	$NUM_DOC = ociresult($stmt,"FULL_NUMBER");		// номер дела
        $UID = ociresult($stmt,"JUDICIAL_UID");                 // номер УИД
	if (preg_match("/[A-Z]/", ociresult($stmt,"VERDICT_DATE"))==0){	$DATE_DOC=ociresult($stmt,"VERDICT_DATE");}
	else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE"))); }

	if ($DATE_DOC == '' and (($TIP_DELA=='115' and $_SESSION["SXEMA"]==1) or ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV'))   )
		{$DATE_DOC = date('d.m.Y',strtotime(ociresult($stmt,"GALOBA_DATA")));}

	$VERDICT_ID = ociresult($stmt,"VERDICT_ID");	// вердикт по делу общий
	if ($VERDICT_ID == '' and $TIP_DELA=='115' and $_SESSION["SXEMA"]==1){// вердикт по делу общий
		$VERDICT_ID = ociresult($stmt,"GALOBA_VERDICT");
	}
	$NumDocFirst = ociresult($stmt,"CASE_NUMBER_I");// номер дела первой инстанции
	if (ociresult($stmt,"VALIDITY_DATE") == ''){}
	else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"VALIDITY_DATE")));}
	if (ociresult($stmt,"JUDGE_PEACE") <> ""){
		$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_PEACE"));
		$status[$i]="Мировой судья";
		$i=$i+1;
	}
	if (ociresult($stmt,"SPEAKER") <> ""){
		$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"SPEAKER"));
		$status[$i]="Докладчик";
		$i=$i+1;
	}
	if (ociresult($stmt,"PRESIDING_JUDGE") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_JUDGE"));
			$status[$i]="Председательствующий в составе";
			$i=$i+1;
		}
	if (($TIP_DELA=='115') or ($TIP_DELA==114 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV'))){
		if (ociresult($stmt,"CERTIORARI_JUDGE_ID") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"CERTIORARI_JUDGE_ID"));
			$status[$i]="Судья, изучивший истребованное дело";
			$i=$i+1;
		}
		if (ociresult($stmt,"JUDGE_I") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_I"));
			$status[$i]="Федеральный судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"PRESIDING_JUDGE_II") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_JUDGE_II"));
			$status[$i]="Судья, председательствующий в кассационной инстанции";
			$i=$i+1;
		}
		if (ociresult($stmt,"SPEAKER_II") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"SPEAKER_II"));
			$status[$i]="Докладчик в кассационной инстанции";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID"));
			$status[$i]="В составе судей - третий судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID2") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID2"));
			$status[$i]="В составе судей - второй судья";
			$i=$i+1;
		}
	}
	else if(($TIP_DELA==114 and ($ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV')) or
			 ($TIP_DELA==112 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV'))) {
		if (ociresult($stmt,"ACCUSER") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"ACCUSER"));
			$status[$i]="Прокурор";
			$i=$i+1;
		}
		if (ociresult($stmt,"JUDGE_I") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_I"));
			$status[$i]="ФИО судьи федерального (районного) суда";
			$i=$i+1;
		}
		if (ociresult($stmt,"PRESIDING_APP_JUDGE") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_APP_JUDGE"));
			$status[$i]="Председательствующий в апелляционной инстанции";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID"));
			$status[$i]="В составе судей - третий судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID2") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID2"));
			$status[$i]="В составе судей - второй судья";
			$i=$i+1;
		}

		$STRSELECT="SELECT NAME,PARTS_TYPE_ID FROM U2_PARTS@IBASEDATA where CASE_ID=".$AgoraID;
		$stmt1 = JosPrepareAndExecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt1)){
			$FIO[$i]=ociresult($stmt1,"NAME");
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt1,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt1);
	}
	else if (($TIP_DELA==112 and $ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV') or $TIP_DELA==113){
		if ($TIP_DELA==112) {
			$Stage="Апелляция";
		} else {
			$Stage="Первая инстанция";
		}

		if (ociresult($stmt,"A_RET_JUDGE_ID") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"A_RET_JUDGE_ID"));
			$status[$i]="Мировой судья, которому возвращено дело";
			$i=$i+1;
		}
		if (ociresult($stmt,"JUDGE_ID") <> "") {
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
			$status[$i]="Председательствующий судья";
			$i=$i+1;
		}
		$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM U1_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt1 = JosPrepareAndExecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt1)){
			$FIO[$i]=ociresult($stmt1,"NAME");
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt1,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt1);
	}
	oci_free_statement($stmt);
}

function svFindParamAdm($dbcnx,&$Date_Validite,$TIP_DELA,$AgoraID,&$NUM_DOC,&$DATE_DOC,&$Stage,&$RESULT_AGORA,&$RESULT_AGORA2,&$KSA_SUD,&$TypeID,&$FIO,&$status,&$NumDocFirst,&$STATYA_ALL,&$ANAT,&$UID){
	$r=0;
	while ($r<15){
		$FIO[$r]="";
		$status[$r]="";
		$r=$r+1;
	}
	$RESULT_AGORA=0;
	$RESULT_AGORA2=0;
	$Date_Validite='';
	//$TypeID=731205;
	$stmt = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND vncode='01'");
	$TypeID = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);


	$i=0;
	$stmt = JosPrepareAndExecute($dbcnx,"select ESSENCE as ANAT,TO_CHAR(TAKE_LAW_EFFECT_DATE,'dd.MM.yyyy') as TAKE_LAW_EFFECT_DATE,CASE_NUMBER,JUDICIAL_UID, TO_CHAR(DECREE_DATE,'dd.MM.yyyy') as DECREE_DATE,DECREE_ID,JUDGE_ID from adm_case@IBASEDATA where id=".$AgoraID);
	ocifetch($stmt);
	$NUM_DOC=ociresult($stmt,"CASE_NUMBER");

	if ($NUM_DOC==""){
		$stmt = JosPrepareAndExecute($dbcnx,"select ESSENCE as ANAT,TO_CHAR(TAKE_LAW_EFFECT_DATE,'dd.MM.yyyy') as TAKE_LAW_EFFECT_DATE,TO_CHAR(DECREE_DATE,'dd.MM.yyyy') as DECREE_DATE,DECREE_ID,CASE_NUMBER,JUDICIAL_UID,DECREE_ID,CASE_NUMBER_I,LAW_ARTICLES1,JUDGE_I,JUDGE_ID,DECLARANT_STATUS_ID,DECLARANT_NAME,DEFENDANT_STATUS_ID,DEFENDANT_NAME from adm1_case@IBASEDATA where id=".$AgoraID);
		ocifetch($stmt);

		$NUM_DOC=ociresult($stmt,"CASE_NUMBER");
		if ($NUM_DOC==""){
			$stmt = JosPrepareAndExecute($dbcnx,"select ESSENCE as ANAT,NULL AS TAKE_LAW_EFFECT_DATE,CASE_NUMBER,JUDGE_II,SECRETARY_ID,DECLARANT_NAME,JUDGE_ID,DEFENDANT_STATUS_ID,DEFENDANT_NAME, TO_CHAR(DECREE_DATE,'dd.MM.yyyy') as DECREE_DATE,DECLARANT_STATUS_ID,DECREE_ID,LAW_ARTICLES1,CASE_NUMBER_I,JUDGE_I from adm2_case@IBASEDATA where id=".$AgoraID);
			ocifetch($stmt);
			$NUM_DOC=ociresult($stmt,"CASE_NUMBER");

			if ($NUM_DOC==""){
				$stmt = JosPrepareAndExecute($dbcnx,"select ESSENCE as ANAT,NULL AS TAKE_LAW_EFFECT_DATE,PRESIDING_JUDGE,PROTEST_FULL_NUMBER,JUDGE_II,DEFENDANT_STATUS_ID,DEFENDANT_NAME,DECLARANT_STATUS_ID,DECLARANT_NAME,CERTIORARI_JUDGE_ID,JUDGE_I,LAW_ARTICLES1,CASE_NUMBER_I,VERDICT_0_CANCELED,VERDICT_1_CANCELED,VERDICT_2_CANCELED, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as PROTEST_VERDICT_DATE,VERDICT_BY_PROTEST,VERDICT_BY_PROTEST from ADM3_CASE@IBASEDATA where id=".$AgoraID);
				ocifetch($stmt);
				$NUM_DOC=ociresult($stmt,"PROTEST_FULL_NUMBER");
				// новый надзор
				if ($NUM_DOC==""){
					$stmt = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME,JUDGE_ID,DECLARANT_TYPE_ID,DECLARANT_NAME,CHAIRMAN_ASSIST_ID,JUDGE_STUDY_ID,LAW_ARTICLE,TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,VERDICT_ID,FULL_NUMBER from A33_PROCEEDING@IBASEDATA where ID=".$AgoraID);
					ocifetch($stmt);
					$NUM_DOC=ociresult($stmt,"FULL_NUMBER");
					$Stage="Надзор";
					if (preg_match("/[A-Z]/", ociresult($stmt,"VERDICT_DATE"))==0){	$DATE_DOC=ociresult($stmt,"VERDICT_DATE");}
					else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE"))); }
					$RESULT_AGORA=ociresult($stmt,"VERDICT_ID");
					$STATYA_ALL=ociresult($stmt,"LAW_ARTICLE");
					$FIO[$i]=ociresult($stmt,"DECLARANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DECLARANT_TYPE_ID"));
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_STUDY_ID"));
					if ($FIO[$i]<>""){
						$status[$i]="Передано на рассмотрение судье";
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
					if ($FIO[$i]<>""){
						$status[$i]="Судья";
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"CHAIRMAN_ASSIST_ID"));
					if ($FIO[$i]<>""){
						$status[$i]="Зам.председателя";
						$i=$i+1;
					}

					$FIO[$i]=ociresult($stmt,"DEFENDANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]="Правонарушитель";
						$i=$i+1;
					}
					$STATYA_ALL=ociresult($stmt,"LAW_ARTICLE");
				}
				else{
					if (preg_match("/[A-Z]/", ociresult($stmt,"PROTEST_VERDICT_DATE"))==0){	$DATE_DOC=ociresult($stmt,"PROTEST_VERDICT_DATE");}
					else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"PROTEST_VERDICT_DATE")));}
					$Stage="Надзор";
					$ANAT = ociresult($stmt,"ANAT");
					$RESULT_AGORA=ociresult($stmt,"VERDICT_BY_PROTEST");
					if (ociresult($stmt,"TAKE_LAW_EFFECT_DATE") == ''){}
					else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"TAKE_LAW_EFFECT_DATE")));}
					if (ociresult($stmt,"VERDICT_2_CANCELED")<>""){$RESULT_AGORA2=ociresult($stmt,"VERDICT_2_CANCELED");}
					else if (ociresult($stmt,"VERDICT_1_CANCELED")<>""){$RESULT_AGORA2=ociresult($stmt,"VERDICT_1_CANCELED");}
					else {$RESULT_AGORA2=ociresult($stmt,"VERDICT_0_CANCELED");}
					if ($RESULT_AGORA==70050010){$RESULT_AGORA=$RESULT_AGORA2;}
					$STATYA_ALL=ociresult($stmt,"LAW_ARTICLES1");
					$NumDocFirst=ociresult($stmt,"CASE_NUMBER_I");
					$$JUDGE_ID=ociresult($stmt,"JUDGE_I");
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"CERTIORARI_JUDGE_ID"));
					if ($FIO[$i]<>""){
						$status[$i]="Судья, изучивший истребованное дело";
						$i=$i+1;
					}
					$FIO[$i]=ociresult($stmt,"DECLARANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DECLARANT_STATUS_ID"));
						$i=$i+1;
					}
					$FIO[$i]=ociresult($stmt,"DEFENDANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DEFENDANT_STATUS_ID"));
						$i=$i+1;
					}
					if ($JUDGE_ID<>""){
						$FIO[$i]=$status[$i]=GetNameByCod($dbcnx,$JUDGE_ID);
						$status[$i]="Федеральный судья";
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_II"));
					if ($FIO[$i]<>""){
						$status[$i]="ФИО судьи при первом пересмотре";
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_JUDGE"));
					if ($FIO[$i]<>""){
						$status[$i]="Докладчик";
						$i=$i+1;
					}
				}
			}
			else {
				if (preg_match("/[A-Z]/", ociresult($stmt,"DECREE_DATE"))==0){	$DATE_DOC=ociresult($stmt,"DECREE_DATE");}
				else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE"))); }
				if (ociresult($stmt,"TAKE_LAW_EFFECT_DATE") == ''){}
				else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"TAKE_LAW_EFFECT_DATE")));}
					//$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE")));
					$Stage="Второй пересмотр";
					$ANAT = ociresult($stmt,"ANAT");
					$RESULT_AGORA=ociresult($stmt,"DECREE_ID");
					$RESULT_AGORA2=ociresult($stmt,"DECREE_ID");
					$STATYA_ALL=ociresult($stmt,"LAW_ARTICLES1");
					$NumDocFirst=ociresult($stmt,"CASE_NUMBER_I");
					$JUDGE_ID=ociresult($stmt,"JUDGE_I");

					if ($JUDGE_ID<>""){
						$FIO[$i]=GetNameByCod($dbcnx,$JUDGE_ID);
						$status[$i]="ФИО судьи первой инстанции";
						$i=$i+1;
					}
					$FIO[$i]=ociresult($stmt,"DECLARANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DECLARANT_STATUS_ID"));
						$i=$i+1;
					}
					$FIO[$i]=ociresult($stmt,"DEFENDANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DEFENDANT_STATUS_ID"));
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
					if ($FIO[$i]<>""){
						$status[$i]="Передано в производство судье";
						$i=$i+1;
					}
					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_II"));
					if ($FIO[$i]<>""){
						$status[$i]="ФИО судьи второй инстанции";
						$i=$i+1;
					}
				}
		}
		else {
							if (preg_match("/[A-Z]/", ociresult($stmt,"DECREE_DATE"))==0){	$DATE_DOC=ociresult($stmt,"DECREE_DATE");}
						else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE"))); }
	if (ociresult($stmt,"TAKE_LAW_EFFECT_DATE") == ''){}
	else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"TAKE_LAW_EFFECT_DATE")));}
	//		$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE")));
					$Stage="Первый пересмотр";
					$ANAT = ociresult($stmt,"ANAT");
                                        $UID=ociresult($stmt,"JUDICIAL_UID");
					$RESULT_AGORA=ociresult($stmt,"DECREE_ID");
					$NumDocFirst=ociresult($stmt,"CASE_NUMBER_I");
					if ($NumDocFirst=="") {$NumDocFirst=null;}
					$STATYA_ALL=ociresult($stmt,"LAW_ARTICLES1");
					$JUDGE_ID=ociresult($stmt,"JUDGE_I");

					$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
					$status[$i]="Передано в производство судье";
					$i=$i+1;

					$FIO[$i]=ociresult($stmt,"DEFENDANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DEFENDANT_STATUS_ID"));
						$i=$i+1;
					}
					if ($JUDGE_ID<>""){
						$FIO[$i]=GetNameByCod($dbcnx,$JUDGE_ID);
						$status[$i]="ФИО судьи первой инстанции";
						$i=$i+1;
					}
					$FIO[$i]=ociresult($stmt,"DECLARANT_NAME");
					if ($FIO[$i]<>""){
						$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"DECLARANT_STATUS_ID"));
						$i=$i+1;
					}

		}
	}
	else { 					if (preg_match("/[A-Z]/", ociresult($stmt,"DECREE_DATE"))==0){	$DATE_DOC=ociresult($stmt,"DECREE_DATE");}
						else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE"))); }
	if (ociresult($stmt,"TAKE_LAW_EFFECT_DATE") == ''){}
	else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"TAKE_LAW_EFFECT_DATE")));}

		//$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"DECREE_DATE")));;
			$Stage="Первая инстанция";
			$ANAT = ociresult($stmt,"ANAT");
                        $UID=ociresult($stmt,"JUDICIAL_UID");
			$RESULT_AGORA=ociresult($stmt,"DECREE_ID");
			//$NumDocFirst=ociresult($stmt,"CASE_NUMBER");
			if ($NumDocFirst=="") {$NumDocFirst=null;}
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_ID"));
			if ($FIO[$i]<>""){
				$status[$i]="Председательствующий судья";
				$i=$i+1;
			}

			$STRSELECT='SELECT PARTY_NAME,LAW_ARTICLES1,PARTY_TYPE_ID FROM adm_parts@IBASEDATA where CASE_ID='.$AgoraID;
			$stmt = JosPrepareAndExecute($dbcnx,$STRSELECT);
			while(ocifetch($stmt)){
				$FIO[$i]=ociresult($stmt,"PARTY_NAME");
				$STATYA_ALL=ociresult($stmt,"LAW_ARTICLES1");
				$status[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PARTY_TYPE_ID"));
				$i=$i+1;
			}
			oci_free_statement($stmt);
	}

}

function svFindParamGr($dbcnx,$Date_Validite,$Tip,$AgoraID,&$NUM_DOC,&$DATE_DOC,&$Stage,&$RESULT_AGORA,&$RESULT_AGORA2,&$KSA_SUD,&$TypeID,&$FIO,&$status,&$NumDocFirst,&$STATYA,&$STATYA2,&$ANAT,&$UID){
	$r=0;
	while ($r<15){
		$FIO[$r]="";
		$status[$r]="";
		$r=$r+1;
	}
	$Date_Validite='';
	$RESULT_AGORA=0;
	$RESULT_AGORA2=0;

$stmt = OCIParse($dbcnx, "select ZAVNUMKSA from PARAM_NASTR");
ociexecute($stmt, OCI_DEFAULT);
while(ocifetch($stmt)){
	$ZAVNUMK = ociresult($stmt,'ZAVNUMKSA');
	$ZAVNUMK = substr ($ZAVNUMK,2,2);
}
oci_free_statement($stmt);

	$stmt = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND vncode='01'");
	$TypeID = ociresult($stmt,"IDITEM");
	$i=0;
	if ($Tip==113){
		$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM G1_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt2 = JosPrepareAndExecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt2)){
			$FIO[$i]=ociresult($stmt2,"NAME");
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt2);
		$Stage="Первая инстанция";
		$str_zapros = "select null as IST,null as OTV,null as DECLARANT_NAME,FULL_NUMBER,JUDICIAL_UID, TO_CHAR(RESULT_DATE,'dd.MM.yyyy') as VERDICT_DATE,
		RESULT_TYPE_ID,RESULT_ID, TO_CHAR(VALIDITY_DATE,'dd.MM.yyyy') as VALIDITY_DATE, REQ_ESSENCE as ANAT, CATEGORY_ID, CATEGORY_ID2, CASE_TYPE_ID,
		null as COURT_I,null as CASS_SPEAKER_ID, JUDGE_ID as PRESIDING_JUDGE,null as CERTIORARI_JUDGE_ID,null as PRESIDING_JUDGE_III,
		null as THIRD_JUDGE_ID,null as THIRD_JUDGE_ID2, null as JUDGE,null as CASE_NUMBER_I, null as JUDGE_I from G1_CASE@IBASEDATA
		where id=".$AgoraID;
	}
	else if ($Tip==112 and $ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV'){
		$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM G1_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt2 = JosPrepareAndExecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt2)){
			$FIO[$i]=ociresult($stmt2,"NAME");
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt2);

		$Stage="Апелляция";
		$str_zapros = "select null as IST,null as OTV,null as DECLARANT_NAME,FULL_NUMBER,JUDICIAL_UID,RESULT_ID,
		TO_CHAR(RESULT_DATE,'dd.MM.yyyy') as VERDICT_DATE,CATEGORY_ID, CATEGORY_ID2,RESULT_TYPE_ID,TO_CHAR(VALIDITY_DATE,'dd.MM.yyyy') as VALIDITY_DATE,
		REQ_ESSENCE as ANAT,CASE_TYPE_ID,null as COURT_I,JUDGE_ID as PRESIDING_JUDGE,null as CASS_SPEAKER_ID,A_CASE_NUMBER_I as CASE_NUMBER_I,
		null as CERTIORARI_JUDGE_ID,null as PRESIDING_JUDGE_III,null as THIRD_JUDGE_ID,null as THIRD_JUDGE_ID2,null as JUDGE,null as JUDGE_I
		from G1_CASE@IBASEDATA where id=".$AgoraID;

	}
	else if (($Tip==114 and ($ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV')) or
			 ($Tip==112 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV'))){
		$STRSELECT='SELECT PARTY_NAME,PARTY_TYPE_ID FROM G2_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt2 = JosPrepareAndexecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt2)){
			$FIO[$i]=ociresult($stmt2,"PARTY_NAME");
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTY_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt2);
		if ($Tip==114) {
			$Stage="Кассация";
		} else {
			$Stage="Апелляция";
		}
		$str_zapros = "select null as PRESIDING_JUDGE,null as DECLARANT_NAME,Z_FULLNUMBER as FULL_NUMBER,IDRESH as RESULT_ID,TO_CHAR(DRESALT,'dd.MM.yyyy') as VERDICT_DATE,
		NULL AS VALIDITY_DATE,ESSENCE_STATEMENT as ANAT,IDKATEG as CATEGORY_ID, CATEGORY_ID2,NUMRNS as CASE_NUMBER_I,THIRD_JUDGE_ID,
 		IDDOC as CASS_SPEAKER_ID,null as CERTIORARI_JUDGE_ID,IDPRED as PRESIDING_JUDGE_III,
 		THIRD_JUDGE_ID2,null as JUDGE_I,SUDRNS as COURT_I,IST,null as JUDGE,OTV from GR2_DELO@IBASEDATA where id=".$AgoraID;
	}
	else if ($Tip==114 and ($ZAVNUMK=='OS' or $ZAVNUMK=='OV' or $ZAVNUMK=='KJ' or $ZAVNUMK=='AJ' or $ZAVNUMK=='KV' or $ZAVNUMK=='AV')){
		$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM G3_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt2 = JosPrepareAndexecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt2)){
			$FIO[$i]=str_replace("\"","",ociresult($stmt2,"NAME"));
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt2);
		$Stage="Кассация";
		$str_zapros = "select FULL_NUMBER,NULL as ANAT,NULL AS VALIDITY_DATE,
			CATEGORY_ID,CASS_SPEAKER_ID,PRESIDING_JUDGE,null as CERTIORARI_JUDGE_ID,PRESIDING_JUDGE_III,null as JUDGE_I,
			SATISFIED_VERDICT_I_ID  as RESULT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,
			null as CASE_NUMBER_I,null as THIRD_JUDGE_ID,null as THIRD_JUDGE_ID2, null as COURT_I,null as JUDGE,
    		null as IST,null as OTV,null as DECLARANT_NAME from G33_PROCEEDING@IBASEDATA where id=".$AgoraID;

	}
	else if ($Tip==115){
		$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM G3_PARTS@IBASEDATA where CASE_ID='.$AgoraID;
		$stmt2 = JosPrepareAndexecute($dbcnx,$STRSELECT);
		while(ocifetch($stmt2)){
			$FIO[$i]=str_replace("\"","",ociresult($stmt2,"NAME"));
			$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTS_TYPE_ID"));
			$i=$i+1;
		}
		oci_free_statement($stmt2);
		$Stage="Надзор";
		if ($_SESSION["SXEMA"]==1){
			$str_zapros = "select FULL_NUMBER,NULL as ANAT,NULL AS VALIDITY_DATE,
			CATEGORY_ID,CASS_SPEAKER_ID,PRESIDING_JUDGE,null as CERTIORARI_JUDGE_ID,PRESIDING_JUDGE_III,null as JUDGE_I,
			SATISFIED_VERDICT_I_ID  as RESULT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,
			null as CASE_NUMBER_I,null as THIRD_JUDGE_ID,null as THIRD_JUDGE_ID2, null as COURT_I,null as JUDGE,
    		null as IST,null as OTV,null as DECLARANT_NAME from G33_PROCEEDING@IBASEDATA where id=".$AgoraID;
		}
		else{
			$str_zapros = "select FULL_NUMBER2 as FULL_NUMBER,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,
			SATISFIED_VERDICT_I_ID as RESULT_ID, NULL AS VALIDITY_DATE,ESSENCE as ANAT, SPEAKER_II as CASS_SPEAKER_ID,
   			PRESIDING_JUDGE, CERTIORARI_JUDGE_ID,PRESIDING_JUDGE_III,JUDGE_I, THIRD_JUDGE_ID,THIRD_JUDGE_ID2,COURT_I,
   			CASE_NUMBER_I,CATEGORY_ID,null as IST, null as JUDGE,DECLARANT_NAME,null as OTV from G3_CASE@IBASEDATA where id=".$AgoraID;

			$stmt = JosImmidiate($dbcnx,$str_zapros);
			if (ociresult($stmt,"FULL_NUMBER")==""){
				$STRSELECT='SELECT NAME,PARTS_TYPE_ID FROM G3_COMPL_PARTS@IBASEDATA where COMPLAINT_ID='.$AgoraID;
				$stmt2 = JosPrepareAndexecute($dbcnx,$STRSELECT);
				while(ocifetch($stmt2)){
				$FIO[$i]=str_replace("\"","",ociresult($stmt2,"NAME"));
				$status[$i]=GetNameByCod($dbcnx,ociresult($stmt2,"PARTS_TYPE_ID"));
				$i=$i+1;
				}
				oci_free_statement($stmt2);

				$str_zapros = "select DECLARANT_NAME,FULL_NUMBER,TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,VERDICT as RESULT_ID,
				null as VALIDITY_DATE,ESSENCE as ANAT,SPEAKER_II as CASS_SPEAKER_ID,JUDGE, null as PRESIDING_JUDGE,CASE_NUMBER_I,
				null as CERTIORARI_JUDGE_ID,CATEGORY_ID,null as PRESIDING_JUDGE_III, null as THIRD_JUDGE_ID,null as IST,
				JUDGE_I,null as THIRD_JUDGE_ID2,COURT_I,null as OTV from g3_complaint@ibasedata
				where id=".$AgoraID;
			}
		}
	}
	$stmt = JosImmidiate($dbcnx,$str_zapros);
	$NUM_DOC=ociresult($stmt,"FULL_NUMBER");
	if ($NUM_DOC<>""){

		if ($Tip==113 or ($ZAVNUMK<>'OS' and $ZAVNUMK<>'OV' and $ZAVNUMK<>'KJ' and $ZAVNUMK<>'AJ' and $ZAVNUMK<>'KV' and $ZAVNUMK<>'AV' and $Tip==112)){
			$RESULT_TYPE_ID=ociresult($stmt,"RESULT_TYPE_ID"); //вид судебного постановления
			$CASE_TYPE_ID=ociresult($stmt,"CASE_TYPE_ID"); //вид гражданского производства

		}
		if (preg_match("/[A-Z]/", ociresult($stmt,"VERDICT_DATE"))==0){	$DATE_DOC=ociresult($stmt,"VERDICT_DATE");}
		else {$DATE_DOC=date('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE"))); }
		if ($DATE_DOC == ''){$DATE_DOC = date('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE")));}
		if (ociresult($stmt,"VALIDITY_DATE") == ''){}
		else{$Date_Validite = date('d.m.Y',strtotime(ociresult($stmt,"VALIDITY_DATE")));}
		$RESULT_AGORA=ociresult($stmt,"RESULT_ID");
		$ANAT = ociresult($stmt,"ANAT");
                $UID=ociresult($stmt,"JUDICIAL_UID");
		$STATYA=ociresult($stmt,"CATEGORY_ID");
		$STATYA2=ociresult($stmt,"CATEGORY_ID2");
		if (ociresult($stmt,"CASS_SPEAKER_ID")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"CASS_SPEAKER_ID"));
			$status[$i]="Докладчик в кассационной инстанции";
			$i=$i+1;
		}
		if (ociresult($stmt,"PRESIDING_JUDGE")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_JUDGE"));
			//Дербенев. Изменил "Докладчик" на "Председательствующий судья"
			$status[$i]="Председательствующий судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"DECLARANT_NAME")<>""){
			$FIO[$i]=ociresult($stmt,"DECLARANT_NAME");
			$status[$i]="ФИО заявителя";
			$i=$i+1;
		}
		$NumDocFirst=ociresult($stmt,"CASE_NUMBER_I");
		if (ociresult($stmt,"CERTIORARI_JUDGE_ID")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"CERTIORARI_JUDGE_ID"));
			$status[$i]="Судья, изучивший истребованное дело";
			$i=$i+1;
		}

		if (ociresult($stmt,"PRESIDING_JUDGE_III")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"PRESIDING_JUDGE_III"));
			$status[$i]="Председательствующий в составе";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID"));
			$status[$i]="В составе судей - третий судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"THIRD_JUDGE_ID2")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"THIRD_JUDGE_ID2"));
			$status[$i]="В составе судей - второй судья";
			$i=$i+1;
		}
		if (ociresult($stmt,"JUDGE_I")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE_I"));
			$status[$i]="Судья, председательствующий в первой инстанции";
			$i=$i+1;
		}
		if (ociresult($stmt,"JUDGE_I")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"JUDGE"));
			$status[$i]="Судья, рассмотревший материал";
			$i=$i+1;
		}
	/*	if (ociresult($stmt,"COURT_I")<>""){
			$FIO[$i]=GetNameByCod($dbcnx,ociresult($stmt,"COURT_I"));
			$status[$i]="Федеральный суд";
			$i=$i+1;
		}
*/
		if (ociresult($stmt,"IST")<>""){
			$FIO[$i]=ociresult($stmt,"IST");
			$status[$i]="Истец";
			$i=$i+1;
		}
		if (ociresult($stmt,"OTV")<>""){
			$FIO[$i]=ociresult($stmt,"OTV");
			$status[$i]="Ответчик";
			$i=$i+1;
		}
	}
	oci_free_statement($stmt);
}

function SvFindStr ($svFind){
	$stroka = "";
	$svFind_UK=stristr($svFind,"УПК");
	if ($svFind_UK==""){
		if (strstr($svFind, 'УК РФ')){
			$svFind = trim(str_replace('УК РФ', '', $svFind));
		}
	while ($p=strpos($svFind,"[")){$svFind=substr($svFind,0,$p).substr($svFind,$p+1,strlen($svFind)-$p+1);}
	while ($p=strpos($svFind,"]")){$svFind=substr($svFind,0,$p).substr($svFind,$p+1,strlen($svFind)-$p+1);}
	while ($p=strpos($svFind,"-")){$svFind=substr($svFind,0,$p).substr($svFind,$p+1,strlen($svFind)-$p+1);}
	$svFindDetSt = explode("ст.",$svFind);
	$i=1;
	$h=1;
	while ($svFindDetSt[$i]<>""){
	settype($svFindDetCh[0],"string");
	settype($svFindDetRazd[0],"string");
	$svFindDetSt[$i]=str_replace(";"," ",$svFindDetSt[$i]);
	$svFindDetCh = explode("ч.",$svFindDetSt[$i]);
	if (strlen(trim($svFindDetCh[0])==1)){ $svFindDetCh[0]="00".trim($svFindDetCh[0]); }
	else if (strlen(trim($svFindDetCh[0])==2)){ $svFindDetCh[0]="0".trim($svFindDetCh[0]); }
	$svFindDetP = explode("пп.",$svFindDetCh[1]);
	if ($svFindDetP[1] == "") {$svFindDetP = explode("п.",$svFindDetCh[1]);}
	$svFindDetRazd=explode("/",$svFindDetCh[0]);
	if ($svFindDetRazd[1]==""){
		$svFindDetRazd=explode(".",$svFindDetCh[0]);
		if ($svFindDetRazd[1]==""){
			if ($svFindDetP[1]==""){
				if (strlen(trim($svFindDetCh[0]))==1) {$strFind[$h]="00".trim($svFindDetCh[0]).".0%".trim($svFindDetP[0]).".0";}
				else if (strlen(trim($svFindDetCh[0]))==2) {$strFind[$h]="0".trim($svFindDetCh[0]).".0%".trim($svFindDetP[0]).".0";}
				else{
					if ($svFindDetP[0]==""){$strFind[$h]=trim($svFindDetCh[0]).".0%";}
					else {$strFind[$h]=trim($svFindDetCh[0]).".0%".trim($svFindDetP[0]).".0";}
				}
				$h=$h+1;
			}
			else{
				$stroka=trim($svFindDetCh[0]).".0%".trim($svFindDetP[0]);
				if (strlen($svFindDetCh[0])==1) {$stroka="00".$stroka;}
				if (strlen($svFindDetCh[0])==2) {$stroka="0".$stroka;}
			}
		}
		else {
			if (strlen(trim($svFindDetRazd[0]))==1) {
				if (strlen(trim($svFindDetRazd[1]))==1) {$strFind[$h]="00".trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1])."%".trim($svFindDetCh[1]).".0";}
				else {$strFind[$h]="0".trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1])."%".trim($svFindDetCh[1]).".0";}
 				$h=$h+1;
			}
			else if (strlen(trim($svFindDetRazd[0]))==2) {
				if (strlen(trim($svFindDetRazd[1]))==1) {$strFind[$h]="0".trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1]);}
				else {$strFind[$h]=trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1]);}


				if (strlen(trim($svFindDetCh[1]))==1){$strFind[$h]=$strFind[$h].",%0".trim($svFindDetCh[1]).".0";}
				else if (strlen(trim($svFindDetCh[1]))==3){$strFind[$h]=$strFind[$h].",%0".trim($svFindDetCh[1]);}
				else {$strFind[$h]=$strFind[$h].",%".trim($svFindDetCh[1]).".0";}
				$h=$h+1;
			}
			else{$stroka=trim($svFindDetCh[0])."%".trim($svFindDetP[0]).".0";}
			if ($svFindDetP[0]=="") {$strFind[$h]=trim($svFindDetCh[0]);}
			if ($svFindDetP[1]=="") { $h=$h+1; }
		}
	}
	else{
		if ($svFindDetP[1]=="") {$strFind[$h]=trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1])."%".trim($svFindDetP[0]).".0"; $h=$h+1; }
		else {$stroka=trim($svFindDetRazd[0]).".".trim($svFindDetRazd[1])."%".trim($svFindDetP[0])."%";}
	}
	$svFindDetPp = explode(",",$svFindDetP[1]);
	$k=0;
	while ($svFindDetPp[$k]<>""){
		$strFind[$h]=$stroka."%".trim($svFindDetPp[$k]);
		$k=$k+1;
		$h=$h+1;
	}
$i=$i+1;
}
}
return $strFind;
}

//function  svGrSDPtoBSR($CATEGORY_ID){
//if ($CATEGORY_ID==3213502 or $CATEGORY_ID==3213504){$str[1]=100000;}
//else if ($CATEGORY_ID==3210001){$str[1]=100110;}else if ($CATEGORY_ID==3210002){$str[1]=100210;}
//else if ($CATEGORY_ID==3213003 or $CATEGORY_ID==3213507){$str[1]=110010;}
//else if ($CATEGORY_ID==3210004){$str[1]=120010;}else if ($CATEGORY_ID==3210005){$str[1]=130010;}
//else if ($CATEGORY_ID==3210006){$str[1]=140010;}else if ($CATEGORY_ID==3210051 or $CATEGORY_ID==3210058
//or $CATEGORY_ID==3210066 or $CATEGORY_ID==3210082 or $CATEGORY_ID==3210083 or $CATEGORY_ID==3210084 
//or $CATEGORY_ID==3213003 or $CATEGORY_ID==3213502 or $CATEGORY_ID==3213514 or $CATEGORY_ID==3213525 
//or $CATEGORY_ID==3213526 or $CATEGORY_ID==3213529 or $CATEGORY_ID==3213531 or $CATEGORY_ID==3213533 
//or $CATEGORY_ID==3213535 or $CATEGORY_ID==3213537 or $CATEGORY_ID==3213539 or $CATEGORY_ID==3213540 
//or $CATEGORY_ID==3213542 or $CATEGORY_ID==3213544 or $CATEGORY_ID==3213504 or $CATEGORY_ID==3213506
//or $CATEGORY_ID==3213510){$str[1]=160010;}else if ($CATEGORY_ID==3210067){$str[1]=580012;}
//else if ($CATEGORY_ID==3210069 or $CATEGORY_ID==3213731 or $CATEGORY_ID==3213732){$str[1]=600012;}
//else if ($CATEGORY_ID==3210070){$str[1]=610012;}else if ($CATEGORY_ID==3210071){$str[1]=620012;}
//else if ($CATEGORY_ID==3212360 or $CATEGORY_ID==3212361 or $CATEGORY_ID==3212400 or $CATEGORY_ID==3212401
//or $CATEGORY_ID==3213704){$str[1]=670012;}else if ($CATEGORY_ID==3210078){$str[1]=690012;}
//else if ($CATEGORY_ID==3210079){$str[1]=700012;}
//else {$str[1]=null;}
//return $str[1];

//}

function svSaveBSR(
					$nID_DOCSR,
					$Date_Validite,
					$strSelectDocum1,
					$nUNIQ_NUM,
					$dbcnx,
					$dbuser,
					$sPass,
					$TypeID,
					$NUM_DOC,
					$DATE_DOC,
					$TypeDocumID,
					$TypeDocumID_Others,
					$Stage,
					$KSA_SUD,
					$FIO,
					$status,
					$STATYA_1,
					$STATYA_2,
					$NumDocFirst,
					$RESULT_AGORA,
					$RESULT_AGORA2,
					$STATYA_ALL,
					$AgoraID,
					$Path,
					$Path_Others,
					$NameGroup,
					$anat,
					$statya,
					$DOCUM_ID,
					$DOCUM_ID_Others,
                                        $UID
					){
	//................................................................................
	if ($nID_DOCSR<>""){
		$v=0;
		$stmt = JosPrepareAndExecute($dbcnx, "select ID_DOCUM,ID_STAGE,DATEDOCUM from bsrp where ID_DOCSR IN (SELECT ID_DOCSR FROM bsrp_doc WHERE ID_DOCSR=".$nID_DOCSR.")");
		while(ocifetch($stmt)){
			$massVRN_BSRP[$v] = ociresult($stmt,"ID_DOCUM");

			$stmt3 = JosImmidiate($dbcnx, "select VNCODE from DIC where IDITEM=".ociresult($stmt,"ID_STAGE"));
			$massSTAGE_BSRP[$v] = ociresult($stmt3,"VNCODE");
			oci_free_statement($stmt3);

			$massDATE_BSRP[$v]=date('Y.m.d',strtotime(ociresult($stmt,"DATEDOCUM")));
			$v=$v+1;
		}
		oci_free_statement($stmt);
	}

	//.........................................................................................
	if ($Kod_Publik<>1){$Kod_Publik=0;}
//	if 	($DATE_DOC<>""){$DATE_DOC=date("d.m.Y",strtotime($DATE_DOC));}

	$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where NAMEITEM='Документы общего доступа' and DATE_RETRO IS null");
	$UrovDostup = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	$stmt = JosImmidiate($dbcnx, "select ZAVNUMKSA from param_nastr");
	$KSA_SUD = ociresult($stmt,"ZAVNUMKSA");
	oci_free_statement($stmt);

	$BSRP_DOC_ID=GetId($dbcnx);
	$UNIG_num_ID=GetId($dbcnx);
	$stmt = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND VNCODE ='$TypeID'");
	$TypeID_VNCODE = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	if ($TypeID=='01'){$numdic=7325;}
	else if ($TypeID=='05'){$numdic=8102;}
	else if ($TypeID=='02'){$numdic=9222;}

	if ($nID_DOCSR==null and $nUNIQ_NUM==null){
		JosInsUpd($dbcnx, "insert into bsrp_doc (id_docsr, 	ID_typed, 	id_exc,		uniqnum, 	useradd, dateadd)
	   	values ($BSRP_DOC_ID,	$TypeID_VNCODE, 	$UrovDostup,$UNIG_num_ID,	'$dbuser', sysdate)");
	}

	$VNCODE = sv_VERDICT_BY_BSR($RESULT_AGORA,$RESULT_AGORA2,&$TypeDocum);

if ($numdic<>'' and $VNCODE<>""){
	$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where NUMDIC=$numdic and VNCODE='".$VNCODE."' and DATE_RETRO IS null");
	$VERDICT_ID = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);
	if ($VNCODE==-1){$VERDICT_ID='null';}}


	$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where VNCODE='".$Stage."' and DATE_RETRO IS null and NUMDIC=7326");
	$StageID = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	$BSRP_ID=GetId($dbcnx);

	if ($nID_DOCSR==null and $nUNIQ_NUM==null){
		JosInsUpd($dbcnx, "insert into bsrp (id_docum,	DATEACT,SHANNOT,numdocum,datedocum,	id_stage,	KCA_SUD,id_docsr,	id_group,
		useradd,	dateadd,ID_AGORA,JUDICIAL_UID)
		values ($BSRP_ID,to_date('$Date_Validite','dd.MM.yyyy'),'".$anat."','".$NUM_DOC."',to_date('$DATE_DOC','dd.MM.yyyy'),$StageID,'".$KSA_SUD."',$BSRP_DOC_ID,$NameGroup,
			'".$dbuser."',sysdate ,".$AgoraID.",'".$UID."')");
	}
	else {
		JosInsUpd($dbcnx, "insert into bsrp (id_docum,DATEACT,SHANNOT,	numdocum,datedocum,	id_stage,	KCA_SUD,id_docsr,	id_group,
		useradd,	dateadd,ID_AGORA,JUDICIAL_UID)
		values ($BSRP_ID,to_date('$Date_Validite','dd.MM.yyyy'),'".$anat."','".$NUM_DOC."',to_date('$DATE_DOC','dd.MM.yyyy'),$StageID,'".$KSA_SUD."',$nID_DOCSR,$NameGroup,
			'".$dbuser."',sysdate ,".$AgoraID.",'".$UID."')");
	}
	if ($numdic==7325){
	$i=0;
	while ($FIO[$i]<>""){
		while ($p=strpos($FIO[$i],'"')){$FIO[$i]=substr($FIO[$i],0,$p).substr($FIO[$i],$p+1,strlen($FIO[$i])-$p+1);}
		while ($p=strpos($FIO[$i],"'")){$FIO[$i]=substr($FIO[$i],0,$p).substr($FIO[$i],$p+1,strlen($FIO[$i])-$p+1);}
		$SUD_SOSTAV_ID=GetId($dbcnx);
		$VNCODE='';
		if ($statya[$i]<>''){

			$rez=explode(".",$statya[$i]);
			$VNCODE = sv_VERDICT_BY_BSR($rez[0],$rez[1],&$TypeDocum);

			$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where NUMDIC=7325 and VNCODE='".$VNCODE."' and DATE_RETRO IS null");
			$VERDICT_ID = ociresult($stmt,"IDITEM");
			oci_free_statement($stmt);
			if ($VNCODE==-1){$VERDICT_ID='null';}
		}
		if ($VNCODE==''){
			JosInsUpd($dbcnx, "Insert into sud_sostav(id_item,		fio,	status,	id_docum,	dateadd,	useradd)
		    values ($SUD_SOSTAV_ID, '$FIO[$i]',	'$status[$i]',$BSRP_ID,	sysdate,	'$dbuser')");}
		else {
			JosInsUpd($dbcnx, "Insert into sud_sostav(id_item,	fio,	status,	id_docum,	dateadd,	useradd,ID_VERDICT)
		   values ($SUD_SOSTAV_ID, '$FIO[$i]',	'$status[$i]',$BSRP_ID,	sysdate,	'$dbuser',$VERDICT_ID)");
		//JosInsUpd($dbcnx, "Insert into sud_sostav(id_item,	fio,	status,	id_docum,	dateadd,	useradd)
		//values ($SUD_SOSTAV_ID, '$FIO[$i]',	'$status[$i]',$BSRP_ID,	sysdate,	'$dbuser')");

		}
		$i=$i+1;
	}
}else{
		$i=0;
		while ($FIO[$i]<>""){
			while ($p=strpos($FIO[$i],'"')){$FIO[$i]=substr($FIO[$i],0,$p).substr($FIO[$i],$p+1,strlen($FIO[$i])-$p+1);}
			while ($p=strpos($FIO[$i],"'")){$FIO[$i]=substr($FIO[$i],0,$p).substr($FIO[$i],$p+1,strlen($FIO[$i])-$p+1);}
			$SUD_SOSTAV_ID=GetId($dbcnx);
			JosInsUpd($dbcnx, "Insert into sud_sostav(id_item,		fio,	status,	id_docum,	dateadd,	useradd)
			    values ($SUD_SOSTAV_ID, '$FIO[$i]',	'$status[$i]',$BSRP_ID,	sysdate,	'$dbuser')");
			$i=$i+1;
		}

	}
	if ($v==0){
		$RELAT_DOC_ID=GetId($dbcnx);
		//$VERDICT_ID=null;
		if ($VERDICT_ID==""){
			JosInsUpd($dbcnx, "Insert into relat_doc (id_item,NUMDOCUMR,id_docum,dateadd,useradd)
					 			values ($RELAT_DOC_ID,'$NumDocFirst',$BSRP_ID,sysdate,'$dbuser')");}
		else{
			JosInsUpd($dbcnx, "Insert into relat_doc (id_item,		NUMDOCUMR,		id_docum,	id_documr,	dateadd,	ID_ESSEACT,useradd)
					 			values ($RELAT_DOC_ID,'$NumDocFirst',	$BSRP_ID,	null, 		sysdate,	$VERDICT_ID,'$dbuser')");
		}
	}
	else {
		while ($v>0){
			$v=$v-1;

			if (substr($DATE_DOC,-4)>substr($massDATE_BSRP[$v],0,4)){$perem=1;}
			else if ((substr($DATE_DOC,-4)<substr($massDATE_BSRP[$v],0,4))){$perem=0;}
			else {
				if (substr($DATE_DOC,3,2)>substr($massDATE_BSRP[$v],5,2)){$perem=1;}
				else if (substr($DATE_DOC,3,2)<substr($massDATE_BSRP[$v],5,2)){$perem=0;}
				else {
					if (substr($DATE_DOC,0,2)>substr($massDATE_BSRP[$v],8,2)){$perem=1;}
					else if (substr($DATE_DOC,0,2)<substr($massDATE_BSRP[$v],8,2)){$perem=0;}
				}
			}

			if ($massSTAGE_BSRP[$v]=='113'){$ur=1;}
			else if ($massSTAGE_BSRP[$v]=='114' or $massSTAGE_BSRP[$v]=='111'){$ur=3;}
			else if ($massSTAGE_BSRP[$v]=='115'){$ur=4;}
			else {$ur=2;}

			if ($Stage=='113'){$urNew=1;}
			else if ($Stage=='114' or $StageID=='111'){$urNew=3;}
			else if ($Stage=='115'){$urNew=4;}
			else {$urNew=2;}

			if ($VERDICT_ID==""){$VERDICT_ID=null;}
			$RELAT_DOC_ID=GetId($dbcnx);
			if ($NumDocFirst==''){$NumDocFirst='';}
			if ($ur<$urNew){

				JosInsUpd($dbcnx, "Insert into relat_doc (id_item,		id_docum,	id_documr,	dateadd,	ID_ESSEACT,useradd, numdocumr)
					 values ($RELAT_DOC_ID,	$BSRP_ID,	$massVRN_BSRP[$v], 		sysdate,	$VERDICT_ID,'$dbuser', null)");

			}
			else if ($ur>$urNew){
				JosInsUpd($dbcnx, "Insert into relat_doc (id_item,		id_docum,	id_documr,	dateadd,	ID_ESSEACT,useradd, numdocumr)
					 values ($RELAT_DOC_ID,	$BSRP_ID,	null, 		sysdate,	$VERDICT_ID,'$dbuser', '$NumDocFirst')");
				JosInsUpd($dbcnx, "Update relat_doc set id_documr=$BSRP_ID where id_docum=$massVRN_BSRP[$v]");
			}

			else if ($ur=$urNew and $ur==3 and $perem==0){
			JosInsUpd($dbcnx, "Insert into relat_doc (id_item,		id_docum,	id_documr,	dateadd,	ID_ESSEACT,useradd, numdocumr)
					 values ($RELAT_DOC_ID,	$BSRP_ID,	null, 		sysdate,	$VERDICT_ID,'$dbuser', '$NumDocFirst')");
				JosInsUpd($dbcnx, "Update relat_doc set id_documr=$BSRP_ID,numdocumr=''  where id_docum=$massVRN_BSRP[$v]");
			}
			else if ($ur=$urNew and $ur==3 and $perem==1){
			JosInsUpd($dbcnx, "Insert into relat_doc (id_item,		id_docum,	id_documr,	dateadd,	ID_ESSEACT,useradd, numdocumr)
					 values ($RELAT_DOC_ID,	$BSRP_ID,	$massVRN_BSRP[$v], 		sysdate,	$VERDICT_ID,'$dbuser', null)");

			}
		}
	}
	if ($TypeID=='02' and $STATYA_1<>""){
		$stmt = JosImmidiate($dbcnx, "select NAME from catalogcontent@ibasedata where addinteger_10=".$STATYA_1);
		$CATEGORY_ID = ociresult($stmt,"NAME");
		oci_free_statement($stmt);
		$stmt = OCIParse($dbcnx, "select VNCODE from dic where numdic=9200 AND date_retro IS NULL and NAMEITEM like'%".$CATEGORY_ID."%'");
		ociexecute($stmt, OCI_DEFAULT);
		ocifetch($stmt);
		$str[1]=ociresult($stmt,"VNCODE");
		$RUB_DOCUM_ID=GetId($dbcnx);
		if ($str[1]<>""){JosInsUpd($dbcnx, "Insert into rub_docum (ID_RUB,		RUBRIKAT,	ID_DOCUM,	USERADD,	dateadd)
	    						values ($RUB_DOCUM_ID,	'$str[1]',	$BSRP_ID,	'$dbuser', sysdate)");}
		}
	else if ($TypeID=='04' and $STATYA_1<>"") {
		$stmt = JosImmidiate($dbcnx, "select NAME from catalogcontent@ibasedata where CONTENTID=".$STATYA_1);
		$VERDICT_ID = ociresult($stmt,"NAME");
		oci_free_statement($stmt);
		$stmt = OCIParse($dbcnx, "select VNCODE from dic where numdic=7314 AND date_retro IS NULL and NAMEITEM like'%".$VERDICT_ID."'");
		ociexecute($stmt, OCI_DEFAULT);
		ocifetch($stmt);
		$strSTAT = ociresult($stmt,"VNCODE");
		oci_free_statement($stmt);
		if ($strSTAT<>""){
			$RUB_DOCUM_ID=GetId($dbcnx);
			JosInsUpd($dbcnx, "Insert into rub_docum (ID_RUB,RUBRIKAT,ID_DOCUM,USERADD,dateadd) values ($RUB_DOCUM_ID,'$strSTAT',$BSRP_ID,'$dbuser',sysdate)");
		}
	}

	else {$str=SvFindStr ($STATYA_ALL);

	$svFind_UK=stristr($STATYA_ALL,"УПК");
	$i=1;
		while ($str[$i]<>""){
			$RUB_DOCUM_ID=GetId($dbcnx);
			if 	($TypeID=='05') {$stmt = OCIParse($dbcnx, "select VNCODE from dic where numdic=7310 AND date_retro IS NULL and VNCODE like'%".$str[$i]."'");}
			else if	($TypeID=='01') {$stmt = OCIParse($dbcnx, "select VNCODE from dic where numdic=7311 AND date_retro IS NULL and VNCODE like'%".$str[$i]."'");}
			ociexecute($stmt, OCI_DEFAULT);
			ocifetch($stmt);
			$strSTAT = ociresult($stmt,"VNCODE");
			oci_free_statement($stmt);
			if ($strSTAT<>""){JosInsUpd($dbcnx, "Insert into rub_docum (ID_RUB,		RUBRIKAT,	ID_DOCUM,	USERADD,	dateadd) values ($RUB_DOCUM_ID,	'$strSTAT',	$BSRP_ID,	'$dbuser', sysdate)");}
			$i=$i+1;
		}
	}

	$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where NUMDIC=7313 and VNCODE='".$TypeDocumID."' and DATE_RETRO IS null");
	$TypeDocumID_IDITEM = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	$IDITEM_TEXTDOCUM=GetId($dbcnx);

	if ($Path<>""){
		$svFind_UK= dirname( $Path ).'\\'.basename ( $Path, '.html' );
		if (@file_exists( $svFind_UK.'.doc')){$svFind_UK= $svFind_UK.'.doc';}
		elseif (@file_exists($svFind_UK.'.docx')){$svFind_UK= $svFind_UK.'.docx';}

		$inesrt="insert into text_docum (IDITEM,id_docum, textdocum, id_typedocum,USERADD, dateadd, pornum, WORD, id_doc_agora) values ($IDITEM_TEXTDOCUM,$BSRP_ID, empty_clob(),$TypeDocumID_IDITEM,'$dbuser', sysdate,1,empty_blob(), '$DOCUM_ID') RETURNING textdocum, word INTO :text, :text2" ;
		saInsertLob($dbcnx, $inesrt, ":text", ":text2", $Path, $svFind_UK);

		unlink($Path);
		unlink($svFind_UK);
	}
	else{
		if ($_FILES["df".$AgoraID]<>""){
			//вставка для преобразования в html
			$temppath = pathinfo($_FILES['df'.$AgoraID]['tmp_name']);
			$DocFile1=$temppath['dirname'].'\\'.$_FILES['df'.$AgoraID]['name'];
			$strFormat=substr($DocFile1,0,strlen($DocFile1)-3).html;
			if (move_uploaded_file($_FILES['df'.$AgoraID]['tmp_name'], $DocFile1)){
				if (Get_FileHTML($DocFile1,$strFormat)){
					unlink($DocFile1);
				}
				$Path=$strFormat;
				if ($Path<>""){
					$inesrt="insert into text_docum (IDITEM,id_docum, textdocum, id_typedocum,USERADD, dateadd, pornum, id_doc_agora) values ($IDITEM_TEXTDOCUM,$BSRP_ID, empty_clob(),$TypeDocumID_IDITEM,'$dbuser', sysdate,1, '$DOCUM_ID') RETURNING textdocum INTO :text";
					InsertCLOB($dbcnx, $inesrt, ":text", $Path);
					unlink($Path);
				}
			}
		}
	}

	if (count($Path_Others)>0) {
		foreach ($Path_Others as $key=>$others) {
			$IDITEM_TEXTDOCUM_Others=GetId($dbcnx);
			$svFind_UK= dirname( $others ).'\\'.basename ( $others, '.html' );
			if (@file_exists( $svFind_UK.'.doc')){$svFind_UK= $svFind_UK.'.doc';}
			elseif (@file_exists($svFind_UK.'.docx')){$svFind_UK= $svFind_UK.'.docx';}
/* echo "DEBUG!!!<br><br>";
echo $svFind_UK . "<br>";
echo $others . "<br>";
die();*/
			$inesrt="insert into text_docum (IDITEM,id_docum, textdocum, id_typedocum,USERADD, dateadd, pornum, WORD, id_doc_agora) values ($IDITEM_TEXTDOCUM_Others,$BSRP_ID, empty_clob(),$TypeDocumID_Others,'$dbuser', sysdate,$key+2,empty_blob(), '$DOCUM_ID_Others[$key]') RETURNING textdocum, word INTO :text, :text2" ;
			saInsertLob($dbcnx, $inesrt, ":text", ":text2", $others, $svFind_UK);
             //echo $DOCUM_ID_Others[$key];
			unlink($others);
			unlink($svFind_UK);
		}
	}

	$committed = ocicommit($dbcnx);
	$FetchSync = oci_parse($dbcnx, "BEGIN BSR.PK_BSR.CTX_Rubrikat($BSRP_ID); END;");
	oci_execute($FetchSync, OCI_DEFAULT );
}

function FuncKolvoSv($dbcnx,$nVidDela,$TipDela,$nNumDelaFirst,&$massVrnSvDel,$DELO_ID_GLAV){
	$paramAll=0;

	$massVrnSvDel[0]=0;
	$massVrnSvDel[1]=0;
	$massVrnSvDel[2]=0;
	$massVrnSvDel[3]=0;

	if ($nVidDela=='01'){
		if ($TipDela==113){
			//для первая-апелляция
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID = 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND A_CASE_NUMBER_I in (select FULL_NUMBER from u1_case@ibasedata
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для первая-кассация
			$strSelect = "select ID from u2_case@ibasedata I where VERDICT_II_DATE IS NOT NULL AND ID IN (SELECT CASE_ID
						FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT null) AND CASE_NUMBER_PEACE in
						(select FULL_NUMBER from u1_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для первая-надзор
			$strSelect = "select ID from u3_case@ibasedata I where PROTEST_VERDICT_DATE IS NOT NULL AND
					id IN (SELECT CASE_ID FROM u3_case_defendant@ibasedata where VERDICT_I_1 IS NOT NULL) AND CASE_NUMBER_I in
						(select FULL_NUMBER from u1_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
		}
		if ($TipDela==112){
			//для апелляция-первая
			//для первая-апелляция
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID <> 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND FULL_NUMBER in (select A_CASE_NUMBER_I from u1_case@ibasedata
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для апелляция-кассация
			$strSelect = "select ID from u2_case@ibasedata I where VERDICT_II_DATE IS NOT NULL AND ID IN (SELECT CASE_ID
						FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT null) AND CASE_NUMBER_PEACE in
						(select A_CASE_NUMBER_I from u1_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для апелляция-надзор
			$strSelect = "select ID from u3_case@ibasedata I where PROTEST_VERDICT_DATE IS NOT NULL AND
					id IN (SELECT CASE_ID FROM u3_case_defendant@ibasedata where VERDICT_I_1 IS NOT NULL) AND CASE_NUMBER_I in
						(select A_CASE_NUMBER_I from u1_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
		}
		if ($TipDela==114){
			//для кассация-первая
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID <> 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND FULL_NUMBER in (select CASE_NUMBER_PEACE from u2_case@ibasedata I
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-апелляция
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID = 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND A_CASE_NUMBER_I in (select CASE_NUMBER_PEACE from u2_case@ibasedata I
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-кассация
			$strSelect = "select ID from u2_case@ibasedata I where ID <> $DELO_ID_GLAV AND VERDICT_II_DATE IS NOT NULL AND ID IN (SELECT CASE_ID
						FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT null) AND CASE_NUMBER_PEACE in
						(select CASE_NUMBER_PEACE from u2_case@ibasedata where ID = $DELO_ID_GLAV)
						AND COURT_I in (select COURT_I from u2_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-надзор
			$strSelect = "select ID from u3_case@ibasedata I where PROTEST_VERDICT_DATE IS NOT NULL AND
					id IN (SELECT CASE_ID FROM u3_case_defendant@ibasedata where VERDICT_I_1 IS NOT NULL) AND CASE_NUMBER_I in
						(select CASE_NUMBER_PEACE from u2_case@ibasedata where ID = $DELO_ID_GLAV)
						AND COURT_I in (select COURT_I from u2_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-надзор(24)

		}
		if ($TipDela==115){
			//для надзор-первая
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID <> 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND FULL_NUMBER in (select CASE_NUMBER_I from u3_case@ibasedata
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для надзор-апелляция
			$strSelect = "select ID from u1_case@ibasedata I where CASE_TYPE_ID = 50780001 AND VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND EXISTS (SELECT 1 FROM u1_defendant@ibasedata WHERE VERDICT_DATE IS NOT NULL
						AND VERDICT_ID IS NOT NULL AND CASE_ID=I.ID) AND A_CASE_NUMBER_I in (select CASE_NUMBER_I from u3_case@ibasedata
						where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для надзор-кассация
			$strSelect = "select ID from u2_case@ibasedata I where ID <> $DELO_ID_GLAV AND VERDICT_II_DATE IS NOT NULL AND ID IN (SELECT CASE_ID
						FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT null) AND CASE_NUMBER_PEACE in
						(select CASE_NUMBER_I from u3_case@ibasedata where ID = $DELO_ID_GLAV) AND
						COURT_I in (select COURT_I from u3_case@ibasedata where ID = $DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
		}
	}
	if ($nVidDela=='05'){
		if ($TipDela==113){}
		if ($TipDela==110){}
		if ($TipDela==111){}
		if ($TipDela==115){}
	}
	if ($nVidDela=='02'){
		if ($TipDela==113){
			//для первая-апелляция
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID = 50520004 and RESULT_DATE IS NOT NULL
			AND RESULT_ID IS NOT NULL and A_CASE_NUMBER_I in (select CASE_FULL_NUMBER from g1_case@ibasedata
						where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для первая-кассация
			$strSelect = "select ID from gr2_delo@ibasedata where DRESALT IS NOT NULL AND IDRESH IS NOT NULL AND id!=$DELO_ID_GLAV
			and NUMRNS in (select CASE_FULL_NUMBER from g1_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для первая-надзор
			$strSelect = "select ID from g3_case@ibasedata where PROTEST_VERDICT_DATE IS NOT NULL
				AND SATISFIED_VERDICT_I_ID IS NOT NULL AND CASE_NUMBER_I in (select CASE_FULL_NUMBER
						from g1_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
		}
		if ($TipDela==112){
			//для апелляция-первая
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID <> 50520004 and RESULT_DATE IS NOT NULL
						AND RESULT_ID IS NOT NULL and CASE_FULL_NUMBER in (select A_CASE_NUMBER_I from g1_case@ibasedata
						where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для апелляция-кассация
			$strSelect = "select ID from gr2_delo@ibasedata where DRESALT IS NOT NULL AND IDRESH IS NOT NULL AND id!=$DELO_ID_GLAV
						and NUMRNS in (select A_CASE_NUMBER_I from g1_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для первая-надзор
			$strSelect = "select ID from g3_case@ibasedata where PROTEST_VERDICT_DATE IS NOT NULL
				AND SATISFIED_VERDICT_I_ID IS NOT NULL AND CASE_NUMBER_I in (select A_CASE_NUMBER_I
						from g1_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
		}
		if ($TipDela==114){
			//для кассация-первая
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID <> 50520004 AND RESULT_DATE IS NOT NULL
			AND RESULT_ID IS NOT NULL AND CASE_FULL_NUMBER in (select NUMRNS from gr2_delo@ibasedata
						where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-апелляция
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID = 50520004 and RESULT_DATE IS NOT NULL
			AND RESULT_ID IS NOT NULL AND A_CASE_NUMBER_I in (select NUMRNS from gr2_delo@ibasedata
						where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-кассация
			$strSelect = "select ID from gr2_delo@ibasedata where DRESALT IS NOT NULL AND IDRESH IS NOT NULL AND id!=$DELO_ID_GLAV
						AND NUMRNS in (select NUMRNS from gr2_delo@ibasedata where id=$DELO_ID_GLAV)
						AND rns in (select rns from gr2_delo@ibasedata where id=$DELO_ID_GLAV) and
						SUDRNS in (select SUDRNS from gr2_delo@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-надзор
			$strSelect = "select ID from g3_case@ibasedata where PROTEST_VERDICT_DATE IS NOT NULL
				AND SATISFIED_VERDICT_I_ID IS NOT NULL AND CASE_NUMBER_I in (select NUMRNS from gr2_delo@ibasedata
						where id=$DELO_ID_GLAV) and COURT_I in (select rns from gr2_delo@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-надзор(24)
			if ($_SESSION["SXEMA"]==1){
			$strSelect = "SELECT ID	FROM G33_PROCEEDING@ibasedata where CASS_ID=$DELO_ID_GLAV ";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}}
		}
		if ($TipDela==115){
			//для надзор - первая
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID <> 50520004 AND RESULT_DATE IS NOT NULL
			AND RESULT_ID IS NOT NULL AND CASE_FULL_NUMBER in (select CASE_NUMBER_I
						from g3_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для надзор-апелляция
			$strSelect = "select ID from g1_case@ibasedata where CASE_TYPE_ID = 50520004 AND RESULT_DATE IS NOT NULL
			AND RESULT_ID IS NOT NULL AND A_CASE_NUMBER_I in (select CASE_NUMBER_I
						from g3_case@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для надзор-кассация
			$strSelect = "select ID from g3_case@ibasedata where PROTEST_VERDICT_DATE IS NOT NULL
				AND SATISFIED_VERDICT_I_ID IS NOT NULL AND CASE_NUMBER_I in (select NUMRNS from gr2_delo@ibasedata
						where id=$DELO_ID_GLAV) AND COURT_I in (select rns from gr2_delo@ibasedata where id=$DELO_ID_GLAV)";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}
			//для кассация-надзор(24)
			if ($_SESSION["SXEMA"]==1){
			$strSelect = "SELECT ID	FROM G33_PROCEEDING@ibasedata where CASS_ID=$DELO_ID_GLAV ";
			$sthf = JosPrepareAndExecute($dbcnx,$strSelect);
			while(ocifetch($sthf)){
				$massVrnSvDel[$paramAll]=ociresult($sthf,"ID");
    			$paramAll=$paramAll+1;
			}}
		}
	}
	return $paramAll;
}

function funcFindDefendant($dbcnx,$nVidDela,$DELO_ID_GLAV,$DELO_ID){
	$j=0;
	if ($DELO_ID_GLAV==$DELO_ID){$yes_dela=5;}
	else {
	if ($nVidDela=='01'){
		$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U1_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U2_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U3_CASE_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"NAME");
					$j=$j+1;
				}
				oci_free_statement($sthD);
			}
		}
	}
	if ($nVidDela=='05' and $DELO_ID_GLAV <> ""){
		$sthD = JosPrepareAndExecute($dbcnx,"select PARTY_NAME from adm_parts@IBASEDATA where case_id=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"PARTY_NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM1_case@IBASEDATA where id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM2_case@IBASEDATA where id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
					$j=$j+1;
				}
				oci_free_statement($sthD);
				if ($NAME_GLAV[0]==""){
					$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM3_case@IBASEDATA where id=".$DELO_ID_GLAV);
					while (ocifetch($sthD)){
						$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
						$j=$j+1;
					}
					oci_free_statement($sthD);
				}
			}
		}
	}
	if ($nVidDela=='02'){
		$sthD = JosPrepareAndExecute($dbcnx,"SELECT NAME FROM G1_PARTS@IBASEDATA where CASE_ID=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"SELECT PARTY_NAME FROM G2_PARTS@IBASEDATA where case_id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"PARTY_NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"SELECT NAME FROM G3_parts@IBASEDATA where case_id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"NAME");
					$j=$j+1;
				}
			oci_free_statement($sthD);
			}
		}
	}
	if($j>0){
		$k=0;
	if ($nVidDela=='01'){
		$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U1_DEFENDANT@IBASEDATA where case_id=".$DELO_ID);
		while (ocifetch($sthD)){
			$NAME_DOP[$k]=ociresult($sthD,"NAME");
			$k=$k+1;
		}
		oci_free_statement($sthD);
		if ($NAME_DOP[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U2_DEFENDANT@IBASEDATA where case_id=".$DELO_ID);
			while (ocifetch($sthD)){
				$NAME_DOP[$k]=ociresult($sthD,"NAME");
				$k=$k+1;
			}
			oci_free_statement($sthD);
			if ($NAME_DOP[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U3_CASE_DEFENDANT@IBASEDATA where case_id=".$DELO_ID);
				while (ocifetch($sthD)){
					$NAME_DOP[$k]=ociresult($sthD,"NAME");
					$k=$k+1;
				}
				oci_free_statement($sthD);
			}
		}
	}
	if ($nVidDela=='05'){
		$sthD = JosPrepareAndExecute($dbcnx,"select PARTY_NAME from adm_parts@IBASEDATA where case_id=".$DELO_ID);
		while (ocifetch($sthD)){
			$NAME_DOP[$k]=ociresult($sthD,"PARTY_NAME");
			$k=$k+1;
		}
		oci_free_statement($sthD);
		if ($NAME_DOP[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM1_CASE@IBASEDATA where id=".$DELO_ID);
			while (ocifetch($sthD)){
				$NAME_DOP[$k]=ociresult($sthD,"DEFENDANT_NAME");
				$k=$k+1;
			}
			oci_free_statement($sthD);
			if ($NAME_DOP[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM2_CASE@IBASEDATA where id=".$DELO_ID);
				while (ocifetch($sthD)){
					$NAME_DOP[$k]=ociresult($sthD,"DEFENDANT_NAME");
					$k=$k+1;
				}
				oci_free_statement($sthD);
				if ($NAME_DOP[0]==""){
					$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM3_CASE@IBASEDATA where id=".$DELO_ID);
					while (ocifetch($sthD)){
						$NAME_DOP[$k]=ociresult($sthD,"DEFENDANT_NAME");
						$k=$k+1;
					}
					oci_free_statement($sthD);
				}
			}
		}
	}
	if ($nVidDela=='02'){
		$sthD = JosPrepareAndExecute($dbcnx,"SELECT i.NAME FROM G1_PARTS@IBASEDATA I where I.CASE_ID=".$DELO_ID);
		while (ocifetch($sthD)){
			$NAME_DOP[$k]=ociresult($sthD,"NAME");
			$k=$k+1;
		}
		oci_free_statement($sthD);
		if ($NAME_DOP[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"SELECT i.PARTY_NAME FROM G2_PARTS@IBASEDATA I where I.CASE_ID=".$DELO_ID);
			while (ocifetch($sthD)){
				$NAME_DOP[$k]=ociresult($sthD,"PARTY_NAME");
				$k=$k+1;
			}
			oci_free_statement($sthD);
			if ($NAME_DOP[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"SELECT i.NAME FROM G3_PARTS@IBASEDATA I where I.CASE_ID=".$DELO_ID);
				while (ocifetch($sthD)){
					$NAME_DOP[$k]=ociresult($sthD,"NAME");
					$k=$k+1;
				}
				oci_free_statement($sthD);
			}
		}
	}
	}
	$yes_dela=0;
	for($i=0;$i<$j;$i++){
		for($m=0;$m<$k;$m++){
			if($NAME_GLAV[$i]==$NAME_DOP[$m]){$yes_dela=$yes_dela+1;}
		}
	}}
	return $yes_dela;
}

function funcFindDefendantAgora($dbcnx,$nVidDela,$DELO_ID_GLAV,$DELO_ID){
	$j=0;
	$yes_dela=0;
	if ($DELO_ID_GLAV==$DELO_ID){$yes_dela=5;}
	else {
	if ($nVidDela=='01'){
		$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U1_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U2_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select NAME from U3_CASE_DEFENDANT@IBASEDATA where case_id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"NAME");
					$j=$j+1;
				}
				oci_free_statement($sthD);
			}
		}
	}
	if ($nVidDela=='05'){
		$sthD = JosPrepareAndExecute($dbcnx,"select PARTY_NAME from adm_parts@IBASEDATA where case_id=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"PARTY_NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM1_case@IBASEDATA where id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM2_case@IBASEDATA where id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
					$j=$j+1;
				}
				oci_free_statement($sthD);
				if ($NAME_GLAV[0]==""){
					$sthD = JosPrepareAndExecute($dbcnx,"select DEFENDANT_NAME from ADM3_case@IBASEDATA where id=".$DELO_ID_GLAV);
					while (ocifetch($sthD)){
						$NAME_GLAV[$j]=ociresult($sthD,"DEFENDANT_NAME");
						$j=$j+1;
					}
					oci_free_statement($sthD);
				}
			}
		}
	}
	if ($nVidDela=='02'){
		$sthD = JosPrepareAndExecute($dbcnx,"SELECT NAME FROM G1_PARTS@IBASEDATA where CASE_ID=".$DELO_ID_GLAV);
		while (ocifetch($sthD)){
			$NAME_GLAV[$j]=ociresult($sthD,"NAME");
			$j=$j+1;
		}
		oci_free_statement($sthD);
		if ($NAME_GLAV[0]==""){
			$sthD = JosPrepareAndExecute($dbcnx,"SELECT PARTY_NAME FROM G2_PARTS@IBASEDATA where case_id=".$DELO_ID_GLAV);
			while (ocifetch($sthD)){
				$NAME_GLAV[$j]=ociresult($sthD,"PARTY_NAME");
				$j=$j+1;
			}
			oci_free_statement($sthD);
			if ($NAME_GLAV[0]==""){
				$sthD = JosPrepareAndExecute($dbcnx,"SELECT NAME FROM G3_parts@IBASEDATA where case_id=".$DELO_ID_GLAV);
				while (ocifetch($sthD)){
					$NAME_GLAV[$j]=ociresult($sthD,"NAME");
					$j=$j+1;
				}
			oci_free_statement($sthD);
			}
		}
	}
	if($j>0){
		$k=0;
		$stmt5 = JosPrepareAndExecute($dbcnx, "SELECT FIO FROM sud_sostav WHERE id_DOCUM=".$DELO_ID);
		while(ocifetch($stmt5)){
			$NAME_DOP[$k] = ociresult($stmt5,"FIO");
			$k=$k+1;
		}
		oci_free_statement($stmt5);
	}

	$yes_dela=0;
	for($i=0;$i<$j;$i++){
		for($m=0;$m<$k;$m++){
			$p=0;
			while ($p=strpos($NAME_GLAV[$i],'"')){$NAME_GLAV[$i]=substr($NAME_GLAV[$i],0,$p).substr($NAME_GLAV[$i],$p+1,strlen($NAME_GLAV[$i])-$p+1);}
			while ($p=strpos($NAME_DOP[$m],"'")){$NAME_DOP[$m]=substr($NAME_DOP[$m],0,$p).substr($NAME_DOP[$m],$p+1,strlen($NAME_DOP[$m])-$p+1);}
			if($NAME_GLAV[$i]==$NAME_DOP[$m]){$yes_dela=$yes_dela+1;}
		}
	}
	if ($yes_dela==0){
		for($i=0;$i<$j;$i++){
			for($m=0;$m<$k;$m++){
				if(strncasecmp ( $NAME_GLAV[$i], $NAME_DOP[$m],6)==0){$yes_dela=$yes_dela+1;}
			}
		}
	}
	//if ($yes_dela>0){}

	}
	return $yes_dela;
}

//проверяем есть ли дело в базе бср (но оно не содержит ID_AGORA)
function Func_find_agora($dbcnx32,$DELO_ID,$nNumDelaFirst,$VidDela,$TipDela,$ZAVNUMKSA){


	if ($VidDela=='01'){$nVidDela=731201;} //уголовное
	else if ($VidDela=='05'){$nVidDela=731205;}//административное
	else if ($VidDela=='02'){$nVidDela=731202;}//гражданское

	$dop_str="";

	if ($VidDela=='01' or $VidDela=='02'){
		if ($TipDela=='113' or $TipDela=='112'){$dop_str=" and (ID_STAGE='114' or ID_STAGE='115') ";}
		if ($TipDela=='114'){$dop_str=" and ID_STAGE<>'114' ";}
	}
	$Sel="SELECT ID_DOCUM,ID_STAGE,ID_DOCSR,NUMDOCUM,DATEDOCUM,ID_GROUP,KCA_SUD FROM bsrp WHERE ID_AGORA <> $DELO_ID and id_DOCSR IN (select id_DOCSR from bsrp where trim(NUMDOCUM)='".$nNumDelaFirst."') $dop_str";
	$stmt = JosPrepareAndExecute($dbcnx32,$Sel);
	while (ocifetch($stmt)){
		$YES_BSR = ociresult($stmt,"ID_DOCUM");
		if ($YES_BSR<>""){	if (funcFindDefendantAgora($dbcnx32,$VidDela,$DELO_ID,$YES_BSR)>0){

   		$nTipSvDela=ociresult($stmt,"ID_STAGE");
   		$ID_DocSr = ociresult($stmt,"ID_DOCSR");

		$DELO_NUMBER = ociresult($stmt,"NUMDOCUM");
		$DELO_DATA_VERDICT = date('d.m.Y',strtotime(ociresult($stmt,"DATEDOCUM")));
		$group = ociresult($stmt,"ID_GROUP");

		if ($nTypeDocum<>""){
			$stmt2 = JosImmidiate($dbcnx32, "SELECT NAMEITEM FROM dic WHERE DATE_RETRO IS null and iditem=".$nTypeDocum);
			$TypeDocum = ociresult($stmt2,"NAMEITEM");
			oci_free_statement($stmt2);
		}
		if ($nTipSvDela<>""){
			$stmt2 = JosImmidiate($dbcnx32, "SELECT NAMEITEM FROM dic WHERE DATE_RETRO IS null and iditem=".$nTipSvDela);
			$nTipSvDela = ociresult($stmt2,"NAMEITEM");
			oci_free_statement($stmt2);
		}
		if ($ID_DocSr<>""){
			$stmt2 = JosImmidiate($dbcnx32, "select UNIQNUM from bsrp_doc where ID_DOCSR=".$ID_DocSr);
			$UniqNum = ociresult($stmt2,"UNIQNUM");
			oci_free_statement($stmt2);
		}

		$stmt2 = JosImmidiate($dbcnx32, "select TEXTDOCUM,ID_TYPEDOCUM from text_docum where ID_DOCUM=".$YES_BSR);
		$Text = ociresult($stmt2,"TEXTDOCUM");
		$nTypeDocum = ociresult($stmt2,"ID_TYPEDOCUM");
		oci_free_statement($stmt2);

		$strokaPecat=$strokaPecat.'</TABLE><TABLE class="styleTable" style="WIDTH: 98%">
								<TR align="center"><TD width="2%"></TD>
								<TD class="stTd" width="2%"><IMG SRC="..\Image\apply.bmp"></TD>';
		$strokaPecat=$strokaPecat."
			<TD class='stTd' width=\"7%\"><A href=\"javascript: Search_ConnectDocum('$ID_DocSr', '$YES_BSR', 1, $UniqNum)\">$DELO_NUMBER</A></TD>
	  		<TD class='stTd' width=\"7%\">".substr($DELO_DATA_VERDICT,0,10)."</TD>";
		$strokaPecat=$strokaPecat."<TD class='stTd' width=\"27%\"><A href=\"javascript: Search_Text('', '$YES_BSR', '', '_blank');\">Электронная копия судебного документа</a></TD><TD class=\"stTd\" width=\"12%\">$TypeDocum</TD>";
		$strokaPecat=$strokaPecat."<TD class='stTd' width=\"17%\"><SELECT style='WIDTH: 180px' name=group".$DELO_ID.">";
   		if ($group<>""){
   			$stmt2 = JosPrepareAndExecute($dbcnx32, "select NAME_GROUP,ID_GROUP from users_group where ID_GROUP=".$group);
			while(ocifetch($stmt2)){
				$NameGroup = ociresult($stmt2,"NAME_GROUP");
				$ID_Group = ociresult($stmt2,"ID_GROUP");
   				$strokaPecat=$strokaPecat."<OPTION selected value=$ID_Group>$NameGroup</OPTION>";
			}
			oci_free_statement($stmt2);
   		}
		$strokaPecat=$strokaPecat.'	</SELECT></TD><TD width="12%">'.$nTipSvDela.'</TD></TR></TABLE><TABLE class="styleTable" style="WIDTH: 98%">';
    	}}}
	oci_free_statement($stmt);
	return   $strokaPecat;
}

function generate_pagination($base_url, $num_items, $per_page, $start_item, $TipDela,$VidDela,$GOD,$MON,$DOKLAD,$massNach,$massKon,$add_prevnext_text = TRUE){
	$total_pages = ceil($num_items/$per_page);
	if ( $total_pages == 1 )	{	return '';	}

	$on_page = floor($start_item / $per_page) + 1;
	$page_string = '';

	for($i = 1; $i < $total_pages + 1; $i++){
		$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . $base_url . "?Sudya=$DOKLAD&Month=$MON&VidDela=".$VidDela."&TipDela=".$TipDela."&TakeOne=".$per_page."&Page=". ( ( $i  - 1 ) * $per_page ) .' " onMouseover="view_text(\''.$massNach[$i-1].'.'.$massKon[$i-1].'.\')" onmouseout="hidden_text()"><FONT color="red" >' .$i. '</font></a>';
			if ( $i <  $total_pages )	{	$page_string .= ', ';}
		}
	if ($page_string){$page_string = '<strong>Перейти</strong>&nbsp;&nbsp;' . $page_string;}
	return $page_string;
}

include ('svTab.php');

?>
</html>