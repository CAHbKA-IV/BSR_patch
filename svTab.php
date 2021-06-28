<?php

function svTab($dbcnx,$KOLVODEL,$TipDela,$page,$VidDela,$MON,$SUD_DOKLAD,$param_object){
	$stmt = JosImmidiate($dbcnx, "select ZAVNUMKSA from PARAM_NASTR");
	$ZAVNUMKSA = ociresult($stmt,'ZAVNUMKSA');
	oci_free_statement($stmt);
	$PHP_File='Kartochka.php';
	$stmt = JosImmidiate($dbcnx, "SELECT IDITEM FROM dic WHERE DATE_RETRO IS null and numdic=7312 AND vncode='".$VidDela."'");
	$VidDela_IDITEM = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);

	$stmt = JosImmidiate($dbcnx, "select IDITEM from DIC where vncode='".$TipDela."' and DATE_RETRO IS null and NUMDIC=7326");
	$TipDela_IDITEM = ociresult($stmt,"IDITEM");
	oci_free_statement($stmt);
	$strokaPecat='<table class="styleTable" style="WIDTH: 98%">
  		<TR align="center">
    	<TD class="styleTitle" width="2%"><INPUT type="checkbox" id="CheckAll" onClick="toggleSelect();"></TD>
    	<TD class="styleTitle" width="7%">Номер дела</TD>
    	<TD class="styleTitle" width="7%">Дата постановления</TD>
    	<TD class="styleTitle" width="25%">Прикрепленный ИТОГОВЫЙ документ</TD>
    	<TD class="styleTitle" width="12%">Тип документ</TD>';

	if ($VidDela=='05' and $TipDela=='115' and $_SESSION["SXEMA"]==1)
		{$strokaPecat.='<TD class="styleTitle" width="19%">Принадлежит судье</TD>';}
	else {$strokaPecat.='<TD class="styleTitle" width="19%">Принадлежит судье</TD>';}

  	$strokaPecat.='<TD class="styleTitle" width="12%">Комментарий</TD></TR>';


 	if ($page == '') {$page=0;}
    $pageFirst=$page;
    $Take=$KOLVODEL;

    if ($VidDela=='01'){
    	//формируется условие, если поставлена галочка не выдавать снятые и отозванные дела  51230004
    	if ($_SESSION["SNYATO"]==1){$strokaWhere_VERDICT="50910101,50190001,11050003";}
		if ($_SESSION["OTOZVANO"]==1){
			if ($strokaWhere_VERDICT) {$strokaWhere_VERDICT=$strokaWhere_VERDICT.",50910102,50190002";}
			else {$strokaWhere_VERDICT="50910102,50190002";}//50910102 (по 1 инстанции) - представление (жалоба) отозваны, 50190002(по кассации) - протест (жалоба) отозваны
		}
		if ($TipDela=='113'){
			$strokaPecat= '<H3>Уголовные дела. Первая инстанция.</h3>'.$strokaPecat;
    		if ($strokaWhere_VERDICT){$strokaWhere=" u.verdict_id not in ($strokaWhere_VERDICT) AND";}
    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID=$SUD_DOKLAD and ";}
    		if ($_SESSION["ZAKON"]==1){$strokaWhere=$strokaWhere." VALIDITY_DATE IS NOT NULL AND ";}
    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID = $SUD_DOKLAD AND ";}
    		if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from u.VERDICT_DATE) = $MON AND";}
			if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=u.id AND o.DOC_TYPE='450020' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",U1_DOCUMENT@IBASEDATA o";
          }


			$strSelectCount="select uu.* FROM (select DISTINCT u.ID,FULL_NUMBER as UMBER,u.short_number,u.VERDICT_DATE from u1_case@ibasedata u,u1_defendant@ibasedata d
			".$strocaDoc."
			where $strokaWhere
			d.CASE_ID = u.id 
			AND YEAR_REG=".$_SESSION["GOD"]." AND u.CASE_TYPE_ID<>50780001 AND	d.VERDICT_DATE IS NOT NULL
   			AND d.VERDICT_ID IS NOT null order by u.short_number) uu where
                        not ( 0<(select count(*) from bsrp b where ID_AGORA=uu.ID) or 0<(select count(*) from bsrp b where b.NUMDOCUM = uu.UMBER
			AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(uu.VERDICT_DATE,'dd.MM.yyyy')) )";

			$strSelectCount = preg_replace("/\s+/", " ", $strSelectCount);
//CiV (1)

    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U1_DOCUMENT@IBASEDATA
				WHERE DOC_TYPE='450020' and DELIVER_BSR_ID='60000' and CASE_ID = ";
			$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U1_DOCUMENT@IBASEDATA
				WHERE  DELIVER_BSR_ID='60000' and CASE_ID = ";
			}
		else if ($TipDela=='112'){
			$strokaPecat= '<H3>Уголовные дела. Апелляция.</h3>'.$strokaPecat;
			if (substr ($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){			if ($strokaWhere_VERDICT){$strokaWhere=" VERDICT_II_ID not in ($strokaWhere_VERDICT) AND";}
			if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." SPEAKER = $SUD_DOKLAD AND ";}
			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from VERDICT_II_DATE) = $MON AND";}

			if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=u.id AND o.DOC_TYPE='450020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U2_DOCUMENT@IBASEDATA o";
              }


          $strSelectCount="select uu.* from (SELECT u.ID,FULL_NUMBER as UMBER,u.VERDICT_II_DATE from u2_case@ibasedata u
             ".$strocaDoc."
             where $strokaWhere
			u.id IN (SELECT CASE_ID FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT NULL) AND TO_NUMBER(TO_CHAR(VERDICT_II_DATE,'YYYY'))=
   			".$_SESSION["GOD"]." ORDER BY F_SHORT_NUMBER
                ) uu Where
                not (  0<(select count(*) from bsrp b where ID_AGORA=uu.ID) or 
                       0<(select count(*) from bsrp b where b.NUMDOCUM = uu.UMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(uu.VERDICT_II_DATE,'dd.MM.yyyy') and KCA_SUD='$ZAVNUMKSA') 
                )";

		$strSelectCount = preg_replace("/\s+/", " ", $strSelectCount);
//CiV (2)
			
				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U2_DOCUMENT@IBASEDATA WHERE DOC_TYPE='450020'
				and DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U2_DOCUMENT@IBASEDATA WHERE DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";


			}

			else {
			if ($strokaWhere_VERDICT){$strokaWhere=" u.verdict_id not in ($strokaWhere_VERDICT) AND";}
			if ($_SESSION["ZAKON"]==1){$strokaWhere=$strokaWhere." VALIDITY_DATE IS NOT NULL AND ";}
			if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID = $SUD_DOKLAD AND ";}
			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from u.VERDICT_DATE) = $MON AND";}
             if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=u.id AND o.DOC_TYPE='450020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U1_DOCUMENT@IBASEDATA o";
              }

			$strSelectCount="select uu.* from (select DISTINCT u.ID,FULL_NUMBER as UMBER,u.VERDICT_DATE from u1_case@ibasedata u,u1_defendant@ibasedata d
			".$strocaDoc."
			 where $strokaWhere
			d.CASE_ID = u.id 
			AND YEAR_REG=".$_SESSION["GOD"]." AND u.CASE_TYPE_ID=50780001 AND	d.VERDICT_DATE IS NOT NULL
   			AND d.VERDICT_ID IS NOT null order by full_number) uu
                        Where
                        not ( 0< (select count(*) from bsrp b where ID_AGORA=uu.ID) or 
                              0< (select count(*) from bsrp b where b.NUMDOCUM = uu.UMBER
			          AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(uu.VERDICT_DATE,'dd.MM.yyyy'))
                        )";

			$strSelectCount = preg_replace("/\s+/", " ", $strSelectCount);
//CiV (3)

		   $strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U1_DOCUMENT@IBASEDATA
				WHERE DOC_TYPE='450020' and DELIVER_BSR_ID='60000' and CASE_ID = ";
		   $countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U1_DOCUMENT@IBASEDATA
				WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";  }
		}


		else if ($TipDela=='114'){
			$strokaPecat= '<H3>Уголовные дела. Кассация.</h3>'.$strokaPecat;
			 if (substr ($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
			 	if ($strokaWhere_VERDICT){$strokaWhere=" VERDICT_BY_PROTEST not in ($strokaWhere_VERDICT) AND";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE = $SUD_DOKLAD AND ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
				  if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56030003' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U33_DOCUMENT@IBASEDATA o";
              }

					$strSelectCount="Select ii.* From (SELECT I.ID, PROCEEDING_FULL_NUMBER as UMBER, I.FULL_NUMBER, I.PROTEST_VERDICT_DATE FROM U33_PROCEEDING@IBASEDATA I

					".$strocaDoc."

					WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL and id IN (SELECT PROC_ID FROM U33_PARTS@ibasedata where VERDICT_I_1 is not null) 
					AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY FULL_NUMBER) ii
                                        Where not (
                                          0<(select count(*) from bsrp b where ID_AGORA=II.ID) or
                                          0<(select count(*) from bsrp b where b.NUMDOCUM = II.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(II.PROTEST_VERDICT_DATE,'dd.MM.yyyy') and KCA_SUD='$ZAVNUMKSA')
                                        )";

					$strSelectCount = preg_replace("/\s+/", " ", $strSelectCount);
//CiV (4)

	           	$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U33_DOCUMENT@IBASEDATA WHERE DOC_TYPE='56030003'
					and DELIVER_BSR_ID='60000' and PROC_ID = $DELO_ID";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U33_DOCUMENT@IBASEDATA WHERE DELIVER_BSR_ID='60000' and PROC_ID = $DELO_ID";


				}

			else {

			if ($strokaWhere_VERDICT){$strokaWhere=" VERDICT_II_ID not in ($strokaWhere_VERDICT) AND";}
			if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." SPEAKER = $SUD_DOKLAD AND ";}
			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from VERDICT_II_DATE) = $MON AND";}
			   	if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=u.id AND o.DOC_TYPE='450020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U2_DOCUMENT@IBASEDATA o";
              }


          $strSelectCount="Select uu.* From (SELECT u.ID,FULL_NUMBER as UMBER,u.VERDICT_II_DATE from u2_case@ibasedata u
          ".$strocaDoc."
          where $strokaWhere
			u.id IN (SELECT CASE_ID FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT NULL) AND TO_NUMBER(TO_CHAR(VERDICT_II_DATE,'YYYY'))=
   			".$_SESSION["GOD"]." ORDER BY F_SHORT_NUMBER) uu
                        where not (
                          0< (select count(*) from bsrp b where ID_AGORA=u.ID) or
                          0< (select count(*) from bsrp b where b.NUMDOCUM = uu.UMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(uu.VERDICT_II_DATE,'dd.MM.yyyy') and KCA_SUD='$ZAVNUMKSA')
                        )";

	$strSelectCount = preg_replace("/\s+/", " ", $strSelectCount);
