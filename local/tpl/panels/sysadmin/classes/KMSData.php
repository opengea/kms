<?php


class KMSData
{

    protected $apiData;
    protected $dblink;

    public function __construct($dblink)
    {
        require_once "ApiData.php";
        $this->dblink = $dblink;
        $this->apiData = new ApiData();
    }

    public function getServersGroups()
    {
        $qry_string = "select value from kms_sys_conf where name='servers_groups'";
        $qry = mysqli_query($this->dblink, $qry_string);
        if (!$qry) die('error db ' . mysqli_error($qry));
        $result = mysqli_fetch_assoc($qry);
        return json_decode($result['value'], true);
    }

    public function getServersButtons($serversGroups){
        foreach ($serversGroups as $serverGroup => $key) {
            if(!$key['active']) {
                unset($serversGroups[$serverGroup]);
            }
        }
        return $serversGroups;
    }

    public function showOnLoadServers($serversGroups){
        foreach ($serversGroups as $serverGroup => $key) {
            if(!$key['show_on_load']) {
                unset($serversGroups[$serverGroup]);
            }
        }
        return $serversGroups;
    }

    public function getServerData($server)
    {
        $qry = "SELECT * from kms_isp_servers where show_on_dashboard = 'Y' and hostname = '" . $server . "' limit 1";
        $result = mysqli_query($this->dblink,$qry);
        if (!$result) die('error db ' . mysqli_error($result));
        $result = mysqli_fetch_assoc($result);

        $serverRst = array();
        $serverRst['status'] = ($result['status']) ? ucfirst($result['status']) : 'disabled';
        $serverRst['ip'] = $result['ip'];
        $serverRst['so_info'] = ($result['hostname']) ? $this->apiData->getSOInfo($result['hostname']) : '';
        $serverRst['hostname'] = (strtoupper($result['hostname']) != '') ? strtoupper($result['hostname']) : strtoupper($server);
        $serverRst['description'] = $result['description'];
        $serverRst['memory'] = ($result['hostname']) ? $this->apiData->getMemoryInfo($result['hostname']) : '';
        $serverRst['disk'] = ($result['hostname']) ? $this->apiData->getDiskInfo($result['hostname'], $result['space_check_mount_point']) : '';
        $serverRst['services'] = ($result['hostname']) ? $this->apiData->getServices($result['hostname']) : '';
        $serverRst['services_check_names'] = $result['services_check_names'];

        return $serverRst;
    }
}
