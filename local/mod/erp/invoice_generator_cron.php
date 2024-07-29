#!/usr/bin/php -q
<? /* #!/usr/bin/php -q */ ?>
<?
 date_default_timezone_set('Europe/Brussels');
// aquest script s'executa i genera factures un dia al mes.
// segons la data genera factures a partir de contractes
echo "Generació de factures:\n";
// genera factures de tasques
include ('invoice_generator_tasks.php');
// genera factures de contractes que vencen
include ('invoice_generator_contracts.php');
// genera factures de servei de kms mailing
include ('invoice_generator_mailings.php');
// genera factures de consum extra (espai, transferencia..)
//include ('invoice_generator_extra.php');


// genera factures de contractes nous
//include ('invoice_generator_contracts_inserts.php');

?>