//CiV (5)

				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U2_DOCUMENT@IBASEDATA WHERE DOC_TYPE='450020'
				and DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U2_DOCUMENT@IBASEDATA WHERE DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";

				}
		}
		else if ($TipDela=='115'){
			if ($_SESSION["SXEMA"]==1){
				$strokaPecat= '<H3>Уголовные дела. Надзор. Новая схема.</h3>'.$strokaPecat;
				if ($strokaWhere_VERDICT){$strokaWhere=" VERDICT_BY_PROTEST not in ($strokaWhere_VERDICT) AND";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE = $SUD_DOKLAD AND ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
				if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56030003' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U33_DOCUMENT@IBASEDATA o";
              }


				if ($ZAVNUMKSA == '23OS0000'  or $ZAVNUMKSA == '06OS0000'){// Данное условие сделано для Краснодарского краевого суда, в выборку попадает абсолютно все из нового надзора
					$strSelectCount="SELECT I.ID, PROCEEDING_FULL_NUMBER as UMBER FROM U33_PROCEEDING@IBASEDATA I
					 ".$strocaDoc."
					WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL and id IN (SELECT PROC_ID FROM U33_PARTS@ibasedata where VERDICT_I_1 is not null) AND
    				0 = (select count(*) from bsrp b where (b.NUMDOCUM = I.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(I.PROTEST_VERDICT_DATE,'dd.MM.yyyy') and KCA_SUD='$ZAVNUMKSA') AND ID_AGORA=I.ID)
					AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY PROTEST_REG_NUMBER";
				}
				else{

				$strSelectCount="select ii.* from (SELECT I.ID, PROCEEDING_FULL_NUMBER as UMBER,I.PROTEST_VERDICT_DATE FROM U33_PROCEEDING@IBASEDATA I
                    ".$strocaDoc."
                    WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL and id IN (SELECT PROC_ID FROM U33_PARTS@ibasedata where VERDICT_I_1 is not null)     				
					AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY PROTEST_REG_NUMBER) ii
				where
                                not (
				  0< (select count(*) from bsrp b where ID_AGORA=II.ID) or
                                  0< (select count(*) from bsrp b where (b.NUMDOCUM=II.UMBER or b.NUMDOCUM=II.UMBER) AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(II.PROTEST_VERDICT_DATE,'dd.MM.yyyy') and KCA_SUD='$ZAVNUMKSA')
                                )";
//CiV (6)
				}
				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U33_DOCUMENT@IBASEDATA WHERE DOC_TYPE='56030003'
					and DELIVER_BSR_ID='60000' and PROC_ID = $DELO_ID";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U33_DOCUMENT@IBASEDATA WHERE DELIVER_BSR_ID='60000' and PROC_ID = $DELO_ID";
			}
			else{
				$strokaPecat= '<H3>Уголовные дела. Надзор.</h3>'.$strokaPecat;
				if ($strokaWhere_VERDICT){$strokaWhere=" VERDICT_BY_PROTEST not in ($strokaWhere_VERDICT) AND";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE = $SUD_DOKLAD AND ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
				
				$strSelectCount="select ii.* from(select I.ID, PROTEST_FULL_NUMBER as UMBER,I.PROTEST_VERDICT_DATE FROM U3_CASE@IBASEDATA I
				WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL AND ID IN (SELECT CASE_ID FROM u3_case_defendant@ibasedata where VERDICT_I_1
				IS NOT NULL) AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." 
				ORDER BY PROTEST_REG_NUMBER) ii
				WHERE
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=II.ID) or
				  0< (select count(*) from bsrp b where b.NUMDOCUM = II.UMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(II.PROTEST_VERDICT_DATE,'dd.MM.yyyy') AND KCA_SUD='$ZAVNUMKSA')
				)";
//CiV (7)

				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM U3_CASE_DOCUMENT@IBASEDATA WHERE DOC_TYPE='450020'
					and DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM U3_CASE_DOCUMENT@IBASEDATA WHERE DELIVER_BSR_ID='60000' and CASE_ID = $DELO_ID";
			}
		}
   }
	else if ($VidDela=='05'){
		if ($TipDela=='113'){
	    	$strokaPecat= '<H3>Административные дела. Первая инстанция.</h3>'.$strokaPecat;
	    	if ($_SESSION["ZAKON"]==1){$strokaWhere=$strokaWhere." TAKE_LAW_EFFECT_DATE IS NOT NULL AND ";}
                if ($_SESSION["AP"]==1){$strokaWhere=$strokaWhere." DECREE_ID NOT IN (40030003, 40030004) AND ";} //протокол об АП
			if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID = $SUD_DOKLAD AND ";}
			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from DECREE_DATE) = $MON AND";}
            if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",adm_document@IBASEDATA o";
              }
		    	$strSelectCount="Select a.* FROM (SELECT ID, CASE_NUMBER as UMBER FROM ADM_CASE@ibasedata I

		    	".$strocaDoc."

			WHERE $strokaWhere DECREE_DATE IS NOT NULL AND DECREE_ID IS NOT NULL AND REG_YEAR=".$_SESSION["GOD"]."
			 ORDER BY ORDINAL_NUMBER) a where
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=a.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = a.UMBER)
			)";
//CiV (8)

			$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM adm_document@IBASEDATA
				WHERE DOC_TYPE='40400020' and DELIVER_BSR_ID='60000' and CASE_ID = ";
			$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM adm_document@IBASEDATA
				WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
		}
	    else if ($TipDela=='110'){
	    	$strokaPecat= '<H3>Административные дела. Первый пересмотр.</h3>'.$strokaPecat;
	    	if ($_SESSION["ZAKON"]==1){$strokaWhere=$strokaWhere." TAKE_LAW_EFFECT_DATE IS NOT NULL AND ";}
			if ($_SESSION["AP1"]==1){$strokaWhere=$strokaWhere." DECREE_ID NOT IN (70100005, 70100007, 70100012) AND ";} //бр АП1
			if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID = $SUD_DOKLAD AND ";}
			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from DECREE_DATE) = $MON AND";}
			if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",adm1_document@IBASEDATA o";
              }


    	$strSelectCount="Select a.* from (SELECT ID, CASE_NUMBER as UMBER FROM ADM1_CASE@ibasedata I
    	".$strocaDoc."
    	WHERE $strokaWhere DECREE_DATE IS NOT NULL AND
			DECREE_ID IS NOT NULL AND REG_YEAR=".$_SESSION["GOD"]." ORDER BY ORDINAL_NUMBER) a where
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=a.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = a.UMBER AND ID_STAGE=7326110)
			)";
//CiV (9)


	    	$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM adm1_document@IBASEDATA
				WHERE DOC_TYPE='40400020' and DELIVER_BSR_ID='60000' and CASE_ID = ";
			$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM adm1_document@IBASEDATA
				WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
	    }
	    else if ($TipDela=='111'){
	    	$strokaPecat= '<H3>Административные дела. Второй пересмотр.</h3>'.$strokaPecat;
	    	if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID = $SUD_DOKLAD AND ";}
	    	if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from DECREE_DATE) = $MON AND";}
	    		if  ($_SESSION["ELECTRON"]==1)  {
		        $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
                $strocaDoc=",adm2_document@IBASEDATA o";
              }
	    	$strSelectCount="Select a.* from (SELECT ID, CASE_NUMBER as UMBER FROM ADM2_CASE@ibasedata I
	    	".$strocaDoc."
	    	WHERE $strokaWhere DECREE_DATE IS NOT NULL AND
			DECREE_ID IS NOT NULL AND TO_NUMBER(TO_CHAR(DECREE_DATE,'YYYY'))=".$_SESSION["GOD"]." order by ORDINAL_NUMBER) a where
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=a.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = a.UMBER AND KCA_SUD='$ZAVNUMKSA' and ID_STAGE=7326111)
			)";
//CiV (10)

	    	$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM adm2_document@IBASEDATA
				WHERE DOC_TYPE='40400020' and DELIVER_BSR_ID='60000' and CASE_ID = ";
			$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM adm2_document@IBASEDATA
				WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
	    }
	    else if ($TipDela=='115'){
	    	if ($_SESSION["SXEMA"]==1){
	    		$strokaPecat= '<H3>Административные дела. Надзор. Новая схема.</h3>'.$strokaPecat;
	    		//if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_STUDY_ID = $SUD_DOKLAD AND ";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." (JUDGE_ID = $SUD_DOKLAD OR JUDGE_STUDY_ID = $SUD_DOKLAD) AND ";}
if ($_SESSION["VOZV"]==1){$strokaWhere=$strokaWhere." VERDICT_ID<>331010101 AND ";}
//if ($_SESSION["VOZV"]==1){$strokaWhere=$strokaWhere." CHAIRMAN_ASSIST_ID is not null AND ";}331010101


			if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from VERDICT_DATE) = $MON AND";}
				if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56050003' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",A33_DOCUMENT@ibasedata o";
              }

			$strSelectCount="select a.* from (SELECT ID,FULL_NUMBER as UMBER FROM A33_PROCEEDING@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere
	    			TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY SHORT_NUMBER) a where
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=a.ID) or
				  0< (select count(*) from bsrp b where b.NUMDOCUM = a.UMBER AND KCA_SUD='$ZAVNUMKSA')
				)";
