<?php
//BASIC
$cost_espai_add_1=0.43;
$cost_transferencia_add_1=0.01;
$cost_mailboxes_add_1=0.07;
$cost_vhosts_add_1=1.5;
//STANDARD
$cost_espai_add_2=0.25;
$cost_transferencia_add_2=0.01;
$cost_mailboxes_add_2=0.05;
$cost_vhosts_add_2=1.0;
//PRO
$cost_espai_add_3=0.25;
$cost_transferencia_add_3=0.01;
$cost_mailboxes_add_3=0.05;
$cost_vhosts_add_3=1.0;
//BUSINESS
$cost_espai_add_4=0.43;
$cost_transferencia_add_4=0.01;
$cost_mailboxes_add_4=0.06;
$cost_vhosts_add_4=1.0;
//ENTERPRISE
$cost_espai_add_5=0.40;
$cost_transferencia_add_5=0.01;
$cost_mailboxes_add_5=0.05;
$cost_vhosts_add_5=1.0;

$pla=array();
$pla['start']=array();
$pla['start']['space']   =array('min'=>1,'max'=>10,  'step'=>1,'value'=>5);
$pla['start']['transfer']=array('min'=>0,'max'=>500,'step'=>1,'value'=>100);
$pla['start']['emails']  =array('min'=>0,'max'=>20, 'step'=>1,'value'=>10);
$pla['start']['domains'] =array('min'=>1,'max'=>5,  'step'=>1,'value'=>1);
$pla['standard']=array();
$pla['standard']['space']   =array('min'=>5, 'max'=>20, 'step'=>1,'value'=>10);
$pla['standard']['transfer']=array('min'=>100,'max'=>1000,'step'=>1,'value'=>500);
$pla['standard']['emails']  =array('min'=>10, 'max'=>100, 'step'=>1,'value'=>50);
$pla['standard']['domains'] =array('min'=>1, 'max'=>10, 'step'=>1,'value'=>1);
$pla['pro']=array();
$pla['pro']['space']   =array('min'=>20, 'max'=>40, 'step'=>1,'value'=>20);
$pla['pro']['transfer']=array('min'=>200,'max'=>1600,'step'=>1,'value'=>800);
$pla['pro']['emails']  =array('min'=>50, 'max'=>150,'step'=>1,'value'=>75);
$pla['pro']['domains'] =array('min'=>1,  'max'=>20, 'step'=>1,'value'=>1);
$pla['business']=array();
$pla['business']['space']   =array('min'=>40,'max'=>100, 'step'=>1,'value'=>50);
$pla['business']['transfer']=array('min'=>300,'max'=>2000,'step'=>1,'value'=>1000);
$pla['business']['emails']  =array('min'=>0, 'max'=>200,'step'=>1,'value'=>100);
$pla['business']['domains'] =array('min'=>1, 'max'=>30, 'step'=>1,'value'=>1);
$pla['preserver']=array();
$pla['preserver']['space']   =array('min'=>50, 'max'=>200, 'step'=>1,'value'=>100);
$pla['preserver']['transfer']=array('min'=>500,'max'=>3000,'step'=>1,'value'=>1500);
$pla['preserver']['emails']  =array('min'=>0,  'max'=>300, 'step'=>1,'value'=>150);
$pla['preserver']['domains'] =array('min'=>1,  'max'=>50,  'step'=>1,'value'=>1);


?>
