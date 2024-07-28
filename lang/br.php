<?php
/**
* @version $Id: catala.php 04.062007 XIntergrid <intergrid.cat>
* @translator: Jordi Berenguer <www.intergrid.cat>
* @package Mediabase
* @copyright Copyright (C) 2007 Intergrid. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/


// Site page note found
define( '_404', 'La pàgina a la que vols accedir no ha estat trobada.' );
define( '_404_RTS', 'Tornar al lloc' );
define( '_SYSERR1', 'L\'adaptador de la base de dades no està disponible' );
define( '_SYSERR2', 'No puc connectar-me amb la base de dades del servidor' );
define( '_SYSERR3', 'No puc connectar-me a la base de dades' );

/** common */
DEFINE('_LANGUAGE','ca');
DEFINE('_NOT_AUTH','No tens autorització per accedir a aquest apartat.');
DEFINE('_DO_LOGIN','Necessites accedir primer.');
DEFINE('_VALID_AZ09',"Escriu un %s vàlid, sense espais en blanc amb més de %d caràcters i que contingui 0-9,a-z,A-Z");
DEFINE('_VALID_AZ09_USER',"Escriu un %s válid.  Amb més de %d caràcters i que contingui 0-9,a-z,A-Z");
DEFINE('_CMN_YES','Sí');
DEFINE('_CMN_NO','No');
DEFINE('_CMN_SHOW','Mostrar');
DEFINE('_CMN_HIDE','Amagar');

DEFINE('_CMN_NAME','Nom');
DEFINE('_CMN_DESCRIPTION','Descripció');
DEFINE('_CMN_SAVE','Desar');
DEFINE('_CMN_APPLY','Aplicar');
DEFINE('_CMN_CANCEL','Cancel·lar');
DEFINE('_CMN_PRINT','Imprimir');
DEFINE('_CMN_PDF','PDF');
DEFINE('_MB_START','Start');
DEFINE('_MB_BACK','<');
DEFINE('_CMN_EMAIL','a/e');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Pare');
DEFINE('_CMN_ORDERING','Ordre');
DEFINE('_CMN_ACCESS','Nivell d\'accés');
DEFINE('_CMN_SELECT','Selecciona');

DEFINE('_CMN_NEXT','Següent');

DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Anterior');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','Sense ordenar');
DEFINE('_CMN_SORT_ASC','a-Z 0-9');
DEFINE('_CMN_SORT_DESC','Z-a 9-0');

DEFINE('_CMN_NEW','Nou');
DEFINE('_CMN_NONE','Res');
DEFINE('_CMN_LEFT','Esquerra');
DEFINE('_CMN_RIGHT','Dreta');
DEFINE('_CMN_CENTER','Centrat');
DEFINE('_CMN_ARCHIVE','Arxivar');
DEFINE('_CMN_UNARCHIVE','Desarxivar');
DEFINE('_CMN_TOP','Superior');
DEFINE('_CMN_BOTTOM','Inferior');

DEFINE('_CMN_PUBLISHED','Publicat');
DEFINE('_CMN_UNPUBLISHED','No publicat');

DEFINE('_CMN_EDIT_HTML','Editar HTML');
DEFINE('_CMN_EDIT_CSS','Editar CSS');

DEFINE('_CMN_DELETE','Esborrar');

DEFINE('_CMN_FOLDER','Carpeta');
DEFINE('_CMN_SUBFOLDER','Subcarpeta');
DEFINE('_CMN_OPTIONAL','Opcional');
DEFINE('_CMN_REQUIRED','Obligatori');

DEFINE('_CMN_CONTINUE','Continuar');

DEFINE('_STATIC_CONTENT','Contingut estàtic');

DEFINE('_CMN_NEW_ITEM_LAST','Per defecte els nous articles apareixeran en darrera posició');
DEFINE('_CMN_NEW_ITEM_FIRST','Per defecte els nous articles apareixeran en primera posició');
DEFINE('_LOGIN_INCOMPLETE','Omple els camps Nom d\'usuari i Contrasenya.');
DEFINE('_LOGIN_BLOCKED','El teu compte d\'accés ha estat bloquejat. Si us plau, contacta amb l\'administrador del web.');
DEFINE('_LOGIN_INCORRECT','Nom d\'usuari i/o Contrasenya incorrecta. Si us plau, intenta-ho novament.');
DEFINE('_LOGIN_NOADMINS','No has entrat o no hi ha cap administrador configurat.');
DEFINE('_CMN_JAVASCRIPT','Atenció! Per poder realitzar aquesta operació has de tenir activat Javascript.');

DEFINE('_NEW_MESSAGE','Tens un nou missatge privat');
DEFINE('_MESSAGE_FAILED','L\'usuari té la bústia bloquejada o plena. El missatge no s\'ha pogut enviar.');

