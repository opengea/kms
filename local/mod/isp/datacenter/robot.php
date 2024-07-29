<?
require 'RobotClientException.class.php';
require 'RobotRestClient.class.php';
require 'RobotClient.class.php';

$robot = new RobotClient('https://robot-ws.your-server.de', 'intergrid', 'mamut4ever');
//print_r($robot);

$ip='5.9.136.169';//88.198.145.211';
// ---------- get server (status) ----------
/*
$error="";
try { $result = $robot->serverGet($ip); 
    } catch (RobotClientException $e) { $error="ERROR: ".$e->getMessage(); }
if ($error!="") { echo $error."\n"; } else {  echo $result->server->status; }
*/

// ---------- get trafic ------------
// cutre perque no em dona per dia, nomes el total del mes
//hauria de fer query diaria, i despres fer els rdd de trafic.
/*$error="";
try { $result = $robot->trafficGetForIp($ip,"month",date('Y-m-01',strtotime('-1 month')),date('Y-m-31',strtotime('-1 month')));
    } catch (RobotClientException $e) { $error="ERROR: ".$e->getMessage(); }
if ($error!="")  { echo $error."\n"; } 
           else  {  
		   echo  "IN:".$result->traffic->data->$ip->in." GB\n"; 
		   echo "OUT:".$result->traffic->data->$ip->out." GB\n";
}*/

// --------- execute reset --------------
$error="";
$ip="";
$type="hw"; // "sw", "man";
try { $result = $robot->resetExecute($ip,$type);
    } catch (RobotClientException $e) { $error="ERROR: ".$e->getMessage(); }
if ($error!="")  { echo $error."\n"; } 
           else  {  
                   echo  "IN:".$result->traffic->data->$ip->in." GB\n"; 
                   echo "OUT:".$result->traffic->data->$ip->out." GB\n";
}



// retrieve all failover ips

//trafficGetForIp($ip, $type, $from, $to)
/*
$results = $robot->failoverGet();

foreach ($results as $result)
{
  echo $result->failover->ip . "\n";
  echo $result->failover->server_ip . "\n";
  echo $result->failover->active_server_ip . "\n";
}

// retrieve a specific failover ip
$result = $robot->failoverGet('123.123.123.123');

echo $result->failover->ip . "\n";
echo $result->failover->server_ip . "\n";
echo $result->failover->active_server_ip . "\n";

// switch routing
try
{
  $robot->failoverRoute('123.123.123.123', '213.133.104.190');
}
catch (RobotClientException $e)
{
  echo $e->getMessage() . "\n";
}
*/?>
