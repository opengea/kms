<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<? session_start()?>
<head>
<link rel="stylesheet" type="text/css" href="https://control.intergridnetwork.net/kms/mod/erp/reports/report2.css" title="css">
<style type="text/css">
@font-face {
    font-family: 'Arial';
    src: url(http://cp.intergridnetwork.net/kms/css/typo/arial.ttf);
}
body {
	margin: 0px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
}
#invoice {
	width: 775px;
	float: left;
	clear: both;
	padding-left: 5px;
	padding-right: 20px;
	margin-left:10px;
	background-color: white;
	position:absolute;
	left:0px;
	/*top:45px;*/
	z-index:-1;
}

#header {
	margin-top: 25px;
	margin-bottom: 10px;
}

#header_right {
	text-align: right;
	font-size: 25px;
	font-style: bold;
	vertical-align: top;
}

.detail_columns {
	text-align: center;
	vertical-align: top;
}

#rpt_header {
	padding-top: 25px;
	padding-bottom: 5px;
    	height: 200px;
}

#rpt_content {
	margin-top:25px;
	height: 585px;
	min-height:585px;
}

#rpt_additionals {
	border-top-width: thin;
	border-top-style: solid;
	border-top-color: #ccc;
    	height: 100px;
}

#rpt_totals {
/*        border-top-width: thin;*/
/*        border-top-style: solid;*/
        border-top-color: #ccc;
}


#rpt_info {
}
table.rptTable {
	vertical-align:top;
	page-break-before: always;
	text-align: left;
	padding-left: 5px;
}

table.rptTable td.header {
	height: 20px;
	line-height: 20px;
	padding-left: 3px;
	background-color: #EEE;
}

#header #header2 tr td span {
	color: #333;
}
#header #header2 tr td {
	color: #666;
}


#rpt_footer {
	border:0px;
	text-align: center;
}
#rpt_footer #footer {
	font-size: 9px;
	padding-top:10px;
	line-height:20px;
	text-align: center;
}
#invoice #rpt_totals #totals {
border:0px;
}
#invoice #rpt_totals #totals .tr .detail_columns {
	background-color: #eee;
	text-align: center;
	height: 35px;
	width: 100px;
	font-weight: bold;
}
#rpt_controller {
	width: 100%;
	height: 200px;

	background-color: #cfe9fe;
	padding-top:0px;
	position:absolute;
	left:0px;
	top:-200px;
	z-index:1;
}

#rpt_controller #rpt_controller_form {
        padding-left:5px;
}

#rpt_controller #rpt_controller_buttons {
	background-color:#fff;
        padding-top:0px;
	padding-left:10px;
	border-bottom: 1px solid #ccc;
}

table.rpt_form_table {
	padding-left:10px;
	width:100%;
	margin:10px;
}

table.rpt_form_table tr {
	margin:0px;
}

table.rpt_form_table td {
	font-family: Arial, Helvetica, sans-serif;
        color: #444;
        font-weight: normal;
        font-size: 12px;
	line-height:20px;
	vertical-align: top;
}
-->

</style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Report</title>
</head>