DEFINE('_CMN_IFRAMES', 'Aquesta opció no funcionarà correctament. El teu navegador no soporta IFRAMES');
DEFINE('_INSTALL_3PD_WARN','Avís: A l\'instal·lar extensions de tercers pots comprometre la seguretat del teu servidor. A l\'actualitzar la teva versió de Joomla! aquesta no àctualitzarà les extensions afegides y de tercers.<br />Per tal d\'obtenir més informació de com mantenir el teu lloc web més segur accedeix a <a href="http://forum.joomla.org/index.php/board,267.0.html" target="_blank" style="color: blue; text-decoration: underline;">Joomla! Fòrums de seguretat</a> en inglés.');
DEFINE('_INSTALL_WARN','Per motius de seguretat has d\'esborrar completament el directori \'installation\' amb tots els arxius i subdirectoris que conté  - Després refresca aquesta pàgina');
DEFINE('_TEMPLATE_WARN','<font color=\"red\"><b>No he trobat la plantilla!</b></font><br />Segurament no has seleccionat la plantilla o<br />bé no tens cap plantilla al directori \'templates\'<br />Si tens plantilles al directori, aleshores, accedeix<br /> a l\'administració de Joomla! i tria una plantilla.');
DEFINE('_NO_PARAMS','No hi ha paràmetres per aquest article');
DEFINE('_HANDLER','Sense definir');

/** mambots */
DEFINE('_TOC_JUMPTO','Índex de l\'article');

/**  content */
DEFINE('_READ_MORE','Article complet...');
DEFINE('_READ_MORE_REGISTER','Has d\'estar registrat per poder llegir l\'article complet...');
DEFINE('_MORE','Més...');
DEFINE('_ON_NEW_CONTENT', "[ %s ] ha enviat un article nou amb el títol [ %s ] per a la secció [ %s ] i la categoria [ %s ]" );
DEFINE('_SEL_CATEGORY','- Selecciona una categoria -');
DEFINE('_SEL_SECTION','- Selecciona una secció -');
DEFINE('_SEL_AUTHOR','- Selecciona un autor -');
DEFINE('_SEL_POSITION','- Selecciona una posició -');
DEFINE('_SEL_TYPE','- Selecciona un tipus -');
DEFINE('_EMPTY_CATEGORY','La categoria, actualment, és buida');
DEFINE('_EMPTY_BLOG','No hi ha articles per mostrar');
DEFINE('_NOT_EXIST','La pàgina a la que vols accedir ja no existeix.<br />Aquesta és una web viva i dinàmica amb actualitzacions constants, per aquest motiu algunes pàgines de continguts desapareixen de la web. Escull una opció dels menús per tal de continuar la teva visita per la web, si us plau.');
DEFINE('_SUBMIT_BUTTON','Trametre');

/** classes/html/modules.php */
DEFINE('_BUTTON_VOTE','Votar');
DEFINE('_BUTTON_RESULTS','Resultats');
DEFINE('_USERNAME','Nom d\'usuari');
DEFINE('_LOST_PASSWORD','Recuperar contrasenya?');
DEFINE('_PASSWORD','Contrasenya');
DEFINE('_BUTTON_LOGIN','Entrar');
DEFINE('_BUTTON_LOGOUT','Sortir');
DEFINE('_NO_ACCOUNT','Vols registrar-te?');
DEFINE('_CREATE_ACCOUNT','Fes-ho aquí');
DEFINE('_VOTE_POOR','Dolent');
DEFINE('_VOTE_BEST','Bo');
DEFINE('_USER_RATING','Qualificació dels usuaris');
DEFINE('_RATE_BUTTON','Qualificar');
DEFINE('_REMEMBER_ME','Recordar-me');

/** contact.php */
DEFINE('_ENQUIRY','Sol·licitud');
DEFINE('_ENQUIRY_TEXT','Aquest correu ha estat enviat mitjançant %s des de');
DEFINE('_COPY_TEXT','Això és una cópia del missatge que has enviat a %s mitjançant %s');
DEFINE('_COPY_SUBJECT','Cópia de: ');
DEFINE('_THANK_MESSAGE','Gràcies pel missatge');
DEFINE('_CLOAKING','Aquesta adreça de correu electrònica està protegida contra els robots d\'spam, necessites activar Javascript per veure-la');
DEFINE('_CONTACT_HEADER_NAME','Nom');
DEFINE('_CONTACT_HEADER_POS','Càrrec');
DEFINE('_CONTACT_HEADER_EMAIL','A/e');
DEFINE('_CONTACT_HEADER_PHONE','Telèfon');
DEFINE('_CONTACT_HEADER_FAX','Fax');
DEFINE('_CONTACTS_DESC','Llista de contacte del web.');
DEFINE('_CONTACT_MORE_THAN','No pots incorporar més d\'una adreça electrònica.');

/** classes/html/contact.php */
DEFINE('_CONTACT_TITLE','Contactar');
DEFINE('_EMAIL_DESCRIPTION','Enviar missatge al contacte:');
DEFINE('_NAME_PROMPT',' Escriu el teu nom:');
DEFINE('_EMAIL_PROMPT',' Escriu la teva adreça electrònica:');
DEFINE('_MESSAGE_PROMPT',' Escriu el missatge:');
DEFINE('_SEND_BUTTON','Trametre');
DEFINE('_CONTACT_FORM_NC','Si us plau, revisa que el formulari estigui complet i amb dades vàlides.');
DEFINE('_CONTACT_TELEPHONE','Telèfon: ');
DEFINE('_CONTACT_MOBILE','Mòbil: ');


DEFINE('_CONTACT_FAX','Fax: ');
DEFINE('_CONTACT_EMAIL','c/e: ');
DEFINE('_CONTACT_NAME','Nom: ');
DEFINE('_CONTACT_POSITION','Càrrec: ');
DEFINE('_CONTACT_ADDRESS','Adreça: ');
DEFINE('_CONTACT_MISC','Informació: ');
DEFINE('_CONTACT_SEL','Tria un contacte:');
DEFINE('_CONTACT_NONE','No hi ha detalls de contacte.');
DEFINE('_CONTACT_ONE_EMAIL','No pots incorporar més d\'una adreça electrònica.');
DEFINE('_EMAIL_A_COPY','Cópia del missatge a la teva adreça electrònica?');
DEFINE('_CONTACT_DOWNLOAD_AS','Descarregar informació com a');
DEFINE('_VCARD','VCard');