//CiV (11)
	    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM A33_DOCUMENT@IBASEDATA
					WHERE DOC_TYPE=56050003 and DELIVER_BSR_ID='60000' and PROC_ID = ";
	            $countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM A33_DOCUMENT@IBASEDATA
					WHERE DELIVER_BSR_ID='60000' and PROC_ID = ";
	    	}
	    	else{
	    		$strokaPecat= '<H3>Административные дела. Надзор.</h3>'.$strokaPecat;
	    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE = $SUD_DOKLAD AND ";}
	    		if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
	    		$strSelectCount="SELECT A.* FROM (SELECT ID,PROTEST_FULL_NUMBER as UMBER FROM ADM3_CASE@ibasedata I WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL AND VERDICT_BY_PROTEST IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
			ORDER BY PROTEST_REG_NUMBER) A WHERE
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=a.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = a.UMBER AND  KCA_SUD='$ZAVNUMKSA')
			)";
//CiV (12)

	    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM ADM3_CASE_DOCUMENT@IBASEDATA
					WHERE DOC_TYPE=40400020 and DELIVER_BSR_ID='60000' and CASE_ID = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM ADM3_CASE_DOCUMENT@IBASEDATA
					WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
	    	}
	    }
	}
	else if ($VidDela=='02'){
		if ($TipDela=='113'){
	    	$strokaPecat= '<H3>Гражданские дела. Первая инстанция.</h3>'.$strokaPecat;
	    	if ($_SESSION["ZAKON"]==1){$strokaWhere=" VALIDITY_DATE IS NOT NULL AND ";}
	    	if ($_SESSION["OSOBOE"]==1){$strokaWhere=$strokaWhere." CASE_TYPE_ID <> 50520003 AND ";}
	    	if ($_SESSION["MATER"]==1){$strokaWhere=$strokaWhere." CASE_FULL_NUMBER is not null AND CASE_FULL_NUMBER not like '9%-%' AND ";}
                if ($_SESSION["RESHEN"]==1){$strokaWhere=$strokaWhere." RESULT_ID IN (50640000,50640001,50640002) AND ";}  //по существу
	    	if ($_SESSION["UNION"]==1){$strokaWhere=$strokaWhere." RESULT_ID <> 50640150 AND ";}  //присоединенные дела
                if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID=$SUD_DOKLAD and ";}
	    	if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from RESULT_DATE) = $MON AND";}
	    	if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G1_DOCUMENT@IBASEDATA o";
          }

	    	$strSelectCount="SELECT ID,FULL_NUMBER as UMBER FROM G1_CASE@ibasedata I
	    	".$strocaDoc."
	    	WHERE $strokaWhere CASE_TYPE_ID NOT IN (50520004,50520054) AND
			RESULT_DATE IS NOT NULL AND RESULT_ID IS NOT NULL AND YEAR_REG=".$_SESSION["GOD"]." AND
			not exists(select ID_AGORA from bsrp b where (b.NUMDOCUM = I.FULL_NUMBER) AND (ID_AGORA=I.ID))
   			ORDER BY FULL_NUMBER";

	    	$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM G1_DOCUMENT@IBASEDATA WHERE (DOC_TYPE='450020' or DOC_TYPE='40400020') and DELIVER_BSR_ID='60000' and CASE_ID = ";
	    	$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM G1_DOCUMENT@IBASEDATA WHERE  DELIVER_BSR_ID='60000' and CASE_ID = ";
		}
	    else if ($TipDela=='112'){
	    	$strokaPecat= '<H3>Гражданские дела. Апелляция.</h3>'.$strokaPecat;
			if (substr ($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
				if ($_SESSION["SNYATO"]==1){$strokaWhere=" IDRESH <> 50440013 AND ";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." IDDOC=$SUD_DOKLAD and ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from DRESALT) = $MON AND";}
					//sif ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from RESULT_DATE) = $MON AND";}
	    		if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.IDDELO=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",GR2_DOCUM@IBASEDATA o";
          }
				$strSelectCount="select g.* from (SELECT  ID,Z_FULLNUMBER as UMBER FROM GR2_DELO@ibasedata I
				".$strocaDoc."
				WHERE $strokaWhere
					IDRESH IS NOT NULL AND DRESALT IS NOT NULL AND GOD=".$_SESSION["GOD"]." 
					ORDER BY Y_NUMBER) g WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=g.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA')
					)";
//CiV (13)
				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM GR2_DOCUM@IBASEDATA
					WHERE DOC_TYPE=450020 and DELIVER_BSR_ID='60000' and iddelo = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM GR2_DOCUM@IBASEDATA
					WHERE  DELIVER_BSR_ID='60000' and iddelo = ";
			}
			else{
				if ($_SESSION["ZAKON"]==1){$strokaWhere=" VALIDITY_DATE IS NOT NULL AND ";}
				if ($_SESSION["OTOZVANO"]==1){$strokaWhere=$strokaWhere." RESULT_ID <> 50640101 AND ";}
				if ($_SESSION["SNYATO"]==1){$strokaWhere=$strokaWhere." RESULT_ID <> 50640102 AND ";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID=$SUD_DOKLAD and ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from RESULT_DATE) = $MON AND";}
				if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G1_DOCUMENT@IBASEDATA o";
          }
				
				$strSelectCount="select g.* from (SELECT ID,FULL_NUMBER as UMBER FROM G1_CASE@ibasedata I
				".$strocaDoc."
				WHERE $strokaWhere CASE_TYPE_ID IN (50520054,50520004) AND
					RESULT_DATE IS NOT NULL AND RESULT_ID IS NOT NULL AND YEAR_REG=".$_SESSION["GOD"]." 
					ORDER BY SHORT_NUMBER,M_SHORT_NUMBER) g WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=g.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER)
					)";
//CiV (14)
				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM G1_DOCUMENT@IBASEDATA
					WHERE (DOC_TYPE='450020' or DOC_TYPE='40400020') and DELIVER_BSR_ID='60000' and CASE_ID = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM G1_DOCUMENT@IBASEDATA
					WHERE  DELIVER_BSR_ID='60000' and CASE_ID = ";
			}
		}		
	    else if ($TipDela=='114'){
	    	$strokaPecat= '<H3>Гражданские дела. Кассация.</h3>'.$strokaPecat;
			if (substr ($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
				if ($_SESSION["OTOZVANO"]==1){$strokaWhere=" ((SELECT count(*) FROM G33_COMPLAINT@IBASEDATA gc WHERE gc.proc_id = I.id AND coalesce(gc.VERDICT_ID, 0) NOT IN (10050013, 10050054, 10050063, 10050115, 10050204, 10050304)) > 0) AND ";}
	    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE=$SUD_DOKLAD and ";}
	    		if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
	    				if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }
	    		$strSelectCount="select g.* from (SELECT ID,FULL_NUMBER as UMBER FROM G33_PROCEEDING@IBASEDATA I
	    		".$strocaDoc."
	    		WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND PROTEST_VERDICT_DATE IS NOT NULL AND
					TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY FULL_NUMBER) g WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=g.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA')
					)";
//CiV(15)
	    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM G33_DOCUMENT@IBASEDATA
					WHERE DOC_TYPE=56040003 and DELIVER_BSR_ID='60000' and PROC_ID = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM G33_DOCUMENT@IBASEDATA
					WHERE  DELIVER_BSR_ID='60000' and PROC_ID = ";
				
			}
			else {
				if ($_SESSION["SNYATO"]==1){$strokaWhere=" IDRESH <> 50440013 AND ";}
				if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." IDDOC=$SUD_DOKLAD and ";}
				if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from DRESALT) = $MON AND";}
					if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.IDDELO=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",GR2_DOCUM@IBASEDATA o";
          }
				$strSelectCount="select g.* (SELECT  ID,Z_FULLNUMBER as UMBER FROM GR2_DELO@ibasedata I
				".$strocaDoc."
				WHERE $strokaWhere
					IDRESH IS NOT NULL AND DRESALT IS NOT NULL AND TO_NUMBER(TO_CHAR(DRESALT,'YYYY'))=".$_SESSION["GOD"]." 
					ORDER BY Y_NUMBER) g WHERE
					not ( 
					  0<  select count(*) from bsrp b where ID_AGORA=g.ID) or
					  0<  select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA')
					)";
//CiV (16)
				$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM GR2_DOCUM@IBASEDATA
					WHERE DOC_TYPE=450020 and DELIVER_BSR_ID='60000' and iddelo = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM GR2_DOCUM@IBASEDATA
					WHERE DELIVER_BSR_ID='60000' and iddelo = ";
			}
		}
	    else if ($TipDela=='115'){
	    	if ($_SESSION["SXEMA"]==1){
	    		$strokaPecat= '<H3>Гражданские дела. Надзор. Новая схема.</h3>'.$strokaPecat;
	    		if ($_SESSION["OTOZVANO"]==1){$strokaWhere=" ((SELECT count(*) FROM G33_COMPLAINT@IBASEDATA gc WHERE gc.proc_id = I.id AND coalesce(gc.VERDICT_ID, 0) NOT IN (10050013, 10050054, 10050063, 10050115, 10050204, 10050304)) > 0) AND ";}
	    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE=$SUD_DOKLAD and ";}
	    		if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
	      if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }
	    		$strSelectCount="select g.* from (SELECT ID,PROCEEDING_FULL_NUMBER as UMBER FROM G33_PROCEEDING@IBASEDATA I
	    		".$strocaDoc."
	    		WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND PROTEST_VERDICT_DATE IS NOT NULL AND
				TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."  ORDER BY PROTEST_REG_NUMBER) g WHERE
not (
  0< (select count(*) from bsrp b where ID_AGORA=g.ID) or
  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA')
)";
//CiV (17)


	    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM G33_DOCUMENT@IBASEDATA
					WHERE DOC_TYPE=56040003 and DELIVER_BSR_ID='60000' and PROC_ID = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM G33_DOCUMENT@IBASEDATA
					WHERE  DELIVER_BSR_ID='60000' and PROC_ID = ";
	    	}
	    	else{
	    		$strokaPecat= '<H3>Гражданские дела. Надзор.</h3>'.$strokaPecat;
	    		if ($_SESSION["OTOZVANO"]==1){$strokaWhere=" ((SELECT count(*) FROM G33_COMPLAINT@IBASEDATA gc WHERE gc.proc_id = I.id AND coalesce(gc.VERDICT_ID, 0) NOT IN (10050013, 10050054, 10050063, 10050115, 10050204, 10050304)) > 0) AND ";}
	    		if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." PRESIDING_JUDGE=$SUD_DOKLAD and ";}
	    		if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from PROTEST_VERDICT_DATE) = $MON AND";}
	    		if ($ZAVNUMKSA == '23OS0000'  or $ZAVNUMKSA == '06OS0000'){// Данное условие сделано для Краснодарского краевого суда, в выборку попадает абсолютно все из нового надзора
	    			/*$strSelectCount="SELECT ID,PROCEEDING_FULL_NUMBER as UMBER FROM G33_PROCEEDING@IBASEDATA I WHERE $strokaWhere
					(TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))= ".$_SESSION["GOD"]." or
   					(select TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY')) from G33_COMPLAINT@IBASEDATA where PROC_ID = I.ID and VERDICT_ID is not null and VERDICT_DATE is not null) = ".$_SESSION["GOD"]." )
					AND NOT EXISTS (SELECT 1 FROM bsrp b, bsrp_doc b_d WHERE b.ID_AGORA IS NOT NULL AND b.ID_STAGE=$TipDela_IDITEM AND b.id_docsr=b_d.id_docsr
					AND b_d.id_typed=$VidDela_IDITEM AND b.id_agora=I.ID) ORDER BY PROCEEDING_FULL_NUMBER";
	    			*/
	    			$strSelectCount="select g.* from (SELECT ID,PROCEEDING_FULL_NUMBER as UMBER FROM G33_PROCEEDING@IBASEDATA I WHERE $strokaWhere
					(TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))= ".$_SESSION["GOD"]."  or (select TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))
					from G33_COMPLAINT@IBASEDATA where PROC_ID = I.ID and VERDICT_ID is not null and VERDICT_DATE is not null) = ".$_SESSION["GOD"].")
 					ORDER BY PROTEST_REG_NUMBER) WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=g.ID)
					  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA'
					)";
