<?

$s="fdjkjfsdkfjsdklfjsdkl<video>aa</video>fsdlfksdlfsld<video>b</video>XX";
echo $s."\n\n";
function media($s) {
        $template="<video width=\"320\" height=\"240\" controls>
  <source src=\"file.mp4\" type=\"video/mp4\">
  <source src=\"file.ogg\" type=\"video/ogg\">
Your browser does not support the video tag.
</video>";
        $last=0;$s_="";
        while ($pos=strpos($s,"<video>")) {
                $s_.=substr($s,$last,$pos-$last); //pre string before <video>
		$pos_end=strpos(substr($s,$pos),"</video>");  //position relative
		$video_id=substr(substr($s,$pos),7,$pos_end-7);

		$video=str_replace("file",$video_id,$template);
                $s_.=$video;

		$last=$pos+$pos_end+8;
		$s=substr($s,$last);	
		$last=0;
        }
	$s_.=$s;
	return $s_;
}

echo media($s);
