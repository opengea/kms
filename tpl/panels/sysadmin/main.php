<?php

require "classes/Widget.php";
require "classes/ApiData.php";
require "classes/KMSData.php";
require "vendor/autoload.php";

$api_data = new ApiData();
ob_start();

?>
<script src="/kms/mod/isp/dashboard/js/load_css.js"></script>
<script src="/kms/mod/isp/dashboard/js/vue.min.js"></script>
<script src="/kms/mod/isp/dashboard/js/dashboard.js"></script>
<?

$kmsLink = new KMSData($this->dblinks['client']);
$serversGroups = $kmsLink->getServersGroups();
$serversButtons = $kmsLink->getServersButtons($serversGroups);
$activeServersGroups = $kmsLink->showOnLoadServers($serversGroups);

echo '
<div id="app">
<div id="info-txt"></div>
<div id="server-select-btns">
    <serverButtons></serverButtons>
    <server-btn
    v-for="server in serverList"
    v-bind
    >
</server-btn>
</div>
</div>


';

echo "<div id=\"info-txt\"></div>";
echo "<div id=\"server-select-btns\">";
foreach ($serversButtons as $group => $data) {
    $class = "bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn";
    $class .= ($data['show_on_load']) ? " bg-blue-200" : " hover:bg-green-200";
    $class .= ($data['show_on_load']) ? ' active' : '';
    echo "<button data-id=\"{$data['id']}\" class=\"{$class}\">" . $group . "</button>";
}
echo "</div>";

echo "<div class='inline-block'>";
foreach ($activeServersGroups as $group => $data) {
    echo "<div id='server-group-{$data['id']}' class='bg-white rounded p-2 shadow'>";
    echo "<div class='bg-server-group-color p-4 font-bold'>";
    echo $group;
    echo "</div>";
    echo "<div class='flex flex-wrap bg-gray-100'>";
    foreach ($data['servers'] as $server) {
        $server = new Widget($kmsLink->getServerData($server));
        echo $server->render();
    }
    echo "</div>";
    echo "</div>";
}
echo "</div>";

$content_html = ob_get_clean();
$panel = array(
    "title" => _KMS_SERVICES_CP,
    "buttons" => "",
    "content" => $content_html,
    "defaultMod" => "",
    "infotable" => "",
    "hide_databrowser" => true
);
$this->setPanel($panel);
?>
