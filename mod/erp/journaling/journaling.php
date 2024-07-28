#!/usr/bin/php -q
<?php
# ERP Accounting - Automated Journaling System for Intergrid KMS

# crea automaticament els assentaments comptables : de factures de clients, proveidors, pagaments, nomines, conciliar comptes bancaris, etc.
# aquest script s'executa a diari o quan s'apreta el boto de comptabilitzar
# cada tipus d'objecte es comptabilitza segons la informacio introduida, i si la informacio es incompleta, incorrecte o desconeguda envia un avis per a que sigui revisat.

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/mod/erp/erp_options.php";
include "/usr/local/kms/mod/erp/journaling/functions.php";

// comptabilitzar moviments bancaris (i crear subcomptes si necessari)
assentaments("erp_finance_banks_accounts","nous");

// VENDES : comptabilitzar factures emeses (i crear subcomptes si necessari)
assentaments("erp_invoices","noves");
assentaments("erp_invoices","cobrades");
assentaments("erp_invoices","anulades");
assentaments("erp_invoices","devolucions");
assentaments("erp_invoices","impagades");
assentaments("erp_invoices","retornades");
assentaments("erp_invoices","recuperades");

// COMPRES : comptabilitzar factures rebudes (i crear subcomptes si necessari)
assentaments("erp_invoices_providers","noves");
assentaments("erp_invoices_providers","pagades");
assentaments("erp_invoices_providers","devolucions");

//PRESTECS
//comptabilitzar prestecs socis-empresa (compte corrent efectiu amb socis)
assentaments("erp_finance_banks_transactions","prestecs-societat-a-socis");
assentaments("erp_finance_banks_transactions","prestecs-socis-a-societat");

//CREDITS
// formalitacio de prestec
assentaments("erp_finance_banks_transactions","credit-financer-alta");
assentaments("erp_finance_banks_transactions","credit-financer-quota");

// NOMINES: comptabilitzar nomines (i crear subcomptes si necessari)
assentaments("erp_paysheets","nomina-empleat"); 
//http://www.areadepymes.com/?tit=contabilizacion-de-la-nomina-de-un-trabajador-por-cuenta-ajena-&name=GeTia&contentId=spg_ast034&lastCtg=ctg_19
assentaments("erp_paysheets","nomina-autonoms"); // autonoms en nomina
//http://www.areadepymes.com/?tit=contabilizacion-de-la-nomina-de-un-trabajador-autonomo&name=GeTia&contentId=spg_ast035&lastCtg=ctg_19


// DIVIDENDS
// comptabilitzar dividends
//http://www.areadepymes.com/?tit=contabilizacion-del-reparto-de-dividendos&name=GeTia&contentId=spg_ast062&lastCtg=ctg_18

// TRIBUTS
// liquidacio iva
// impost societats
// irpf 
// http://www.areadepymes.com/?tit=contabilizacion-de-la-liquidacion-de-las-retenciones-por-irpf&name=GeTia&contentId=spg_ast037&lastCtg=ctg_19
// seguretat social o autonoms (mes vencut)
//http://www.areadepymes.com/?tit=contabilizacion-de-la-liquidacion-de-seguros-sociales&name=GeTia&contentId=spg_ast036&lastCtg=ctg_19


// IMMOBILITZAT

// TANCAMENT I OBERTURA D'EXERCICI

?>
