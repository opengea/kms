<?

// ----------------------------------------------
// Class Ecommerce TPV for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_tpv_transactions extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_tpv_transactions";
	var $key	= "id";	
	var $fields = array("id","creation_date", "mode","client_id", "customer", "agent","order","status","tpv_response","description","amount","agent_fee","paid_on_date");
        var $sum        = array("amount","agent_fee");

	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $can_add = false;
	var $can_duplicate = true;
       //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_tpv_transactions ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->humanize("creation_date","Data");
		$this->humanize("order","N&uacute;m. ordre");
		$this->humanize("tpv_response","Resposta TPV");
		$this->humanize("agent","Sistema");
		$this->default_content_type = "ecom_tpv";
		$this->insert_label = _NEW_TPV;
//		$this->setComponent("select","status",array("OK"=>"<font color=#009900>OK</font>","KO"=>"<font color=#ff0000>KO</font>"));
		$this->setComponent("uniselect","status");
		$this->setComponent("select","card_country",array("250"=>"Fran&ccedil;a","724"=>"Espanya","840"=>"EUA","124"=>"Canad&agrave;","20"=>"Andorra","020"=>"Andorra","0"=>"0"));
		$this->setComponent("select","tpv_response",array("0000"=>"Acceptada","0184"=>"Error d'autenticaci&oacute;","0913"=>"Duplicada","0190"=>"Denegada pel banc emisor","9915"=>"Cancel&middot;lat","0180"=>"No perm&egrave;s per tipus targeta"));

$this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xkey"=>"id","xfield"=>"email","readonly"=>true,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