//CiV (18)
	    		}
	    		else{
		/*    		$strSelectCount="SELECT ID,PROTEST_FULL_NUMBER as UMBER FROM G3_CASE@ibasedata I WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL AND SATISFIED_VERDICT_I_ID IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
					AND NOT EXISTS (SELECT 1 FROM bsrp b, bsrp_doc b_d WHERE b.ID_AGORA IS NOT NULL AND b.ID_STAGE=$TipDela_IDITEM AND b.id_docsr=b_d.id_docsr
					AND b_d.id_typed=$VidDela_IDITEM AND b.id_agora=I.ID) ORDER BY PROTEST_REG_NUMBER";
	  */  	$strSelectCount="select g.* from (SELECT ID,PROTEST_FULL_NUMBER as UMBER FROM G3_CASE@ibasedata I WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND
					PROTEST_VERDICT_DATE IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
					ORDER BY PROTEST_REG_NUMBER) g WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=g.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = g.UMBER AND KCA_SUD='$ZAVNUMKSA')
					)";
//CiV (19)

	    				}
	    		$strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM G3_DOCUMENT@IBASEDATA
					WHERE DOC_TYPE=450020 and DELIVER_BSR_ID='60000' and CASE_ID = ";
				$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM G3_DOCUMENT@IBASEDATA
					WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
			}
	    }
	}
	else if ($VidDela=='04'){
		$strokaPecat= '<H3>Материалы.</h3>'.$strokaPecat;
	    if ($_SESSION["OTOZVANO"]==1){$strokaWhere=" VERDICT_ID <> 70320007 AND ";}
	    if ($_SESSION["ZAKON"]==1){$strokaWhere=$strokaWhere." VALIDITY_DATE IS NOT NULL AND ";}
	    if ($SUD_DOKLAD){$strokaWhere=$strokaWhere." JUDGE_ID=$SUD_DOKLAD and ";}
	    if ($MON>0){$strokaWhere=$strokaWhere." EXTRACT(month from VERDICT_DATE) = $MON AND";}
	    	if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.ID AND DOC_TYPE='40500003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",M_DOCUMENT@IBASEDATA o";
          }
	    $strSelectCount="SELECT ID,FULL_NUMBER as UMBER FROM M_CASE@IBASEDATA I
	    ".$strocaDoc."
	     WHERE $strokaWhere VERDICT_DATE IS NOT NULL AND VERDICT_ID IS NOT NULL AND REG_YEAR=".$_SESSION["GOD"]."
			AND ID not IN (SELECT b.ID_AGORA FROM bsrp b, bsrp_doc b_d WHERE b.ID_AGORA IS NOT NULL AND b.id_docsr=b_d.id_docsr
			AND b_d.id_typed=$VidDela_IDITEM) ORDER BY REG_NUMBER";



	    $strSelectDocum="SELECT DOCUMENTID,DOCUMENTNAME FROM M_DOCUMENT@IBASEDATA
			WHERE DOC_TYPE=40500003 and DELIVER_BSR_ID='60000' and CASE_ID = ";
		$countOther="SELECT DOCUMENTID,DOCUMENTNAME FROM M_DOCUMENT@IBASEDATA
			WHERE DELIVER_BSR_ID='60000' and CASE_ID = ";
	}

	$NCOUNT=0;
	$n=0;
	$k=0;
//echo '<p>'.$strSelectCount.'</p>'; //CiV

	$stmt = JosPrepareAndExecute($dbcnx,$strSelectCount);

	while(ocifetch($stmt)){
		$mass_NUMBER=ociresult($stmt,"UMBER");
		if ($NCOUNT==$Take*$n){$massNach[$n]=ociresult($stmt,"UMBER");$n=$n+1;}
		if ($NCOUNT==$Take*$k+$Take-1){$massKon[$k]=ociresult($stmt,"UMBER");$k=$k+1;}
		$NCOUNT=$NCOUNT+1;
	}
	$massKon[$k]=$mass_NUMBER;
	oci_free_statement($stmt);
	$Take=$Take+$page;
/* ********************************************* Здесь кончаются StrSelectCount и начинаются "настоящие взрослые" StrSelect (18+) ******************************************** */ //CiV
	if ($VidDela=='01'){
		if ($TipDela=='113'){

                $strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (select DISTINCT to_char(u.VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,u.ID,
				u.CASE_TYPE_ID, u.VERDICT_ID,u.JUDGE_ID,u.FULL_NUMBER,u.FULL_NUMBER as CASE_NUMBER_I,u.short_number from u1_case@ibasedata u,u1_defendant@ibasedata d
                ".$strocaDoc."
                where $strokaWhere d.CASE_ID = u.id AND YEAR_REG=".$_SESSION["GOD"]." AND u.CASE_TYPE_ID<>50780001 AND	d.VERDICT_DATE IS NOT NULL
				AND d.VERDICT_ID IS NOT null order by u.short_number)  T WHERE
       not (
          0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
          0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE  )
       ) 
				AND
ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-1)

		}
		else if ($TipDela=='112'){

		   if (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){		   	$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (select COURT_I,VERDICT_II_ID as VERDICT_ID,SPEAKER as JUDGE_ID,CASE_NUMBER_PEACE as CASE_NUMBER_I,
			ID, FULL_NUMBER, TO_CHAR(VERDICT_II_DATE,'dd.MM.yyyy') as VERDICT_DATE from u2_case@ibasedata u
			".$strocaDoc."
			where $strokaWhere
			u.id IN (SELECT CASE_ID FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT NULL) AND TO_NUMBER(TO_CHAR(VERDICT_II_DATE,'YYYY'))=
   			".$_SESSION["GOD"]." ORDER BY F_SHORT_NUMBER)  T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE AND KCA_SUD='$ZAVNUMKSA')
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-2)

		   }

			else {

			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (select DISTINCT to_char(u.VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,u.ID,
			u.CASE_TYPE_ID,u.VERDICT_ID,u.JUDGE_ID,u.FULL_NUMBER,u.FULL_NUMBER as CASE_NUMBER_I  from u1_case@ibasedata u,u1_defendant@ibasedata d
			".$strocaDoc."
			where $strokaWhere
			 YEAR_REG=".$_SESSION["GOD"]." AND u.CASE_TYPE_ID=50780001 AND u.id = d.CASE_ID
			AND d.VERDICT_DATE IS NOT NULL AND d.VERDICT_ID IS NOT null order by full_number) T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE )
			) AND ROWNUM <= $Take) t2 WHERE t2.r > $page";
//CiV (1-3)
		    }


		}
		else if ($TipDela=='114'){

			if (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
		     if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56030003' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U33_DOCUMENT@IBASEDATA o";
              }			 $strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT VERDICT_BY_PROTEST as VERDICT_ID,ID,PRESIDING_JUDGE as JUDGE_ID,
					null as CASE_NUMBER_I, FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PROCEEDING_FULL_NUMBER FROM U33_PROCEEDING@IBASEDATA I

					".$strocaDoc."

					WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL and id IN (SELECT PROC_ID FROM U33_PARTS@ibasedata where VERDICT_I_1 is not null) AND
    				TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY PROTEST_REG_NUMBER) T WHERE 
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
				  0< (select count(*) from bsrp b where (b.NUMDOCUM=T.FULL_NUMBER or b.NUMDOCUM=T.PROCEEDING_FULL_NUMBER) AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE )
				)
				AND ROWNUM <= $Take) t2 WHERE t2.r >$page";
