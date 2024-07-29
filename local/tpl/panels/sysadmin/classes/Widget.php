<?php


class Widget
{

    protected $status;
    protected $ip;
    protected $so_info;
    protected $hostname;
    protected $description;
    protected $long_description;
    protected $services;
    protected $services_check_names;
    protected $memory;
    protected $disk_info;

    const PROGRESS_BAR_WARNING_PERCENT = 65;
    const PROGRESS_BAR_DANGER_PERCENT = 85;

    public function __construct($server)
    {

        $this->status = $server['status'];
        $this->ip = $server['ip'];
        $this->so_info = $server['so_info'];
        $this->hostname = $server['hostname'];
        $this->description = $server['description'];
        $this->long_description = $server['long_description'];
        $this->services = $server['services'];
        $this->services_check_names = $server['services_check_names'];
        $this->memory = $server['memory'];
        $this->disk_info = $server['disk'];

    }

    public function render()
    {

        if ($this->status == 'disabled') {

            $msg = "Server not configured to show on dashboard";

            $widget = "
        <div class=\"flex flex-shrink w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2 widget-min-width\">
    <div class=\"w-full bg-red-200 rounded p-4 shadow\">
        <div class=\"flex\">
            <div class=\"w-2/3\">
                <h1 class=\"font-semibold\">
                    " . $this->hostname . "
                </h1>
            </div>   
        </div>
        <div class=\"py-2 text-sm\">
           " . $msg . "
        </div>
</div>
</div>
        ";

        } else {

            $widget = "
        <div class=\"flex flex-shrink w-full md:w-1/2 lg:w-1/3 xl:w-1/5 p-2 widget-min-width\">
    <div class=\"w-full bg-white rounded p-4 shadow\">
        <div class=\"flex\">
            <div class=\"w-2/3\">
                <h1 class=\"font-semibold\">
                    " . $this->hostname . "
                </h1>
                <span class=\"block text-xs uppercase text-blue-400\">" . $this->ip . "</span>
            </div>
            <div class=\"w-1/3\">
                <span class=\"float-right text-xs bg-blue-400 rounded px-2 py-1 text-white\">" . $this->status . "</span>
            </div>
        </div>
        <div class=\"py-2 text-sm\">
        <span class=\"block text-xs uppercase text-blue-900-400\">" . $this->so_info['so'] . "</span>
            " . $this->description . "
        </div>
        <div class=\"flex flex-wrap\">
        " . $this->render_services($this->services, $this->services_check_names) . "
        </div>
        <div>
</div>
        " . $this->render_progress_bar("Memory", $this->memory['memTotal'], $this->memory['memTotal'] - ($this->memory['memFree'] + $this->memory['buffers'] + $this->memory['cached']), true) . "
        " . $this->render_progress_bar("Disk", $this->disk_info['size'], $this->disk_info['used'], true) . "
    </div>
</div>
        ";

        }

        return $widget;

    }

    public function render_services($services, $services_check_names)
    {
        $output = '';
        $services_check_names = explode(',', strtolower($services_check_names));

        foreach ($services as $service) {
            if (in_array(strtolower($service['service']), $services_check_names)) {
                $color = ($service['status'] == 'running') ? 'green' : 'red';

                $output .= "<div class='w-1/5 text-center py-1'>";
                $output .= "<div class='bg-{$color}-300 mx-1'>{$service['service']}</div> ";
                $output .= "</div>";
            }

        }
        return $output;

    }

    public function render_progress_bar($label, $total, $used, $show_total = false)
    {
        $percent = $this->calculate_percent($total, $used);

        if ($percent > self::PROGRESS_BAR_WARNING_PERCENT && $percent < self::PROGRESS_BAR_DANGER_PERCENT) {
            $color = "orange";
        } elseif ($percent >= self::PROGRESS_BAR_DANGER_PERCENT) {
            $color = "red";
        } else {
            $color = "green";
        }

        $output_size = ($show_total) ? $this->formatBytes($used) . " of " . $this->formatBytes($total) : '';

        $output = "
       <div class='flex'>
            <span class='text-xs font-semibold py-1'>" . $label . "</span>
            <span class='text-xs font-semibold py-1 ml-auto text-blue-600'>" . $output_size . " (" . $percent . "%)" . "</span>
        </div>
       <div class='w-full bg-" . $color . "-100 py-1'>
            <div class='bg-" . $color . "-400 leading-none py-1 text-center text-white' style='width: " . $percent . "%'></div>
       </div>
        ";
        return $output;
    }


    public function calculate_percent($total, $fraction)
    {
        return intval($fraction * 100 / $total);
    }

    function formatBytes($bytes)
    {
        $si_prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');
        $base = 1024;
        $class = min((int)log($bytes, $base), count($si_prefix) - 1);
        return sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $si_prefix[$class];
    }
}