//       $this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
/*

		$this->setComponent("xcombo","card_country",array("004"=>"Afganistan","178"=>"Congo","360"=>"Indonèsia","008"=>"Alb&agrave;nia","180"=>"Zaire","364"=>"Iran","010"=>"Ant&agrave;rtida","184"=>"Cook","368"=>"Iraq","012"=>"Algèria","188"=>"Costa Rica","372"=>"Irlanda","016"=>"Samoa americana","191"=>"Cro&agrave;cia","376"=>"Israel","020"=>"Andorra","192"=>"Cuba","380"=>"It&agrave;lia","024"=>"Angola","196"=>"Xipre","384"=>"Costa","028"=>"Antigua i Barbuda","203"=>"Txèquia","388"=>"Jamaica","031"=>"Azerbaidjan","204"=>"Benín","392"=>"Japó","032"=>"Argentina","208"=>"Dinamarca","398"=>"Kazajstan","036"=>"Aus&agrave;lia","212"=>"Dominica","400"=>"Jord&agrave;nia","040"=>"&Agrave;ustria","214"=>"Dominicana","404"=>"Kenya","044"=>"Bahames","218"=>"Equador","408"=>"Corea","048"=>"Bahrain","222"=>"El Salvador","410"=>"Corea","050"=>"Bangladesh","226"=>"Guinea Equatorial","414"=>"Kuwait","051"=>"Arm&egrave;nia","230"=>"Eti&ograve;pia","417"=>"Kirguizistan","052"=>"Barbados","233"=>"Est&ograve;nia","418"=>"Laos","056"=>"Bèlgica","234"=>"Feroe","422"=>"&iacute;ban","060"=>"Bermudes","238"=>"Malvines","426"=>"Lesotho","064"=>"Bhutan","242"=>"Fiji","428"=>"Let&ograve;nia","068"=>"Bol&iacute;via","246"=>"Fin&agrave;ndia","430"=>"Lib&egrave;ria","070"=>"&ograve;snia i Hercegovina","250"=>"França","434"="L&iacute;bia","072"=>"Botswana","254"=>"Guaiana francesa","438"=>"Liechtenstein","074"=>"Bouvet","258"=>"Polin&egrave;sia francesa","440"=>"Litu&agrave;nia","076"=>"Brasil","260"=>"Territori Del sud franc&egrave;s","442"=>"Luxemburg","084"=>"Belize","262"=>"Jibuti","446"=>"Macau","086"=>"Maurici","266"=>"Gabon","450"=>"Madagascar","090"=>"Salom&oacute;","268"=>"Ge&ograve;rgia","454"=>"Malawi","092"=>"Verges brit&agrave;niques","270"=>"G&agrave;mbia","458"=>"Mal&agrave;isia","096"=>"Brunei","280"=>"Alemanya","462"=>"Maldives","100"=>"Bulg&agrave;ria","288"=>"Ghana","466"=>"Mali","104"=>"Birm&agrave;nia","292"=>"Gibraltar","470"=>"Malta","108"=>"Burundi","296"=>"Kiribati","474"=>"Martinica","112"=>"Bielor&uacute;ssia","300"=>"Grècia","478">"Maurit&agrave;nia","116"=>"Cambodja","304"=>"Grenl&agrave;ndia","480"=>"Maurici","120"=>"Camerun","308"=>"Granada","484"=>"M&egrave;xic","124"=>"Canad&agrave;","312"=>"Guadalupe","492"=>"M&ograve;naco","132"=>"Cap Verd","316"=>"Guam","496"=>"Mong&ograve;lia","136"=>"Caiman","320"=>"Guatemala","498"=>"Mold&agrave;via","140"=>"Centre &Agrave;frica","324"=>"Guinea","500"=>"Monserrat","144"=>"Sri Lanka","328"=>"Guaiana","504"=>"Marroc","148"=>"Txad","332"=>"Hait&iacute;","508"=>"Moçambic","152"=>"Xile","334"=>"Hear"d,"512"=>"Oman","156"=>"Xina","336"=>"Vatic&agrave;(Ciutat Estat)","516"=>"Namíbia","158"=>"Taiwan","340"=>"Hondures","520"=>"Nauru","162"=>"Christmas","344"=>"Hong Kong","524"=>"Nepal","166"=>"Cocos","348"=>"Hongria","528"=>"Holanda ","170"=>"Colòmbia","352"=>"Isl&agrave;ndia","530"=>"Antilles neerlandeses","174"=>"Comores","356"=>"&Iacute;ndia","533"=>"Aruba","540"=>"Nova Caled&ograve;nia","646"=>"Rwanda"));
/*
,"762"=>"Tadjikistan","548"=>"Vanuatu,"654"=>"Santa Helena","764"=>"Tailàndia","554"=>"Nova Zelanda","659"=>"Anguila","768"=>"Togo","558"=>"Nicaragua","662"=>"Saint Lucia","776"=>"Tonga","562"=>"Níger","666"=>"Saint Pierre i Miquelon","780"=>"Trinitat i Tobago","566"=>"Nigèria","670"=>"San Vicente i Granadina","784"=>"Emirats Àrabs","570"=>"Niue","674"=>"San Marino,"788"=>"Tunísia","574"=>"Norfolk,"678"=>"São Tomé i Principe","792"=>"Turquia","578"=>"Noruega","682"=>"Aràbia Saudita","795"=>"Turkmenistan","580"=>"Marianes Septentrionals","686"=>"Senegal,"796"=>"Turks i Caicos","581"=>"Minor (Estats Units),"690"=>"Seychelles","798"=>"Tuvalu","582"=>"Pacifico,"694"=>"Sierra Leona","800"=>"Uganda","583"=>"Micronèsia","702"=>"Singapur","804"=>"Ucraïna","584"=>"Marshall,"703"=>"Eslovàquia","807"=>"Macedònia","586"=>"Pakistan","704"=>"Vietnam,"818"=>"Egipte","591"=>"Panamà,"705"=>"Eslovènia","826"=>"Regne Unit","598"=>"Papua-Nova Guinea","706"=>"Somàlia","834"=>"Tanzània","600"=>"Paraguai,"710"=>"Sud-àfrica","840"=>"Estats Units","604"=>"Perú,"716"=>"Zimbabwe","849"=>"miscellaneous (Estats Units)","608"=>"Filipines","720"=>"Iemen","850"=>"Verges americanes","612"=>"Pitcairn","722"=>"Tokelau,"854"=>"Burkina","616"=>"Polònia","724"=>"Espanya","858"=>"Uruguai","620"=>"Portugal,"736"=>"Sudan","860"=>"Uzbekistan","624"=>"Guinea Bissau,"740"=>"Surinam,"862"=>"Veneçuela","626"=>"Timor","744"=>"Svalbard i Jan Mayen","876"=>"Wallis i Fortuna","630"=>"Puerto Rico,"748"=>"Suazinlandia","882"=>"Samoa","634"=>"Qatar","752"=>"Suècia","886"=>"Iemen","638"=>"Reunió,"756"=>"Suïssa","891"=>"Iugoslàvia","642"=>"Romania","760"=>"Síria","894"=>"Zàmbia","643"=>"Rússia" )

*/
	}
}
?>