//CiV (1-4)



			}


			else {
                  	if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=u.id AND o.DOC_TYPE='450020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U2_DOCUMENT@IBASEDATA o";
              }
			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (select COURT_I,VERDICT_II_ID as VERDICT_ID,SPEAKER as JUDGE_ID,CASE_NUMBER_PEACE as CASE_NUMBER_I,
			ID, FULL_NUMBER, TO_CHAR(VERDICT_II_DATE,'dd.MM.yyyy') as VERDICT_DATE from u2_case@ibasedata u
			".$strocaDoc."
			where $strokaWhere
			u.id IN (SELECT CASE_ID FROM u2_defendant@ibasedata WHERE VERDICT_II_ID IS NOT NULL) AND TO_NUMBER(TO_CHAR(VERDICT_II_DATE,'YYYY'))=
   			".$_SESSION["GOD"]." ORDER BY F_SHORT_NUMBER)  T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE AND KCA_SUD='$ZAVNUMKSA')
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-5)
   			}
		}
		else if ($TipDela=='115'){
			if ($_SESSION["SXEMA"]==1){
				if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56030003' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",U33_DOCUMENT@IBASEDATA o";
              }
				if ($ZAVNUMKSA == '23OS0000' or $ZAVNUMKSA == '06OS0000'){// Данное условие сделано для Краснодарского краевого суда, в выборку попадает абсолютно все из нового надзора

					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (select (select VERDICT_ID from U33_COMPLAINT@IBASEDATA
					where PROC_ID = I.ID and CERTIORARI_ENTRY_DATE = I.last_UPDATED) as GALOBA_VERDICT,(select TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') from U33_COMPLAINT@IBASEDATA
					where PROC_ID = I.ID and CERTIORARI_ENTRY_DATE = I.last_UPDATED) as GALOBA_DATA,VERDICT_BY_PROTEST as VERDICT_ID,ID,PRESIDING_JUDGE as JUDGE_ID,null as CASE_NUMBER_I,
					FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE FROM U33_PROCEEDING@IBASEDATA I
					".$strocaDoc."
					WHERE $strokaWhere 0 = (select count(*) from bsrp b where ((b.NUMDOCUM=I.FULL_NUMBER or b.NUMDOCUM=I.PROCEEDING_FULL_NUMBER) AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = to_char(I.PROTEST_VERDICT_DATE,'dd.MM.yyyy')) or ID_AGORA=I.ID) and (TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))= ".$_SESSION["GOD"]." OR (select TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))
					from U33_COMPLAINT@IBASEDATA where PROC_ID = I.ID and CERTIORARI_ENTRY_DATE = I.last_UPDATED and VERDICT_ID is not null AND VERDICT_DATE is not null) = ".$_SESSION["GOD"].")
					ORDER BY PROTEST_REG_NUMBER) T WHERE ROWNUM <= $Take) t2 WHERE t2.r >$page";
				}
				else{
					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT VERDICT_BY_PROTEST as VERDICT_ID,ID,PRESIDING_JUDGE as JUDGE_ID,
					null as CASE_NUMBER_I, FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy) as VERDICT_DATE, PROCEEDING_FULL_NUMBER FROM U33_PROCEEDING@IBASEDATA I
					".$strocaDoc."
					WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL and id IN (SELECT PROC_ID FROM U33_PARTS@ibasedata where VERDICT_I_1 is not null) AND
    				TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY PROTEST_REG_NUMBER) T 
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
				  0< (select count(*) from bsrp b where (b.NUMDOCUM=T.FULL_NUMBER or b.NUMDOCUM=T.PROCEEDING_FULL_NUMBER) AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE )
				)
				AND WHERE ROWNUM <= $Take) t2 WHERE t2.r >$page";
//CiV (1-6)
				}
			}
			else{
				$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT VERDICT_BY_PROTEST as VERDICT_ID,ID,PRESIDING_JUDGE as JUDGE_ID,
				CASE_NUMBER_I,PROTEST_FULL_NUMBER as FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE FROM U3_CASE@IBASEDATA I
				WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL AND ID IN (SELECT CASE_ID FROM u3_case_defendant@ibasedata where VERDICT_I_1
				IS NOT NULL) AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." 
				ORDER BY PROTEST_REG_NUMBER) T WHERE 
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
				  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND to_char(b.DATEDOCUM,'dd.MM.yyyy') = T.VERDICT_DATE AND KCA_SUD='$ZAVNUMKSA')
				) 
				AND ROWNUM <= $Take) t2 WHERE t2.r >$page ";
//CiV (1-7)
			}
		}
	}
	else if ($VidDela=='05'){
		if ($TipDela=='113'){
		if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",adm_document@IBASEDATA o";
              }
			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT null as COURT_I,DECREE_ID as VERDICT_ID,JUDGE_ID,
			TO_CHAR(DECREE_DATE,'dd.MM.yyyy') as VERDICT_DATE,ID,CASE_NUMBER as FULL_NUMBER,CASE_NUMBER as CASE_NUMBER_I FROM ADM_CASE@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere DECREE_DATE IS NOT NULL AND DECREE_ID IS NOT NULL AND REG_YEAR=".$_SESSION["GOD"]."
			order by REG_YEAR,ORDINAL_NUMBER ) T
			WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER)
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-8)
		}
		else if ($TipDela=='110'){
			if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",adm1_document@IBASEDATA o";
              }

			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT COURT_I,DECREE_ID as VERDICT_ID,JUDGE_ID, TO_CHAR(DECREE_DATE,'dd.MM.yyyy')
			as VERDICT_DATE,ID,CASE_NUMBER as FULL_NUMBER,CASE_NUMBER_I FROM ADM1_CASE@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere DECREE_DATE IS NOT NULL AND
			DECREE_ID IS NOT NULL AND REG_YEAR=".$_SESSION["GOD"]."  ORDER BY ORDINAL_NUMBER) T
			WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND ID_STAGE=7326110)
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-9)
		}
		else if ($TipDela=='111'){
			if  ($_SESSION["ELECTRON"]==1)  {
		     $strokaWhere.=" o.CASE_ID=I.id AND o.DOC_TYPE='40400020' AND o.DELIVER_BSR_ID='60000' AND";
             $strocaDoc=",adm2_document@IBASEDATA o";
              }
			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT COURT_I,DECREE_ID as VERDICT_ID,JUDGE_ID, TO_CHAR(DECREE_DATE,'dd.MM.yyyy')
			as VERDICT_DATE,ID,CASE_NUMBER as FULL_NUMBER,CASE_NUMBER_I FROM ADM2_CASE@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere DECREE_DATE IS NOT NULL AND
			DECREE_ID IS NOT NULL AND TO_NUMBER(TO_CHAR(DECREE_DATE,'YYYY'))=".$_SESSION["GOD"]."  order by REG_YEAR,ORDINAL_NUMBER) T 
			WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA' and ID_STAGE=7326111)
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-10)
		}
		else if ($TipDela=='115'){
			if ($_SESSION["SXEMA"]==1){
				if ($ZAVNUMKSA == '57OS0000') {
						if  ($_SESSION["ELECTRON"]==1)  {
		             $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56050003' AND o.DELIVER_BSR_ID='60000' AND";
                    $strocaDoc=", A33_DOCUMENT@ibasedata o";
              }
					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT null as GALOBA_VERDICT, null as GALOBA_DATA,null as COURT_I,ID,
					VERDICT_ID, NVL(JUDGE_STUDY_ID, JUDGE_ID) as JUDGE_ID, FULL_NUMBER, TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,null as CASE_NUMBER_I
					FROM A33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY SHORT_NUMBER) T 
					WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";}
//CiV (1-11)
				else {
					if  ($_SESSION["ELECTRON"]==1)  {
		             $strokaWhere.=" o.PROC_ID=I.id AND o.DOC_TYPE='56050003' AND o.DELIVER_BSR_ID='60000' AND";
                    $strocaDoc=", A33_DOCUMENT@ibasedata o";
              }

					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT null as GALOBA_VERDICT, null as GALOBA_DATA,null as COURT_I,ID,
					VERDICT_ID, NVL(CHAIRMAN_ASSIST_ID, NVL(JUDGE_ID, JUDGE_STUDY_ID)) as JUDGE_ID, FULL_NUMBER, TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,null as CASE_NUMBER_I
					FROM A33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY SHORT_NUMBER) T 
					WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";}
//CiV (1-12)
			}
			else{
				$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT COURT_I,ID,VERDICT_BY_PROTEST as VERDICT_ID,PRESIDING_JUDGE as JUDGE_ID,
				PROTEST_FULL_NUMBER as FULL_NUMBER, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,CASE_NUMBER_I FROM ADM3_CASE@ibasedata I
				WHERE $strokaWhere PROTEST_VERDICT_DATE IS NOT NULL AND VERDICT_BY_PROTEST IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
				ORDER BY PROTEST_REG_NUMBER) T 
				WHERE 
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
				  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
				)
				AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-13)
			}
		}
	}
	else if ($VidDela=='02'){
		if ($TipDela=='113'){
			if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G1_DOCUMENT@IBASEDATA o";
          }
			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT ID,FULL_NUMBER,RESULT_ID as VERDICT_ID, TO_CHAR(RESULT_DATE,'dd.MM.yyyy')
			as VERDICT_DATE, JUDGE_ID,FULL_NUMBER as CASE_NUMBER_I FROM G1_CASE@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere CASE_TYPE_ID NOT IN (50520004,50520054) AND
			RESULT_DATE IS NOT NULL AND RESULT_ID IS NOT NULL AND YEAR_REG=".$_SESSION["GOD"]." 
   			ORDER BY FULL_NUMBER) T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where UPPER(T.FULL_NUMBER) = UPPER(b.NUMDOCUM))
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page";
//CiV (1-14)
		}
		else if ($TipDela=='112'){

		if (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
				if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.IDDELO=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",GR2_DOCUM@IBASEDATA o";
          }

		$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT RNS as COURT_I,ID,Z_FULLNUMBER as FULL_NUMBER,IDRESH as VERDICT_ID,
			TO_CHAR(DRESALT,'dd.MM.yyyy') as VERDICT_DATE, IDDOC as JUDGE_ID,NUMRNS as CASE_NUMBER_I FROM GR2_DELO@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere
			IDRESH IS NOT NULL AND DRESALT IS NOT NULL AND TO_NUMBER(TO_CHAR(DRESALT,'YYYY'))=".$_SESSION["GOD"]." 
			ORDER BY Y_NUMBER) T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-15)
			}
		else{  			if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G1_DOCUMENT@IBASEDATA o";
          }
			$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT ID,FULL_NUMBER,RESULT_ID as VERDICT_ID, TO_CHAR(RESULT_DATE,'dd.MM.yyyy')
			as VERDICT_DATE, JUDGE_ID,FULL_NUMBER as CASE_NUMBER_I FROM G1_CASE@ibasedata I
			".$strocaDoc."
			WHERE $strokaWhere CASE_TYPE_ID IN (50520054,50520004) AND
			RESULT_DATE IS NOT NULL AND RESULT_ID IS NOT NULL AND YEAR_REG=".$_SESSION["GOD"]." 
   			ORDER BY SHORT_NUMBER,M_SHORT_NUMBER) T WHERE 
			not (
			  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
			  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER)
			)
			AND ROWNUM <= $Take) t2 WHERE t2.r > $page";
