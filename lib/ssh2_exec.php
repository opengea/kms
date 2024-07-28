<?
   function ssh_exec($host,$command,$key) {
        // security check
        if ($key=="JADF7320cSJdcj3750492x42dj244") {
                 $callbacks = array('disconnect' => 'ssh_exec_disconnect');
                  $conn = ssh2_connect($host, 22);
        if (!$conn) die('Connection failed');
                if (!ssh2_auth_password($conn, 'root', 'KovuvBavedCoids')) echo "[ssh2_exec] : Login failed trying to connect to '$host' host\n";
                if (!($stream = ssh2_exec($conn, $command )) ) {
                        die("[ssh_exec] : fail: unable to execute command\n");
                }  else {
                        // collect returning data from command
                        $blocking=stream_set_blocking( $stream, true );
                        if (!$blocking) echo "ops, can't set stream to blocking mode\n";
                        $data = "";
                        while ($buf = fread($stream,4096)) $data .= $buf;
                        fclose($stream);
                        return $data;
                }
        }
        die("[ssh_exec] : Unauthorized access. Invalid authkey.");
        return false;

   }

?>