/** pageNavigation */
DEFINE('_PN_LT','&lt;');
DEFINE('_PN_RT','&gt;');
DEFINE('_PN_PAGE','Pàgina');
DEFINE('_PN_OF','de');
DEFINE('_PN_START','Inici');
DEFINE('_PN_PREVIOUS','Anterior');
DEFINE('_PN_NEXT','Següent');
DEFINE('_PN_END','Final');
DEFINE('_PN_DISPLAY_NR','Mostrant ');
DEFINE('_PN_RESULTS','Resultats');
/** emailfriend */
DEFINE('_EMAIL_TITLE','Enviar a un amic');
DEFINE('_EMAIL_FRIEND','Enviar per correu a un amic.');
DEFINE('_EMAIL_FRIEND_ADDR','a/e del teu amic:');
DEFINE('_EMAIL_YOUR_NAME','El teu nom:');
DEFINE('_EMAIL_YOUR_MAIL','El teu c/e:');
DEFINE('_SUBJECT_PROMPT',' Títol del missatge:');
DEFINE('_BUTTON_SUBMIT_MAIL','Enviar correu electrònic');
DEFINE('_BUTTON_CANCEL','Cancel·lar');
DEFINE('_EMAIL_ERR_NOINFO','Tens que escriure la teva adreça electrònica i l\'adreça de destí.');
DEFINE('_EMAIL_MSG',' La següent pàgina del lloc web "%s" li ha estat enviat per %s ( %s ) perquè li ha semblat que podia ser del seu interès.

Pots accedir-hi mitjançant la següent adreça:
%s');
DEFINE('_EMAIL_INFO','Enviat per');
DEFINE('_EMAIL_SENT','Enviat a');
DEFINE('_PROMPT_CLOSE','Tancar finestra');

/** classes/html/content.php */
DEFINE('_AUTHOR_BY', ' autor');
DEFINE('_WRITTEN_BY', ' escrit per: ');
DEFINE('_LAST_UPDATED', 'Modificat el');
DEFINE('_BACK','[Tornar]');
DEFINE('_LEGEND','Llegenda');
DEFINE('_DATE','Data');
DEFINE('_ORDER_DROPDOWN','Ordre');
DEFINE('_HEADER_TITLE','Títol');
DEFINE('_HEADER_AUTHOR','Autor');
DEFINE('_HEADER_SUBMITTED','Lliurat el');
DEFINE('_HEADER_HITS','Accessos');
DEFINE('_E_EDIT','Editar');
DEFINE('_E_ADD','Afegir');
DEFINE('_E_WARNUSER','Cancel·la o guarda els canvis efectuats abans de sortir');
DEFINE('_E_WARNTITLE','L\'article ha de tenir un títol');
DEFINE('_E_WARNTEXT','L\'article ha de tenir un text d\'introducció');
DEFINE('_E_WARNCAT','Selecciona una categoria');
DEFINE('_E_CONTENT','Contingut');
DEFINE('_E_TITLE','Títol:');
DEFINE('_E_CATEGORY','Categoria:');
DEFINE('_E_INTRO','Text d\'introducció');
DEFINE('_E_MAIN','Text principal');
DEFINE('_E_MOSIMAGE','INSERIR {mosimage}');
DEFINE('_E_IMAGES','Imatges');
DEFINE('_E_GALLERY_IMAGES','Galeria d\'imatges');
DEFINE('_E_CONTENT_IMAGES','Imatges');
DEFINE('_E_EDIT_IMAGE','Editar imatge');
DEFINE('_E_NO_IMAGE','Sense imatge');
DEFINE('_E_INSERT','Inserir');
DEFINE('_E_UP','Pujar');
DEFINE('_E_DOWN','Baixar');
DEFINE('_E_REMOVE','Esborrar');
DEFINE('_E_SOURCE','Codi:');
DEFINE('_E_ALIGN','Alineació:');
DEFINE('_E_ALT','Text etiqueta:');
DEFINE('_E_BORDER','Bordó:');
DEFINE('_E_CAPTION','Peu de foto');
DEFINE('_E_CAPTION_POSITION','Posició del peu de foto');
DEFINE('_E_CAPTION_ALIGN','Alineació del peu de foto');
DEFINE('_E_CAPTION_WIDTH','Amplada del peu de foto');
DEFINE('_E_APPLY','Aplicar');
DEFINE('_E_PUBLISHING','Publicar');
DEFINE('_E_STATE','Estat:');
DEFINE('_E_AUTHOR_ALIAS','Àlies de l\'autor:');
DEFINE('_E_ACCESS_LEVEL','Nivell d\'accés:');
DEFINE('_E_ORDERING','Ordenat:');
DEFINE('_E_START_PUB','Inici de la publicació:');
DEFINE('_E_FINISH_PUB','Fi de la publicació:');
DEFINE('_E_SHOW_FP','Mostrar a la pàgina d\'inici:');
DEFINE('_E_HIDE_TITLE','Amagar títol?:');
DEFINE('_E_METADATA','Meta dades');
DEFINE('_E_M_DESC','Descripció:');
DEFINE('_E_M_KEY','Paraules:');
DEFINE('_E_SUBJECT','Títol:');
DEFINE('_E_EXPIRES','Data de caducitat:');
DEFINE('_E_VERSION','Versió:');
DEFINE('_E_ABOUT','Sobre');
DEFINE('_E_CREATED','Creat:');
DEFINE('_E_LAST_MOD','Modificat el:');
DEFINE('_E_HITS','Accessos:');
DEFINE('_E_SAVE','Desar');
DEFINE('_E_CANCEL','Cancel·lar');
DEFINE('_E_REGISTERED','Només usuaris registrats');
DEFINE('_E_ITEM_INFO','Informació de l\'article');
DEFINE('_E_ITEM_SAVED','Article desat.');
DEFINE('_ITEM_PREVIOUS','&lt; Anterior');
DEFINE('_ITEM_NEXT','Següent &gt;');
DEFINE('_KEY_NOT_FOUND','Clau no trobada');
/** content.php */
DEFINE('_SECTION_ARCHIVE_EMPTY','Actualment no hi ha articles arxivats a la secció.');	
DEFINE('_CATEGORY_ARCHIVE_EMPTY','Actualment no hi ha articles arxivats a la categoria.');	
DEFINE('_HEADER_SECTION_ARCHIVE','Arxiu de seccions');
DEFINE('_HEADER_CATEGORY_ARCHIVE','Arxiu de categories');
DEFINE('_ARCHIVE_SEARCH_FAILURE','No hi ha articles arxivats per a %s %s');	// values are month then year
DEFINE('_ARCHIVE_SEARCH_SUCCESS','Hi ha articles arxivats per a %s %s');	// values are month then year
DEFINE('_FILTER','Filtre');
DEFINE('_ORDER_DROPDOWN_DA','Fecha a-Z');
DEFINE('_ORDER_DROPDOWN_DD','Fecha Z-a');
DEFINE('_ORDER_DROPDOWN_TA','Título a-Z');
DEFINE('_ORDER_DROPDOWN_TD','Título Z-a');
DEFINE('_ORDER_DROPDOWN_HA','Accesos a-Z');
DEFINE('_ORDER_DROPDOWN_HD','Accesos Z-a');
DEFINE('_ORDER_DROPDOWN_AUA','Autor a-Z');
DEFINE('_ORDER_DROPDOWN_AUD','Autor Z-a');
DEFINE('_ORDER_DROPDOWN_O','Ordenar');

/** poll.php */
DEFINE('_ALERT_ENABLED','Has d\'activar les cookies!');
DEFINE('_ALREADY_VOTE','Avui ja has votat aquesta enquesta avui!');
DEFINE('_NO_SELECTION','No has seleccionat res, intenta-ho de nou.');
DEFINE('_THANKS','Gràcies pel teu vot!');
DEFINE('_SELECT_POLL','Selecciona una enquesta de la següent llista');

/** classes/html/poll.php */
DEFINE('_JAN','Gener');
DEFINE('_FEB','Febrer');
DEFINE('_MAR','Març');
DEFINE('_APR','Abril');
DEFINE('_MAY','Maig');
DEFINE('_JUN','Juny');
DEFINE('_JUL','Juliol');
DEFINE('_AUG','Agost');
DEFINE('_SEP','Setembre');
DEFINE('_OCT','Octubre');
DEFINE('_NOV','Novembre');
DEFINE('_DEC','Desembre');
DEFINE('_POLL_TITLE','Enquesta - Resultats');
DEFINE('_SURVEY_TITLE','Títol de l\'enquesta:');
DEFINE('_NUM_VOTERS','Nombre de vots:');
DEFINE('_FIRST_VOTE','Primer vot:');
DEFINE('_LAST_VOTE','Últim vot:');
DEFINE('_SEL_POLL','Selecciona enquesta:');
DEFINE('_NO_RESULTS','No hi ha resultats per aquesta enquesta.');

/** registration.php */
DEFINE('_ERROR_PASS','Ho sento, la informació de registre no ha estat trobada per aquest usuari');
DEFINE('_NEWPASS_MSG','El compte de l\'usuari $checkusername té aquesta adreça electrònica associada.\n'
.'Un usuari des del lloc web $mosConfig_live_site ha demanat que se li lliuri una nova contrasenya.\n\n'
.' La teva nova contrasenya és: $newpass\n\nSi no las demanat, no et preocupis.'
.' Només tu veus aquest missatge, ningú més. Si això ha estat degut a un error, si us plau, accedeix amb aquesta'
.' nova contrasenya i canvia-la per una altra de la teva elecció.');
DEFINE('_NEWPASS_SUB','$_sitename :: Nova contrasenya per a:: $checkusername');
DEFINE('_NEWPASS_SENT','<span class="componentheading">La nova contrasenya ha estat creada i enviada!</span>');
DEFINE('_REGWARN_NAME','Escriu el teu nom.');
DEFINE('_REGWARN_UNAME','Escriu el teu nom d\'usuari.');
DEFINE('_REGWARN_MAIL','Escriu la teva adreça electrònica.');
DEFINE('_REGWARN_PASS','Escriu una contrasenya vàlida, sense espais en blanc amb més de 6 caràcters i que contingui 0-9,a-z,A-Z');
DEFINE('_REGWARN_VPASS1','Verifica la contrasenya.');
DEFINE('_REGWARN_VPASS2','La contrasenya i la seva verificació no coincideixen, intenta-ho de nou.');
DEFINE('_REGWARN_INUSE','Aquest nom/contrasenya ja està sent usat. Intenta-ho amb un altre combinació.');
DEFINE('_REGWARN_EMAIL_INUSE', 'Aquesta adreça electrònica ja està registrada. Si no reccordes la teva contrasenya fes clic a "Recuperar contrasenya" i se te n\'enviarà una de nova.');
DEFINE('_SEND_SUB','Detalls del compte per a %s a %s');
DEFINE('_USEND_MSG_ACTIVATE', 'Hola %s,

Moltes gràcies per registrar-te a %s. El teu compte ha estat creat, però, abans de poder-la usar has d\'activar-la.
Per activar el teu compte fes clic a l\'enllaç següent o copia i enganxa l\'adreça URL al teu navegador:
%s

Un cop activada ja podràs accedir a %s usant el següent nom d\'usuari i contrasenya:

Usuari         - %s
Contrasenya    - %s');
DEFINE('_USEND_MSG', "Hola %s,

Moltes gràcies per registrar-te a %s.

Ara ja pots accedir a %s usant el nom d\'usuari i contrasenya amb la que t\'has registrat.");
DEFINE('_USEND_MSG_NOPASS','Hola $name,\n\nHas estat afegit com usuari registrat a $mosConfig_live_site.\n'
.'Pots accedir a $mosConfig_live_site amb el nom d\'usuari i contrasenya del registre.\n\n'
.'Si us plau, no responguis a aquest missatge ja que ha estat generat automàticament i únicament és per a la teva informació\n');
DEFINE('_ASEND_MSG','Hola %s,

Un nou usuari s\'ha registrat a %s.
Aquest missatge conté els detalls:

Nom    - %s
c/e    - %s
Usuari - %s

Si us plau, no responguis a aquest missatge ja que ha estat generat automàticament i únicament és per a la teva informació');
DEFINE('_REG_COMPLETE_NOPASS','<div class="componentheading">Registre complet!</div><br />&nbsp;&nbsp;'
.'Ara ja pots accedir.<br />&nbsp;&nbsp;');
DEFINE('_REG_COMPLETE', '<div class="componentheading">Registre complet!</div><br />Ara ja pots accedir.');
DEFINE('_REG_COMPLETE_ACTIVATE', '<div class="componentheading">Registre complet!</div><br />El teu compte ha estat creat, se t\'ha enviat a l\'adreça electrònica del registre un enllaç d\'activació del compte. Nota: Abans de poder usar el teu compte d\'usuari has d\'activar-la prement damunt l\'enllaç que apareix al correu electrònic.');
DEFINE('_REG_ACTIVATE_COMPLETE', '<div class="componentheading">Activació completa!</div><br />El teu compte ha estat activat correctament. Gràcies!. Ara ja pots accedir amb el teu nom d\'usuari i paraula de pas amb la que t\'has registrat.');
DEFINE('_REG_ACTIVATE_NOT_FOUND', '<div class="componentheading">Enllaç d\'activació incorrecte!</div><br />Ho sento, aquest codi d\'activació ja no existeix a la base de dades, segurament ja ha estat activat.');
DEFINE('_REG_ACTIVATE_FAILURE', '<div class="componentheading">L\'activació ha fallat!</div><br />El sistema no pot completar l\'activació. Contacta amb l\'administrador del lloc web, si us plau.');

/** classes/html/registration.php */
DEFINE('_PROMPT_PASSWORD','Recuperar contrasenya?');
DEFINE('_NEW_PASS_DESC','Escriu el teu nom d\'usuari i adreça electrònica amb la que et vas registrar i fes clic damunt el botó Rebre contrasenya.<br>'
.'Tot seguit rebràs una nova contrasenya. Usa-la per accedir a aquest lloc web, després podràs canviar-la per una de la teva elecció.');
DEFINE('_PROMPT_UNAME','Usuari:');
DEFINE('_PROMPT_EMAIL','c/e:');
DEFINE('_BUTTON_SEND_PASS','Rebre contrasenya');
DEFINE('_REGISTER_TITLE','Registrar-te com a usuari');
DEFINE('_REGISTER_NAME','Nom:');
DEFINE('_REGISTER_UNAME','Usuari:');
DEFINE('_REGISTER_EMAIL','c/e:');
DEFINE('_REGISTER_PASS','Contrasenya:');
DEFINE('_REGISTER_VPASS','Verificar contrasenya:');
DEFINE('_REGISTER_REQUIRED','Els camps marcats amb un asterisc (*) són obligatoris.');
DEFINE('_BUTTON_SEND_REG','Enviar registre');
DEFINE('_SENDING_PASSWORD','La contrasenya se t\'enviarà a l\'adreça electrònica del regsitre.<br>Un cop tinguis la'
.' contrasenya podràs accedir i canviar-la.');

/** classes/html/search.php */
DEFINE('_SEARCH_TITLE','Cercar');
DEFINE('_PROMPT_KEYWORD','Text a cercar:');
DEFINE('_SEARCH_MATCHES','%d resultats');
DEFINE('_CONCLUSION','Hi ha $totalRows resultats.  Vols cercar <b>$searchword</b> al');
DEFINE('_NOKEYWORD','La recerca no ha donat cap resultat');
DEFINE('_IGNOREKEYWORD','Una o més paraules massa comuns, han estat ignorades a la recerca');
DEFINE('_SEARCH_ANYWORDS','Qualsevol paraula');
DEFINE('_SEARCH_ALLWORDS','Totes les paraules');
DEFINE('_SEARCH_PHRASE','Frase exacta');
DEFINE('_SEARCH_NEWEST','Nou primer');
DEFINE('_SEARCH_OLDEST','Antic primer');
DEFINE('_SEARCH_POPULAR','Més llegit primer');
DEFINE('_SEARCH_ALPHABETICAL','Alfabèticament');
DEFINE('_SEARCH_CATEGORY','Secció/Categoria');
DEFINE('_SEARCH_MESSAGE','La recerca ha de tenir un mínim de 3 i un màxim de 20 caràcters');
DEFINE('_SEARCH_ARCHIVED','Arxivat');
DEFINE('_SEARCH_CATBLOG','Categoria en bloc');
DEFINE('_SEARCH_CATLIST','Llista de categories');
DEFINE('_SEARCH_NEWSFEEDS','Notícies externes');
DEFINE('_SEARCH_SECLIST','Llista de la secció');
DEFINE('_SEARCH_SECBLOG','Secció en bloc');

/** templates/*.php */
setlocale(LC_ALL, 'es_ES.ISO8859-1');
DEFINE('_ISO','charset=iso-8859-1');
DEFINE('_DATE_FORMAT','l, F de Y');  //Uses PHP's DATE Command Format - Depreciated
/**
* Modify this line to reflect how you want the date to appear in your site
*
*e.g. DEFINE("_DATE_FORMAT_LC","%A, %d %B %Y %H:%M"); //Uses PHP's strftime Command Format
*/
DEFINE('_DATE_FORMAT_LC',"%A, %d %B de %Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d %B de %Y a les %H:%M");
DEFINE('_SEARCH_BOX','cercar...');
DEFINE('_NEWSFLASH_BOX','Destaquem!');
DEFINE('_MAINMENU_BOX','Menú principal');

/** classes/html/usermenu.php */
DEFINE('_UMENU_TITLE','Menú de l\'usuari');
DEFINE('_HI','Hola, ');

/** user.php */
DEFINE('_SAVE_ERR','Omple tots els camps.');
DEFINE('_THANK_SUB','Gràcies per la teva col·laboració. Aquesta serà revisada pels administradors abans no sigui publicada.');
DEFINE('_THANK_SUB_PUB','Gràcies per la teva col·laboració.');
DEFINE('_UP_SIZE','No pots pujar arxius superior a 15kb.');
DEFINE('_UP_EXISTS','Ja hi ha una imatge amb el nom de $userfile_name. Renombra l\'arxiu i torna a pujar la imatge.');
DEFINE('_UP_COPY_FAIL','Error al copiar');
DEFINE('_UP_TYPE_WARN','Només pots pujar arxius d\'imatges gif o jpg.');
DEFINE('_MAIL_SUB','Nou enviament d\'un usuari');
DEFINE('_MAIL_MSG','Hola $adminName,\n\nUn nou $type, $title, ha estat enviat per $author'
.' al lloc web web $mosConfig_live_site.\n'
.'Accedeix a $mosConfig_live_site/administrator per veure i aprovar o esborrar aquest $type.\n\n'
.'Si us plau, no responguis a aquest missatge ja que ha estat generat automàticament i únicament és per a la teva informació.\n');
DEFINE('_PASS_VERR1','Si canvies la contrasenya, escriu-la de nou per a verificar-la.');
DEFINE('_PASS_VERR2','Si canvies la contrasenya, assegura\'t que la contrasenya i la verificació són iguals.');
DEFINE('_UNAME_INUSE','Aquest nom d\'usuari ja s\'està usant.');
DEFINE('_UPDATE','Actualitzar');
DEFINE('_USER_DETAILS_SAVE','Els canvis han estat guardats.');
DEFINE('_USER_LOGIN','Accés d\'usuaris');

/** components/com_user */
DEFINE('_EDIT_TITLE','Editar detalls');
DEFINE('_YOUR_NAME','Nom:');
DEFINE('_EMAIL','c/e:');
DEFINE('_UNAME','Nom d\'usuari:');
DEFINE('_PASS','Contrasenya:');
DEFINE('_VPASS','Verificar contrasenya:');
DEFINE('_SUBMIT_SUCCESS','Enviat!');
DEFINE('_SUBMIT_SUCCESS_DESC','L\'article ha estat enviat als administradors. Un cop revisat serà publicat, si s\'escau.');
DEFINE('_WELCOME','Benvingut/da!');
DEFINE('_WELCOME_DESC','Benvingut/da a la secció d\'usuaris registrats del web');
DEFINE('_CONF_CHECKED_IN','Comprovant els articles');
DEFINE('_CHECK_TABLE','Comprovant la taula');
DEFINE('_CHECKED_IN','Comprovant ');
DEFINE('_CHECKED_IN_ITEMS',' articles');
DEFINE('_PASS_MATCH','Les contrasenyes no són iguals');

/** components/com_banners */
DEFINE('_BNR_CLIENT_NAME','Has de seleccionar el nom del client.');
DEFINE('_BNR_CONTACT','Has de seleccionar el contacte del client.');
DEFINE('_BNR_VALID_EMAIL','Has d\'escriure una adreça vàlida de correu electrònic del client.');
DEFINE('_BNR_CLIENT','Has de seleccionar un client,');
DEFINE('_BNR_NAME','Has d\'escriure un nom pel banner.');
DEFINE('_BNR_IMAGE','Has de seleccionar una imatge pel banner.');
DEFINE('_BNR_URL','Has d\'escriure una URL/codi personalitzat pel banner.');

/** components/com_login */
DEFINE('_ALREADY_LOGIN','Has entrat!');
DEFINE('_LOGOUT','Clic aquí per sortir');
DEFINE('_LOGIN_TEXT','Usa la informació d\'entrada per obtenir accés complet'); 
DEFINE('_LOGIN_SUCCESS','Has entrat correctament');
DEFINE('_LOGOUT_SUCCESS','Has sortit del sistema');
DEFINE('_LOGIN_DESCRIPTION','Per entrar a les àrees privades, valida\'t primer');
DEFINE('_LOGOUT_DESCRIPTION','Actualment ets a l\'àrea privada d\'aquesta web');


/** components/com_weblinks */
DEFINE('_WEBLINKS_TITLE','Enllaços Web');
DEFINE('_WEBLINKS_DESC','Generalment estem navegant. Quant trobem algun lloc interessant'
          .' el llistem aquí per tal de recordar-lo, encara els visitis, esperem que tornis a la nostra web.'
          .' De la llista següent, selecciona el tema que mes t\'interessi i escull el lloc web que vols visitar (<i>S\'obren en una finestra nova</i>).');
DEFINE('_HEADER_TITLE_WEBLINKS','Enllaços web');
DEFINE('_SECTION','Secció:');
DEFINE('_SUBMIT_LINK','Enviar enllaç');
DEFINE('_URL','URL:');
DEFINE('_URL_DESC','Descripció:');
DEFINE('_NAME','Nom:');
DEFINE('_WEBLINK_EXIST','Ja hi ha un enllaç amb aquest mateix nom, intenta-ho de nou amb un altre nom o enllaç.');
DEFINE('_WEBLINK_TITLE','L\'enllaç ha de tenir un títol.');

/** components/com_newfeeds */
DEFINE('_FEED_NAME','Nom');
DEFINE('_FEED_ARTICLES','Nombre d\'articles');
DEFINE('_FEED_LINK','Enllaç');

/** whos_online.php */
DEFINE('_WE_HAVE', 'Hi ha ');
DEFINE('_AND', ' i ');
DEFINE('_GUEST_COUNT','%s convidat');
DEFINE('_GUESTS_COUNT','%s convidats');
DEFINE('_MEMBER_COUNT','%s usuari');
DEFINE('_MEMBERS_COUNT','%s usuaris');
DEFINE('_ONLINE',' en línia');
DEFINE('_NONE','No hi ha usuaris connectats');
/** modules/mod_random_image */
DEFINE('_NO_IMAGES','Sense imatges');
/** modules/mod_banners */
DEFINE('_BANNER_ALT','Avís');

/** modules/mod_stats.php */
DEFINE('_TIME_STAT','Hora');
DEFINE('_MEMBERS_STAT','Usuaris');
DEFINE('_HITS_STAT','Accessos');
DEFINE('_NEWS_STAT','Notícies');
DEFINE('_LINKS_STAT','Enllaços web');
DEFINE('_VISITORS','Visitants');

/** /adminstrator/components/com_menus/admin.menus.html.php */
DEFINE('_MAINMENU_HOME','* El 1r artícle publicat en aquest menú [mainmenu] és la pàgina d\'inici del web *');
DEFINE('_MAINMENU_DEL','* No pots esborrar aquest menú mentre sigui requerit per Joomla! *');
DEFINE('_MENU_GROUP','* Un cert Tipus de menú apareix a més d\'un grup *');


/** administrators/components/com_users */
DEFINE('_NEW_USER_MESSAGE_SUBJECT', 'Detalls del nou usuari' );
DEFINE('_NEW_USER_MESSAGE', 'Hola %s,
Un administrador t\'ha afegit com a usuari registrat de %s.

Aquest missatge conté el nom d´usuari i contrasenya per accedir a %s:

Nom d´usuari   - %s
Contrasenya     - %s

Si us plau, no responguis a aquest missatge ja que ha estat generat automàticament i solament és per a la teva informació');

/** administrators/components/com_massmail */
DEFINE('_MASSMAIL_MESSAGE', "Missatge des de '%s'

Missatge:
" );


/** includes/pdf.php */
DEFINE('_PDF_GENERATED','Generat:');
DEFINE('_PDF_POWERED','Fet amb Mediabase');

/** modificacions de xarxa internet */
DEFINE('_NOIMATGES','No hi ha imatges definides');

/** mediabase */

DEFINE('_MB_NEWFILE','V&iacute;deo novo');
DEFINE('_MB_SEARCH','Buscar');
DEFINE('_MB_SHOWALL','Mostre tudo');
DEFINE('_MB_SHOWING','Mostrando');
DEFINE('_MB_PERPAGE','por a p&aacute;gina');
DEFINE('_MB_OF','de');
DEFINE('_MB_NOCLIPS','Nãháenhum grampo disponíl nesta canaategoria.');
DEFINE('_MB_PAG','P&aacute;g.');
DEFINE('_MB_SUCCESSIMPORT','Clipe importado corretamente.');
DEFINE('_MB_IMPORTFAILED','Fallo en importacion.');
DEFINE('_MB_IMPORTABORTED','Import aborted.');
DEFINE('_MB_UNABLECONFIG','Unable to locate configuration file');
DEFINE('_MB_ERRORCONFIG','Error de configuracio');
DEFINE('_MB_NOFIELD','No puc recollir els camps de'); 
DEFINE('_MB_NOTEXISTFEATURE','no existeix. La caracteristica no es suportada.');
DEFINE('_MB_INVALIDRULE','Regla incorrecta');
DEFINE('_MB_RULEALREADYAPPLIED','regla ja aplicada.');
DEFINE('_MB_FIELD','Field');
DEFINE('_MB_CONFIGERROR','Configuration Error');
DEFINE('_MB_FILEUPLOADFAILED','File upload failed.');
DEFINE('_MB_FILE','File');
DEFINE('_MB_SENDED','enviado corretamente.');
DEFINE('_MB_REMOVEDFILE','Removed file');
DEFINE('_MB_FILENAME','nome de arquivo');
DEFINE('_MB_UPLOAD','carregar');
DEFINE('_MB_REMOVEASK','tirar?');
DEFINE('_MB_SENDNEW','Novo video');
DEFINE('_MB_EDITING','Editando');
DEFINE('_MB_CANCEL','Cancelar');
DEFINE('_MB_CLEAR','Clear');
DEFINE('_MB_DELETE','Deletar');
DEFINE('_MB_INSERT','Inserir');
DEFINE('_MB_SAVECHANGES','Fixar cambios');
DEFINE('_MB_ADDED','O clipe foi adicionado.');
DEFINE('_MB_NOTADDED','Inserir o clipe foi imposs&iacute;vel.');
DEFINE('_MB_CHANGED','O clipe foi modificado.');
DEFINE('_MB_NOTCHANGED','Nãfoi possíl modificar o clclipe');
DEFINE('_MB_REMOVED','Clipe eliminado');
DEFINE('_MB_CHANGEDTO','Clipe enviado a ');
DEFINE('_MB_ACCESSDENIED','Acceso denegado.');

/** TYPE SALES **/ 

// Database Fields

DEFINE('_SALES_DR_FOLDER','Carpeta');
DEFINE('_SALES_SR_ENTITY','*Client');
DEFINE('_SALES_SR_FAMILY','*Familia de productes');
DEFINE('_SALES_PRICE','Preu &euro;');
DEFINE('_SALES_DESCRIPTION','Descripci&oacute');
DEFINE('_SALES_CONTENT_TYPE','Tipus');
DEFINE('_SALES_NOTES','Notes');
DEFINE('_SALES_STATUS','Estat');
DEFINE('_SALES_CREATION_DATE','Data de creaci&oacute');
DEFINE('_SALES_LAST_MODIFIED','Modificat');
DEFINE('_SALES_INITIAL_DATE','Data d\'inici');
DEFINE('_SALES_BILLING_PERIOD','Fact.');
DEFINE('_SALES_PAYMENT_STATUS','Pagament');
DEFINE('_SALES_ATTACHMENT','Adjunt');

// Buttons 

DEFINE('_SALES_BT_NEW','Nova venta');

/** END Type Sales --> sales.php */

/** START Type Tasks --> tasks.php */

// Database Fields

DEFINE('_TASKS_DR_FOLDER','Categoria');
DEFINE('_TASKS_ASSIGNED','Asignat a');
DEFINE('_TASKS_SR_USER','Usuari');
DEFINE('_TASKS_CREATION_DATE','Data de creaci&oacute;');
DEFINE('_TASKS_FINAL_DATE','Finalitzaci&oacute;');
DEFINE('_TASKS_DESCRIPTION','Descripci&oacute;');
DEFINE('_TASKS_SATISFACTION','Satisfacci&oacute;');
DEFINE('_TASKS_ORDER','Ordre');
DEFINE('_TASKS_NOTES','Notes');
DEFINE('_TASKS_RELATED','Relacionat a');
DEFINE('_TASKS_PRIORITY','Prioritat');
DEFINE('_TASKS_STATUS','Estat');

/** Def Buttons */

DEFINE('_TASKS_BT_NEW','Nova tasca');

/** Def Text */

DEFINE('_TASKS_TXT_WAITING','A l\'espera');
DEFINE('_TASKS_TXT_PENDING','Pendent');
DEFINE('_TASKS_TXT_APROVED','Aprovat');
DEFINE('_TASKS_TXT_IN_PROCESS','En proc&eacute;s');
DEFINE('_TASKS_TXT_PAUSED','Aturat');
DEFINE('_TASKS_TXT_REJECTED','Rebutjat');
DEFINE('_TASKS_TXT_FINISHED','Finalitzat');
DEFINE('_TASKS_TXT_WAITING_BUDGET','Pendent pressupost');
DEFINE('_TASKS_TXT_WAITING_APROVED','Pendent aprovaci&oacute');
DEFINE('_TASKS_TXT_WAITING_PAYMENT','Pendent de pagament');
DEFINE('_TASKS_TXT_FINISHED_CURRENT','Finalitzat/al corrent');

/** END Type Tasks --> tasks.php */


/** START Type Files --> files.php */

// Database Fields

DEFINE('_FILES_DR_FOLDER','Carpeta');
DEFINE('_FILES_DESCRIPTION','Descripci&oacute;');
DEFINE('_FILES_NOTES','Notas');
DEFINE('_FILES_STATUS','Estat');
DEFINE('_FILES_NAME','Nom');
DEFINE('_FILES_CREATION_DATE','Data de creaci&oacute;');
DEFINE('_FILES_FILE','Adjunt');

/** Def Buttons */

DEFINE('_FILES_BT_NEW','Nou Document');

/** Def Text */

DEFINE('_FILES_TXT_WAITING','A l\'espera');

/** END Type Files --> files.php */
?>