// CiV (1-16)
			}
		}
		else if ($TipDela=='114'){
			if (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'){
				if ($ZAVNUMKSA == '23OS0000'  or $ZAVNUMKSA == '06OS0000'){
						if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }

					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT (select TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') from G33_COMPLAINT@IBASEDATA
					where PROC_ID = i.id) as GALOBA_DATA, null as GALOBA_VERDICT,ID,FULL_NUMBER,SATISFIED_VERDICT_I_ID as VERDICT_ID,
					TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PRESIDING_JUDGE as JUDGE_ID,null as CASE_NUMBER_I,
					PRESIDING_JUDGE_III,CASS_SPEAKER_ID FROM G33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere
					(TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))= ".$_SESSION["GOD"]."  or (select TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))
					from G33_COMPLAINT@IBASEDATA where PROC_ID = I.ID and VERDICT_ID is not null and VERDICT_DATE is not null) = ".$_SESSION["GOD"].")
 					ORDER BY PROTEST_REG_NUMBER) T WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-17)
}
				else{
				if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }
					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT DISTINCT ID,FULL_NUMBER as FULL_NUMBER,null as CASE_NUMBER_I,
					SATISFIED_VERDICT_I_ID as VERDICT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PRESIDING_JUDGE as JUDGE_ID,
					PRESIDING_JUDGE_III,CASS_SPEAKER_ID FROM G33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND
					PROTEST_VERDICT_DATE IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
					ORDER BY FULL_NUMBER) T WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-18)

				}
			}
			else{
						if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.IDDELO=I.id AND (DOC_TYPE='450020' or DOC_TYPE='40400020') AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",GR2_DOCUM@IBASEDATA o";
          }
				$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT RNS as COURT_I,ID,Z_FULLNUMBER as FULL_NUMBER,IDRESH as VERDICT_ID,
					TO_CHAR(DRESALT,'dd.MM.yyyy') as VERDICT_DATE, IDDOC as JUDGE_ID,NUMRNS as CASE_NUMBER_I FROM GR2_DELO@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere
					IDRESH IS NOT NULL AND DRESALT IS NOT NULL AND TO_NUMBER(TO_CHAR(DRESALT,'YYYY'))=".$_SESSION["GOD"]." 
					ORDER BY Y_NUMBER) T WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULLNUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-19)
			}
		}
		else if ($TipDela=='115'){
			if ($_SESSION["SXEMA"]==1){
				if ($ZAVNUMKSA == '23OS0000'  or $ZAVNUMKSA == '06OS0000'){
		  if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }
					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT (select TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') from G33_COMPLAINT@IBASEDATA
					where PROC_ID = i.id) as GALOBA_DATA, null as GALOBA_VERDICT,ID,FULL_NUMBER,SATISFIED_VERDICT_I_ID as VERDICT_ID,
					TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PRESIDING_JUDGE as JUDGE_ID,null as CASE_NUMBER_I,
					PRESIDING_JUDGE_III,CASS_SPEAKER_ID FROM G33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere
					(TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))= ".$_SESSION["GOD"]."  or (select TO_NUMBER(TO_CHAR(VERDICT_DATE,'YYYY'))
					from G33_COMPLAINT@IBASEDATA where PROC_ID = I.ID and VERDICT_ID is not null and VERDICT_DATE is not null) = ".$_SESSION["GOD"].")
 					ORDER BY PROTEST_REG_NUMBER) T WHERE
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-20)
}
				else{
		  if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.PROC_ID=I.ID AND DOC_TYPE='56040003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",G33_DOCUMENT@IBASEDATA o";
          }
					$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT DISTINCT ID,PROCEEDING_FULL_NUMBER as FULL_NUMBER,null as CASE_NUMBER_I,
					SATISFIED_VERDICT_I_ID as VERDICT_ID,TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PRESIDING_JUDGE as JUDGE_ID,
					PRESIDING_JUDGE_III,CASS_SPEAKER_ID FROM G33_PROCEEDING@ibasedata I
					".$strocaDoc."
					WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND
					PROTEST_VERDICT_DATE IS NOT NULL AND TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]."
					ORDER BY PROCEEDING_FULL_NUMBER) T WHERE 
					not (
					  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
					  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
					)
					AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-21)
				}
			}
			else {
				$strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT COURT_I,ID,PROTEST_FULL_NUMBER as FULL_NUMBER,SATISFIED_VERDICT_I_ID
				as VERDICT_ID, TO_CHAR(PROTEST_VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE, PRESIDING_JUDGE as JUDGE_ID,CASE_NUMBER_I FROM G3_CASE@ibasedata I
				WHERE $strokaWhere SATISFIED_VERDICT_I_ID IS NOT NULL AND PROTEST_VERDICT_DATE IS NOT NULL AND
				TO_NUMBER(TO_CHAR(PROTEST_VERDICT_DATE,'YYYY'))=".$_SESSION["GOD"]." ORDER BY PROTEST_REG_NUMBER)
				T WHERE 
				not (
				  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
				  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER AND KCA_SUD='$ZAVNUMKSA')
				)
				AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-22)
			}
		}
	}
	else if ($VidDela=='04'){
	      if  ($_SESSION["ELECTRON"]==1)  {
		  $strokaWhere.=" o.CASE_ID=I.ID AND DOC_TYPE='40500003' AND o.DELIVER_BSR_ID='60000' AND";
          $strocaDoc=",M_DOCUMENT@IBASEDATA o";
          }

		 $strSelect="SELECT * FROM (SELECT ROWNUM r, T.* from (SELECT ID,FULL_NUMBER, TO_CHAR(VERDICT_DATE,'dd.MM.yyyy') as VERDICT_DATE,VERDICT_ID,
		 JUDGE_ID,null as CASE_NUMBER_I FROM M_CASE@ibasedata I
		 ".$strocaDoc."
		 WHERE $strokaWhere VERDICT_DATE IS NOT NULL AND VERDICT_ID IS NOT NULL AND
		 REG_YEAR=".$_SESSION["GOD"]." ORDER BY REG_NUMBER)  T WHERE
		not (
		  0< (select count(*) from bsrp b where ID_AGORA=T.ID) or
		  0< (select count(*) from bsrp b where b.NUMDOCUM = T.FULL_NUMBER)
		)
		AND ROWNUM <= $Take) t2 WHERE t2.r > $page ";
//CiV (1-23)
	}

	$_SESSION["sQuery"]=$strSelect;

	$TCount=0;
	$varDel=0;
	$pageP=$page;
	$strokaPecat=$strokaPecat."<H3>Количество дел, удовлетворяющих запросу: ".$NCOUNT."</H3><P>";
