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

/** login */
DEFINE('_CMN_LOGIN_TITLE','Welcome to '.$current_subdomain);

DEFINE('_CMN_LOGTXT','Please enter your username and password:');
DEFINE('_CMN_LOGFAIL','Username or password incorrect');
DEFINE('_CMN_USERNAME','User');
DEFINE('_CMN_PASSWD','Password');
DEFINE('_CMN_LANG','Language');
DEFINE('_CMN_LOGIN','Login');
DEFINE('_CMN_FORGET','I forgot my password');
DEFINE('_CMN_USERDEFAULT','User default');

/** executing **/
DEFINE('_EXEC_MAILINGS','Sending mailing...');


/** common */
DEFINE('_LANGUAGE','ca');
DEFINE('_NOT_AUTH','No tens autorització per accedir a aquest apartat.');
DEFINE('_DO_LOGIN','Necessites accedir primer.');
DEFINE('_VALID_AZ09',"Escriu un %s vàlid, sense espais en blanc amb més de %d caràcters i que contingui 0-9,a-z,A-Z");
DEFINE('_VALID_AZ09_USER',"Escriu un %s válid.  Amb més de %d caràcters i que contingui 0-9,a-z,A-Z");
DEFINE('_CMN_YES','Yes');
DEFINE('_CMN_CAUTIONMULTISELECT','caution: select all the items with CTRL key before saving or you will lost them!');
DEFINE('_CMN_NO','No');
DEFINE('_CMN_SHOW','Show');
DEFINE('_CMN_HIDE','Hide');

DEFINE('_CMN_SUPPORT','Support');
DEFINE('_CMN_LOGIN','Login');
DEFINE('_CMN_LOGOUT','Logout');


DEFINE('_CMN_NAME','Nom');
DEFINE('_CMN_DESCRIPTION','Description');
DEFINE('_CMN_SAVE','Save');
DEFINE('_CMN_APPLY','Apply');
DEFINE('_CMN_CANCEL','Go back');
DEFINE('_CMN_PRINT','Print');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','a/e');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Pare');

/** globals */

DEFINE('_MB_START','Start');
DEFINE('_MB_NEWFOLDER','New folder');
DEFINE('_MB_DRFOLDER','Folder');
DEFINE('_MB_SHORTCUTTO','Internal link (id)');
DEFINE('_MB_EXTERNALURL','External link (url)');
DEFINE('_MB_DESCRIPTION','Description');
DEFINE('_MB_NOTES','Notes');
DEFINE('_MB_OWNER','Owner');
DEFINE('_MB_GROUP','Group');
DEFINE('_MB_PERMISIONS','Permisions');
DEFINE('_MB_CREATIONDATE','Creation date');
DEFINE('_MB_CONTENT','Contents');
DEFINE('_MB_NEWFILE','New');
DEFINE('_MB_SEARCH','Search');
DEFINE('_MB_SHOWALL','show all');
DEFINE('_MB_SHOWING','Showing');
DEFINE('_MB_PERPAGE','per page');
DEFINE('_MB_OF','de');
DEFINE('_MB_NOCLIPS','There are no objects here');
DEFINE('_MB_PAG','Page');
DEFINE('_MB_SUCCESSIMPORT','Successfully imported file.');
DEFINE('_MB_IMPORT','Import');
DEFINE('_MB_EXPORT','Export');
DEFINE('_MB_IMPORTFAILED','Import failed.');
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
DEFINE('_MB_SENDED','sended successfully.');
DEFINE('_MB_SENDTOTRASH','Send to trash');
DEFINE('_MB_REMOVEDFILE','deleted successfully');
DEFINE('_MB_FILENAME','filename');
DEFINE('_MB_UPLOAD','upload');
DEFINE('_MB_REMOVEASK','delete?');
DEFINE('_MB_SENDNEW','Insert');
DEFINE('_MB_EDITING','Editing');
DEFINE('_MB_CANCEL','Go back');
DEFINE('_MB_CLEAR','Clear');
DEFINE('_MB_DELETE','Delete');
DEFINE('_MB_INSERT','Insert');
DEFINE('_MB_SAVECHANGES','Save changes');
DEFINE('_MB_ADDED','object added sucessfully.');
DEFINE('_MB_NOTADDED','Can\'t insert object.');
DEFINE('_MB_CHANGED','Object modified sucessfully.');
DEFINE('_MB_NOTCHANGED','No ha estat possible canviar la tasca.');
DEFINE('_MB_REMOVED','Object deleted sucessfully');
DEFINE('_MB_CHANGEDTO','Object changed to ');
DEFINE('_MB_ACCESSDENIED','Access denied.');
DEFINE('_GLOBAL_SEARCHING','Searching for matching query');
DEFINE('_MB_NOOBJECTS','No objects.');
DEFINE('_MB_FULLNAME','Full name');
DEFINE('_MB_EMAIL','Email');
DEFINE('_MB_ORGANIZATION','Organization');
DEFINE('_MB_COMPANY','Company');
DEFINE('_MB_ADDRESS','Address');
DEFINE('_MB_LOCATION','Location');
DEFINE('_MB_COUNTRY','Country');
DEFINE('_MB_COMMENTS','Comments');
DEFINE('_MB_GROUPS','Groups');
DEFINE('_MB_PHONE','Phone');
DEFINE('_MB_FOLDER','Folder');
DEFINE('_MB_GROUPNAME','Group name');
DEFINE('_MB_TAGS','Tags');

