<?
// variables replacement de kms_mailings

                for ($i=0;$i<mysql_num_fields($result_mailings);$i++) {
                        $fieldname = mysql_field_name ($result_mailings, $i);
                        $posicio_inicial = strpos($template,'['.$fieldname);
                        if ($posicio_inicial!="") {
                        $posicio_final =  strpos($template,']',$posicio_inicial);
                        $longitud =  $posicio_final-$posicio_inicial+1;
                        $variable = substr($template,$posicio_inicial, $longitud);
                        // si te definida longitud maxima l'extreiem
                           if (strpos($variable,":")) {
                                   $p=strpos($variable,":");
                                   $l = (string)((int)(strlen($variable))-3);
                                   $limit_chars = substr($variable,$p+1,$l-$p+1);
                                   $variable = substr($variable,0,$p)."]";
                           } else {
                                     //no limit
                                   $limit_chars = 9999999999;
                           }
                           if (!strpos($variable,".")) {
                                      // si es variable simple
                                      $pos_original = strpos($fieldname,'_original');
                                      if ($pos_original>0) {$width="width=\"100%\"";$pre_img=""; $xfield=substr($fieldname,0,$pos_original);} else {$pre_img="img_";$width="";}
                                      // si es data, reemplacem dates
                                      if (is_date($current_mailing[$fieldname])) { $body=str_replace($variable,date('d-m-Y',strtotime($current_mailing[$fieldname])),$body);
                                      } else if (($fieldname!="body")&&(strpos(strtolower($current_mailing[$fieldname]),".jpg")||strpos(strtolower($current_mailing[$fieldname]),".png")||strpos(strtolower($current_mailing[$fieldname]),".gif"))) {
                                                // si es imatge, reemplacem imatge
                                                 $body=str_replace($variable,"<img alt=\"\" ".$width." src=\"//data.".$client_account['domain']."/files/pictures/".$pre_img.$current_mailing[$fieldname]."\"><br>",$body);

                                      } else {  // reemplacem la resta
                                             $body=str_replace($variable,$current_mailing[$fieldname],$body);
                                      }


                           } else {
                                        // variable relacionada (format: [camp base de dades mailing.taula relacionada.camp taula relacionada] )
                                        // cal iterar pq poden haber-n'hi varies, per exemple sr_article1.picture, sr_article1.title, etc. 
                                        for ($j=0;$j<substr_count($template,$fieldname);$j++) {
                                        $xtable = substr ($variable,strpos($variable,'.')+1,strrpos($variable,'.')-strpos($variable,'.')-1);
                                        $first = strpos($variable,'.');
                                        $last = strrpos($variable,'.');
                                        $len = (string)((int)$last-(int)$first);
                                        $xfield = substr ($variable,(int)($last)+1);$xfield = substr ($xfield,0,strlen($xfield)-1);
        //                              $select = "SELECT ".$xfield." FROM ".$xtable." WHERE id=".$current_mailing[$fieldname];
                                        $select = "SELECT * FROM ".$xtable." WHERE id=".$current_mailing[$fieldname];
//echo $fieldname."--".$select."<br>";
                                        if ($current_mailing[$fieldname]!="") {
                                                $result_data = mysql_query($select);
                                                if (!$result_data) {echo "error 2 :".$select.mysql_error();exit;}
                                                $fetch_row = mysql_fetch_array($result_data);
                                        } else {
                                                $fetch_row  = Array();
                                        }
                                        // si es imatge, posem-li el tag <img>
                                        //limitador de caracters
                                        //$camp = strip_tags($fetch_row[$xfield]);
                                        //la seguent mandanga serveix per eliminar les tipografies incrustades dins del <p> i dem�s alteracions html que no ens interessin.
                                        $allowedtags = "<font><a><br><b><i><u><strong><em><li><ul>";

                                        $pos_original = strpos($xfield,'_original');
                                        if ($pos_original>0) {$width="width=\"100%\"";$pre_img=""; $xfield=substr($xfield,0,$pos_original);} else {$pre_img="img_";$width="";}

                                        $camp = str_replace('</p>','<br><br>',$fetch_row[$xfield]);
                                        $camp = str_replace('<br>','!BR!',$camp);
                                        $camp = strip_tags($camp,$allowedtags);
                                        $camp = str_replace('!BR!','<br>',$camp);
                                        if (substr($camp,0,4)=="<br>") $camp = substr($camp,4,strlen($camp));
//echo $fetch_row[$xfield];
                                        if (strlen($camp)>$limit_chars) $fetch_row[$xfield] = substr($camp,0,$limit_chars)."... "; else $fetch_row[$xfield] = substr($camp,0,strlen($camp));
                                        // per evitar que apliqui estil a titols
                                        $select_nom_blog="SELECT name FROM kms_web_blogs WHERE id=".$fetch_row['blogid'];
                                        $result_nom_blog = mysql_query($select_nom_blog);
                                        $blog = mysql_fetch_array($result_nom_blog);

if ($lang['_KMS_WEB_BLOG_READFULLPOST']!="") $readfull = $lang['_KMS_WEB_BLOG_READFULLPOST']; else $readfull=constant('_KMS_WEB_BLOG_READFULLPOST');

                                        if (($xfield=="body"||$xfield=="short_body")) $fetch_row[$xfield] =  "<span class=\"text\">".$fetch_row[$xfield]." <a href='//www.".$current_domain."/".$blog['name']."/".urlize($fetch_row['title'].$fetch_row['weblink'])."' style='text-decoration:none' title='".$readfull."'><span style='text-transform:uppercase'>".$readfull."</span></a></span>";
                                        if ($xfield=="title"||$xfield=="title_short") $fetch_row[$xfield] = " <a href='//www.".$current_domain."/".$blog['name']."/".urlize($fetch_row['title'].$fetch_row['weblink'])."' style='text-decoration:none' title='".$readfull."'>".$fetch_row[$xfield]."</a>";

                                         if (is_date($fetch_row[$xfield])) $body=str_replace('['.$xfield.']',date('d-m-Y',strtotime($fetch_row[$xfield])),$body);
//echo $xfield;exit;
                                        if (($xfield!="body")&&(strpos(strtolower($fetch_row[$xfield]),".jpg")||strpos(strtolower($fetch_row[$xfield]),".png")||strpos(strtolower($fetch_row[$xfield]),".gif"))) { $body=str_replace($variable,"<img alt=\"\" ".$width." src=\"//data.".$client_account['domain']."/files/pictures/".$pre_img.$fetch_row[$xfield]."\"><br>",$body); } else { $body=str_replace($variable,$fetch_row[$xfield],$body);}
                                        if ($j<substr_count($template,$fieldname)) {
                                                // preparem seguent variable
                                                $posicio_inicial = strpos($template,'['.$fieldname,$posicio_final+1);

                                                $posicio_final = strpos($template,']',$posicio_inicial);
                                                $longitud = $posicio_final-$posicio_inicial+1;
                                                $variable = substr($template,$posicio_inicial,$longitud);
                                                   if (strpos($variable,":")) {
                                                           $p=strpos($variable,":");
                                                           $l = (string)((int)(strlen($variable))-3);
                                                           $limit_chars = substr($variable,$p+1,$l-$p+1);
                                                           $body=str_replace($variable,substr($variable,0,$p)."]",$body);
                                                           $variable = substr($variable,0,$p)."]";
                                                   } else {
                                                             //no hi ha limit
                                                           $limit_chars = 99999999990;
                                                  }
                                                }
                                        }
                                }
                        }
                } // FOR variables replacement