//echo '<p>'.$strSelect.'</p>'; //CiV
	$stmt = JosPrepareAndExecute($dbcnx,$strSelect);
	while (ocifetch($stmt)){

		$DELO_ID=ociresult($stmt,"ID");
		if (preg_match("/[A-Z]/", ociresult($stmt,"VERDICT_DATE"))==0){	$DELO_DATA_VERDICT=ociresult($stmt,"VERDICT_DATE");}
		else {$DELO_DATA_VERDICT=date('d.m.Y',strtotime(ociresult($stmt,"VERDICT_DATE"))); }

		if ($DELO_DATA_VERDICT == ''){$DELO_DATA_VERDICT=date('d.m.Y',strtotime(ociresult($stmt,"GALOBA_DATA"))); }

		$VERDICT_ID=ociresult($stmt,"VERDICT_ID");
		if ($VERDICT_ID == ''){ // если нет результата рассмотрения, то считаю что это жалоба и беру значение из результата рассмотрения жалобы
			if ($VidDela=='05' and $_SESSION["SXEMA"]==1 and $TipDela=='115'){$VERDICT_ID=ociresult($stmt,"GALOBA_VERDICT");}
		}

		$DELO_NUMBER=ociresult($stmt,"FULL_NUMBER");

		$DOKLAD_SUD=ociresult($stmt,"JUDGE_ID");
		$stage=$TipDela;
		$nNumDelaFirst=ociresult($stmt,"CASE_NUMBER_I");

		if ($VidDela=='01'){//для уголовных дел
    		if (($VidDela=='02' and $TipDela=='114' and (substr ($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV')) or
    	($VidDela=='02' and $TipDela=='112' and (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV')))  {
 				//вытаскиваем подсудимого
 				$stmt2 = JosImmidiate($dbcnx,'SELECT NAME FROM U2_defendant@IBASEDATA where case_id='.$DELO_ID.' and VERDICT_I_ID is not null ORDER BY VERDICT_I_ID');
    			$NAME_PODSUD=ociresult($stmt2,"NAME");
	    		$NAME_PODSUD=str_replace('"',' ',$NAME_PODSUD);
	    		oci_free_statement($stmt2);
	    	}
    		else if ($TipDela=='113' or ($TipDela=='112' and (substr ($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV')  ) ){
    			$DELOTYPE=ociresult($stmt,"CASE_TYPE_ID");
    			if ($DELOTYPE<>""){
	    			$stmt2 = JosImmidiate($dbcnx,'SELECT NAME FROM CATALOGCONTENT@ibasedata where contentid='.$DELOTYPE);
 		 			$NAME_TYPE=ociresult($stmt2,"NAME");
					oci_free_statement($stmt2);
    			}
    				$stmt2 = JosImmidiate($dbcnx,'select COMMENTS from U1_EVENT@ibasedata where case_id = '.$DELO_ID.' order by EVENT_DATE desc, EVENT_TIME desc');
 		 			$KOM=ociresult($stmt2,"COMMENTS");
					oci_free_statement($stmt2);
    		}
     	}
    	if (($VidDela=='02' and $TipDela=='114' and (substr ($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV')) or
    	($VidDela=='02' and $TipDela=='112' and (substr ($ZAVNUMKSA,2,2)=='OS' OR substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'))){//для гражданских дел
			//вытаскиваем подсудимого
 			$stmt2 = JosImmidiate($dbcnx,'SELECT PARTY_NAME FROM G2_parts@ibasedata WHERE case_id='.$DELO_ID.' AND PARTY_TYPE_ID=50400000');
    		$NAME_PODSUD=ociresult($stmt2,"PARTY_NAME");
    		oci_free_statement($stmt2);
	    	$NAME_PODSUD=str_replace('"',' ',$NAME_PODSUD);
	    	$NAME_PODSUD=str_replace('.','',$NAME_PODSUD);
	    }
		if ($VidDela=='02' and $TipDela=='114' and (substr ($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV')){
			//вытаскиваем подсудимого
 			$stmt2 = JosImmidiate($dbcnx,'SELECT NAME FROM G33_parts@ibasedata WHERE proc_id='.$DELO_ID.' AND PARTS_TYPE_ID=50400000');
    		$NAME_PODSUD=ociresult($stmt2,"NAME");
    		oci_free_statement($stmt2);
	    	$NAME_PODSUD=str_replace('"',' ',$NAME_PODSUD);
	    	$NAME_PODSUD=str_replace('.','',$NAME_PODSUD);
		}

		/*if (preg_match("/[0-9]/", $nNumDelaFirst)<>0 and $nNumDelaFirst<>""){
			$param=FuncKolvoSv($dbcnx,$VidDela,$TipDela,$nNumDelaFirst,&$massVrnSvDel,$DELO_ID);
		}
		else {$param=0;}*/
		$param=0;

    	$DOCUM_ID='';

//Echo '<p>'.$strSelectDocum.$DELO_ID.'</p>'; //CiV
    	$SQL = JosPrepareAndExecute( $dbcnx,  $strSelectDocum.$DELO_ID);
		$SQLCountOther= JosPrepareAndExecute( $dbcnx,  $countOther.$DELO_ID);
		//echo  $countOther.$DELO_ID;
		$DocCount=0;

		//echo $strSelectDocum.$DELO_ID;

			while(OCIFetch($SQLCountOther))
	{
           $DocCount++;

           }
          oci_free_statement($SQLCountOther);

		while(OCIFetch($SQL))
	{
			$NAME_DOCUM = OCIResult($SQL,"DOCUMENTNAME");
			$DOCUM_ID=ociresult($SQL,"DOCUMENTID");

		}

		if ($DOCUM_ID==''){$DOCUM_ID=0;}

		oci_free_statement($SQL);

		$fTEXT='1';

		$TEXTDOC='';
		if 	($DOCUM_ID<>0){
	    if ($VidDela=='01'){
		    	if ($TipDela==113){$strSelectDocum1="SELECT DOCUMENTTEXT FROM U1_DOCUMENT@IBASEDATA where DOCUMENTID=";}
				if ($TipDela==112 and substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') {
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM U1_DOCUMENT@IBASEDATA where DOCUMENTID=";
				}
				if (($TipDela==114 and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV')) or
					($TipDela==112 and (substr($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'))){
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM U2_DOCUMENT@IBASEDATA where DOCUMENTID=";
				}
				if ($TipDela==114 and (substr($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV')){
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM U33_DOCUMENT@IBASEDATA where DOCUMENTID=";
				}
				if ($TipDela==115){
					if ($_SESSION["SXEMA"]==1){$strSelectDocum1="SELECT DOCUMENTTEXT FROM U33_DOCUMENT@IBASEDATA where DOCUMENTID=";}
					else{$strSelectDocum1="SELECT DOCUMENTTEXT FROM U3_CASE_DOCUMENT@IBASEDATA where DOCUMENTID=";}
				}
		    }
		    if ($VidDela=='05'){ //административные дела
		    	if ($TipDela==113){$strSelectDocum1="SELECT DOCUMENTTEXT FROM adm_document@IBASEDATA where DOCUMENTID=";}
				if ($TipDela==110){$strSelectDocum1="SELECT DOCUMENTTEXT FROM adm1_document@IBASEDATA where DOCUMENTID=";}
				if ($TipDela==111){$strSelectDocum1="SELECT DOCUMENTTEXT FROM adm2_document@IBASEDATA where DOCUMENTID=";}
				if ($TipDela==115){if ($_SESSION["SXEMA"]==1){
						$strSelectDocum1="SELECT DOCUMENTTEXT FROM A33_DOCUMENT@IBASEDATA where DOCUMENTID=";
					}
					else{
						$strSelectDocum1="SELECT DOCUMENTTEXT FROM ADM3_CASE_DOCUMENT@IBASEDATA where DOCUMENTID=";
					}
				}
		    }
		    if ($VidDela=='02'){
		    	if ($TipDela==113){$strSelectDocum1="SELECT DOCUMENTTEXT FROM G1_DOCUMENT@IBASEDATA where DOCUMENTID=";}
				if ($TipDela==112 and substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') {
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM G1_DOCUMENT@IBASEDATA where DOCUMENTID=";
				}
				if (($TipDela==114 and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV')) or
					($TipDela==112 and (substr($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'))){
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM GR2_DOCUM@IBASEDATA where DOCUMENTID=";
				}
				if ($TipDela==114 and (substr($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV')){
					$strSelectDocum1="SELECT DOCUMENTTEXT FROM G33_DOCUMENT@IBASEDATA where DOCUMENTID=";
				}
				if ($TipDela==115){
					if ($_SESSION["SXEMA"]==1){$strSelectDocum1="SELECT DOCUMENTTEXT FROM G33_DOCUMENT@IBASEDATA where DOCUMENTID=";}
					else{$strSelectDocum1="SELECT DOCUMENTTEXT FROM G3_DOCUMENT@IBASEDATA where DOCUMENTID=";}
				}
		    }
		    if ($VidDela=='04'){$strSelectDocum1="SELECT DOCUMENTTEXT FROM M_DOCUMENT@IBASEDATA where DOCUMENTID=";}

			$SQL = JosPrepareAndExecute( $dbcnx,  $strSelectDocum1.$DOCUM_ID);
			while (	OCIFetch($SQL)){
				$TEXTDOC=ociresult($SQL,"DOCUMENTTEXT");
				if ($TEXTDOC<>""){$fTEXT='0';}
			}
			oci_free_statement($SQL);

		}


				   	
		
		$strTypeDocum=="";{
			if ($TipDela=='114' and $VidDela==1){$strTypeDocum="<TD class='stTd' width='12%'><SELECT style='WIDTH: 100%' name=DocName".$DELO_ID." ><OPTION value='0'>не задан</OPTION>";}
   			else {$strTypeDocum="<TD class='stTd' width='12%'><SELECT style='WIDTH: 100%' name=DocName".$DELO_ID." ><OPTION value='0'>не задан</OPTION>";}

   			$stmt2 = JosPrepareAndExecute($dbcnx, "SELECT VNCODE,NAMEITEM, IDITEM FROM DIC WHERE DATE_RETRO IS null and NUMDIC=7313 ORDER BY VNCODE");
			while(ocifetch($stmt2)){
				$NameDoc = ociresult($stmt2,"NAMEITEM");
				$ID_NameDoc = ociresult($stmt2,"IDITEM");
				$kod_NameDoc = ociresult($stmt2,"VNCODE");
				if ($TipDela==113 and $VidDela=='05' and ($VERDICT_ID<=40030001) and $kod_NameDoc==450007){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}

				else if ($TipDela==113 and $VidDela=='05' and ($VERDICT_ID>=40030003) and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}

				//гражданская 1-ая инстанция
				else if ($TipDela==113 and $VidDela=='02' and ($VERDICT_ID==50640000 or $VERDICT_ID==50640002 or $VERDICT_ID==50640001) and $kod_NameDoc==450012){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==113 and $VidDela=='02' and ($VERDICT_ID<>50640000 and $VERDICT_ID<>50640002 and $VERDICT_ID<>50640001) and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				//гражданская апелляция
				else if ($TipDela==112 and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and $VidDela=='02' and ($VERDICT_ID==50640100 or $VERDICT_ID==50640105 or $VERDICT_ID==50640106 or $VERDICT_ID==50640104 or $VERDICT_ID==50640102 or $VERDICT_ID==50640007) and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==112 and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and  $VidDela=='02' and ($VERDICT_ID<>50640100 and $VERDICT_ID<>50640105 and $VERDICT_ID<>50640106 and $VERDICT_ID<>50640104 and $VERDICT_ID<>50640102 and $VERDICT_ID<>50640007) and $kod_NameDoc==450012){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				//администр 1 пересмотр
				else if ($TipDela==110 and $VidDela=='05' and ($VERDICT_ID>=70100005) and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==110 and $VidDela=='05' and ($VERDICT_ID<=70100004) and $kod_NameDoc==450012){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}

				else if (($TipDela==114 or ($TipDela==112 and (substr($ZAVNUMKSA,2,2)=='OS' or substr ($ZAVNUMKSA,2,2)=='OV' or substr ($ZAVNUMKSA,2,2)=='KJ' or substr ($ZAVNUMKSA,2,2)=='AJ' or substr ($ZAVNUMKSA,2,2)=='KV' or substr ($ZAVNUMKSA,2,2)=='AV'))) and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==111 and $kod_NameDoc==450012){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==115 and $kod_NameDoc==450007){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else if ($TipDela==114 and $VidDela==1 and $kod_NameDoc==450006){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}

				//уголовная 1-ая инстанция
				//постановление
				else if ($TipDela==113 and $VidDela=='01' and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and ($VERDICT_ID==50910001 or $VERDICT_ID==50910003 or $VERDICT_ID==50910004) and $kod_NameDoc==450007){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
  				//уголовные дела. Апелляция
				//постановление
else if ($TipDela==112 and $VidDela=='01' and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and ($VERDICT_ID<>50910000) and $kod_NameDoc==450007){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				//приговор
				else if ($TipDela==113 and $VidDela=='01' and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and ($VERDICT_ID<>50910001 and $VERDICT_ID<>50910003 and $VERDICT_ID<>50910004) and $kod_NameDoc==450005){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
                                //уголовные дела. Апелляция
				//приговор
				else if ($TipDela==112 and $VidDela=='01' and (substr($ZAVNUMKSA,2,2)<>'OS' and substr ($ZAVNUMKSA,2,2)<>'OV' and substr ($ZAVNUMKSA,2,2)<>'KJ' and substr ($ZAVNUMKSA,2,2)<>'AJ' and substr ($ZAVNUMKSA,2,2)<>'KV' and substr ($ZAVNUMKSA,2,2)<>'AV') and ($VERDICT_ID==50910000) and $kod_NameDoc==450005){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}


				else if ($TipDela==115 and $VidDela==1 and $kod_NameDoc==450007){$strTypeDocum=$strTypeDocum."<OPTION selected value=$kod_NameDoc>$NameDoc</OPTION>";$TypeDoc=$NameDoc;}
				else{$strTypeDocum=$strTypeDocum."<OPTION value=$kod_NameDoc>$NameDoc</OPTION>";}
 			}
   			oci_free_statement($stmt2);
		}
		$NAME_DOCUM="";
		if ($YES_BSR==""){$str='<input type="checkbox" name="chb[]" value="'.$DELO_ID.'" onclick="SelectDela('.$DELO_ID.');">';}
		else {$str='<IMG SRC="..\Image\apply.bmp">';}

		if ($VidDela<>'05' and $TipDela=='114'){
			$strokaPecat=$strokaPecat.' 	<TR align="center">
    		<TD class="stTd" width="2%">'.$str.'</TD>
    		<TD class="stTd" width="7%"><a href="javascript: void(0);" ID=ss'.$DELO_ID.' onClick="OpenHREF('.$DELO_ID.','.$TipDela.','.$VidDela.','.$DOCUM_ID.',\''.$TypeDoc.'\');"  onmouseout="hidden_text()">'.$DELO_NUMBER.'</a></TD>
    		<TD class="stTd" width="7%">'.substr($DELO_DATA_VERDICT,0,10).'</TD>';
		}
		else{$strokaPecat=$strokaPecat.' 	<TR align="center">
    		<TD class="stTd" width="2%">'.$str.'</TD>
    		<TD class="stTd" width="7%"><a href="javascript: void(0);" ID=ss'.$DELO_ID.' onClick="OpenHREF('.$DELO_ID.','.$TipDela.','.$VidDela.','.$DOCUM_ID.',\''.$TypeDoc.'\');">'.$DELO_NUMBER.'</a></TD>
    		<TD class="stTd" width="7%">'.substr($DELO_DATA_VERDICT,0,10).'</TD>';
		}

		if ($fTEXT=='0') {$strokaPecat=$strokaPecat."<TD class='stTd' width='25%'><a href = svdoc.php?ID_DOC=$DOCUM_ID&VID_DELA=$VidDela&TIP_DELA=$TipDela TARGET='_blank' >Электронная копия судебного документа</a></TD>";}
		else {$strokaPecat=$strokaPecat."<TD class='stTd' width='25%'><INPUT id=df".$DELO_ID." type=file name=df".$DELO_ID." style=\"WIDTH: 100%;\"></SELECT></TD>";}
		$strokaPecat=$strokaPecat.$strTypeDocum."</SELECT></TD>";

		if ($_SESSION["VERDICT"]==1){$strokaPecat.='<TD  class="stTd" width="12%">'.GetNameByCod($dbcnx,$VERDICT_ID).'</TD>';}
		if ($SUD_DOKLAD>0){
   			$strokaPecat=$strokaPecat."<TD class='stTd' width=\"19%\"><SELECT style='WIDTH: 250px' name=group".$DELO_ID.">";
 			$stmt2 = JosImmidiate($dbcnx, "select TO_CHAR(ID_GROUP) as ID_GROUP from users_group where ID_JUDGE='".$SUD_DOKLAD."'");
			$ID_GROUP_USERS = ociresult($stmt2,"ID_GROUP");
			oci_free_statement($stmt2);

			$stmt2 = JosImmidiate($dbcnx, "select count(*) as USERS_COUNT from users_group_param where ID_USER = (select ID_USER from users where ID_JUDGE=$SUD_DOKLAD)");
			$USERS_COUNT = ociresult($stmt2,"USERS_COUNT");
			oci_free_statement($stmt2);

			if ($USERS_COUNT>0){
				$stmt2 = JosPrepareAndExecute($dbcnx, "select ID_GROUP,(select FIO from USERS where name_group = users.username) as NAME1, NAME_GROUP from users_group where id_judge = ".$SUD_DOKLAD);
				while(ocifetch($stmt2)){
					if (ociresult($stmt2,"NAME1") == ''){$strokaPecat=$strokaPecat."<OPTION selected value=".ociresult($stmt2,"ID_GROUP").">".ociresult($stmt2,"NAME_GROUP")."</OPTION>";}
					else {$strokaPecat=$strokaPecat."<OPTION selected value=".ociresult($stmt2,"ID_GROUP").">".ociresult($stmt2,"NAME1")."</OPTION>";}
				}
				oci_free_statement($stmt2);
			}
			else {
				$stmt2 = JosPrepareAndExecute($dbcnx, "select NAME_GROUP,TO_CHAR(ID_GROUP) as ID_GROUP from users_group");
				while(ocifetch($stmt2)){
					$NameGroup = ociresult($stmt2,"NAME_GROUP");
					$ID_Group = ociresult($stmt2,"ID_GROUP");
		//самков
					if ($ID_Group."_" == $ID_GROUP_USERS."_"){$strokaPecat=$strokaPecat."<OPTION selected value=$ID_Group>$NameGroup</OPTION>";}
					else {$strokaPecat=$strokaPecat."<OPTION value=$ID_Group>$NameGroup</OPTION>";}
					//$strokaPecat=$strokaPecat."<OPTION value=$ID_Group>$NameGroup</OPTION>";
				}
				oci_free_statement($stmt2);
			}

		}
		else{
			$strokaPecat=$strokaPecat."<TD class='stTd' width=\"19%\"><SELECT enable style='WIDTH: 250px' name=group".$DELO_ID.">";
			if ($DOKLAD_SUD == 0 || is_null($DOKLAD_SUD)){
				$DOKLAD_SUD = 1;
			}
			$stmt2 = JosImmidiate($dbcnx, "select TO_CHAR(ID_GROUP) as ID_GROUP from users_group where ID_JUDGE=".$DOKLAD_SUD);
			$ID_GROUP_USERS = ociresult($stmt2,"ID_GROUP");
			oci_free_statement($stmt2);

			if ($ID_GROUP_USERS > 0){

				$stmt2 = JosPrepareAndExecute($dbcnx, "select ID_GROUP,(select FIO from USERS where name_group = users.username) as NAME1, NAME_GROUP from users_group where id_judge = ".$DOKLAD_SUD);
				while(ocifetch($stmt2)){
					if (ociresult($stmt2,"NAME1") == ''){$strokaPecat=$strokaPecat."<OPTION selected value=".ociresult($stmt2,"ID_GROUP").">".ociresult($stmt2,"NAME_GROUP")."</OPTION>";}
					else {$strokaPecat=$strokaPecat."<OPTION selected value=".ociresult($stmt2,"ID_GROUP").">".ociresult($stmt2,"NAME1")."</OPTION>";}
				}
				oci_free_statement($stmt2);
			}
			else {
				$stmt3 = JosPrepareAndExecute($dbcnx, "select ID_GROUP,(select FIO from USERS where name_group = users.username) as NAME1, NAME_GROUP from users_group");
				while(ocifetch($stmt3)){
					if (ociresult($stmt3,"ID_GROUP")==1){
						$strokaPecat=$strokaPecat."<OPTION value=".ociresult($stmt3,"ID_GROUP").">".'Нет (доступно всем пользователям)'."</OPTION>";
}
					else {
					if (ociresult($stmt3,"NAME1") == ''){$strokaPecat=$strokaPecat."<OPTION value=".ociresult($stmt3,"ID_GROUP").">".ociresult($stmt3,"NAME_GROUP")."</OPTION>";}
					else {$strokaPecat=$strokaPecat."<OPTION value=".ociresult($stmt3,"ID_GROUP").">".ociresult($stmt3,"NAME1")."</OPTION>";}


//$strokaPecat=$strokaPecat."<OPTION value=".ociresult($stmt3,"ID_GROUP").">".ociresult($stmt3,"NAME")."</OPTION>";
					}
				}
				oci_free_statement($stmt3);
			}

		}

		if ($DOCUM_ID!=0){
		$DocCount=$DocCount-1;}


	$strokaPecat.="</SELECT></TD><TD id=".$DELO_ID." class='stTd' width='12%'>$KOM <br>Количество промежуточных документов : $DocCount</TD></TR>";

		$TCount=$TCount+1;
	/*	if ($param>1){
			$strokaFunc=Func($dbcnx,$VidDela,$TipDela,$massVrnSvDel,$DELO_ID);
			if ($strokaFunc){$strokaPecat.=$strokaFunc;}
    	}
    	if($nNumDelaFirst<>"материал" and $nNumDelaFirst<>"м/л" and $nNumDelaFirst<>"б/н" and $nNumDelaFirst<>"" and $nNumDelaFirst<>"б-н"){
			$strokaFunc=Func_find_agora($dbcnx,$DELO_ID,$nNumDelaFirst,$VidDela,$TipDela,$ZAVNUMKSA);
			if ($strokaFunc){$strokaPecat.=$strokaFunc;}
		}*/
		$DELO_DATA_VERDICT='';
	}
	oci_free_statement($stmt);
	if ($NCOUNT==0)
    {
        echo "<P><P><a href='#' onclick='javascript: document.parameters.submit();'><H3> Данных по запросу не найдено. Вернитесь на стартовую страницу.</H3></a>";
    }
    else
    {
        echo '<P><P><a href="#" onclick="javascript: document.parameters.submit();"><H3>Вернуться к параметрам поиска</H3></a>';
    }
	$strokaPecat=$strokaPecat.'</TABLE><P>
		<Input align="right" type="submit" id="pbSave" name="pbDelete" value="Загрузить">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<INPUT id=dpage type="hidden" name="pageP"  value='.$pageFirst.'>';
	if ($TCount<>0){echo $strokaPecat;}
	if ($Take>$NCOUNT){$Take=$NCOUNT;}

	return generate_pagination("svConnect.php", $NCOUNT, $KOLVODEL, $pageFirst,$TipDela,$VidDela,$_SESSION["GOD"],$MON,$SUD_DOKLAD,$massNach,$massKon,TRUE);
 }


?>