DEFINE('_MOD_FROM','From');
DEFINE('_MOD_TO','To');
DEFINE('_MB_GROUP','Group');
DEFINE('_MOD_SUBJECT','Subject');
DEFINE('_MOD_BODY','Body');
DEFINE('_MOD_TOTALUSERS','Total users');
DEFINE('_MOD_IMPACTS','Clicks');
DEFINE('_MOD_TAGS','Tags');
DEFINE('_MOD_BODYMAILING','Body url');
DEFINE('_MOD_CREATIONDATE','Creation date');
DEFINE('_MOD_STATUS','Status');
DEFINE('_MOD_PENDING','Pending');
DEFINE('_MOD_SENDING','Sending...');
DEFINE('_MOD_FINISHED','Finished');


DEFINE('TY_ALERTS','Alerts');
DEFINE('TY_ARTICLES','Alticles');
DEFINE('TY_BILLING','Invoices');
DEFINE('TY_CATALOG','Catalog');
DEFINE('TY_CLIENTS','Clients');
DEFINE('TY_CONTACTS','Contacts');
DEFINE('TY_CONTRACTS','Contracts');
DEFINE('TY_DOCUMENTS','Documents');
DEFINE('TY_ENTITIES','Entities');
DEFINE('TY_EVENTS','Calendar');
DEFINE('TY_FILES','Files');
DEFINE('TY_FOLDERS','Folders');
DEFINE('TY_MAILINGS','Mailings');
DEFINE('TY_MAILINGGROUPS','Mailing groups');
DEFINE('TY_MATERIALS','Materials');
DEFINE('TY_MENUS','Menus');
DEFINE('TY_MESSAGES','Messages');
DEFINE('TY_NOTES','Notes');
DEFINE('TY_TASKS','Tasks');
DEFINE('TY_PICTURES','Photos');
DEFINE('TY_PRODUCTS','Products');
DEFINE('TY_PROJECTS','Projects');
DEFINE('TY_PEOPLE','Contacts');
DEFINE('TY_SALES','Sales');
DEFINE('TY_SERVICES','Services');
DEFINE('TY_SOFTWARE','Software');
DEFINE('TY_SURVEYS','Surveys');
DEFINE('TY_VIDEOS','Videos');
DEFINE('TY_WEBSITES','Websites');
DEFINE('TY_TEMPLATES','Templates');
DEFINE('TY_SHOPPINGCART','Shopping cart');
DEFINE('TY_MAILING','Mailings');
DEFINE('TY_MAILING_BODIES','Mailing bodies');

// Camps per tipus

DEFINE('_FOLDER_DESCRIPTION','Description');
DEFINE('_FOLDER_OWNER','Owner');
DEFINE('_FOLDER_PERMISIONS','Permisions');
DEFINE('_FOLDER_SHORTCUTTO','Shortcut to');
DEFINE('_FOLDER_EXTERNALURL','External URL');
DEFINE('_FOLDER_ID','Folder ID');
DEFINE('_FOLDER_NOTES','Notes');
DEFINE('_FOLDER_GROUP','Group');
DEFINE('_FOLDER_CONTENTS','Contents');

// Estats

DEFINE('_MOD_PENDING','Pending');
DEFINE('_MOD_SENDING','Sending...');
DEFINE('_MOD_FINISHED','Finished');

// Botons nou objecte

DEFINE('_NEW_FOLDER','New folder');
DEFINE('_NEW_MAILING','New mailing');
DEFINE('_NEW_CONTACT','New contact');
DEFINE('_NEW_GROUP','New group');

?>
