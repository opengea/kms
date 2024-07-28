<?php
/*
 * required params:
 *
 * values (array) - array of options
 */
class tags {

    function tags($field,$params,&$dm) {
        $this->field = $field;
        $this->values = $params;
        $this->dm =& $dm;
//echo "-->:".$this->values;
    }

    function output_filter($data) {
//echo "data:".$data;
return $data;
/*        $_arr = explode($this->dm->delimiter,$data);
        $tmp = array();
        foreach ($_arr as $key=>$value) {
            $tmp[] = $this->values[$value];
        }
        return @join(",",$tmp);
*/
    }

    function input_filter($data) {
        //$_arr = @array_values($data);
        return $data;//@join($this->dm->delimiter,$_arr);
    }

    function input_display($value) {
	$out="	
	<script>
		var availableTags = [
			\"ActionScript\",
			\"AppleScript\",
			\"Asp\",
			\"BASIC\",
			\"C\",
			\"C++\",
			\"Clojure\",
			\"COBOL\",
			\"ColdFusion\",
			\"Erlang\",
			\"Fortran\",
			\"Groovy\",
			\"Haskell\",
			\"Java\",
			\"JavaScript\",
			\"Lisp\",
			\"Perl\",
			\"PHP\",
			\"Python\",
			\"Ruby\",
			\"Scala\",
			\"Scheme\"
		];
	</script>";
	$out.="\n<input id=\"{$this->field}_{$i}\" class=\"tags\" type=\"text\" name=\"{$this->field}\" value=\"{$value}\"> ";
	// print "\n<script>$('.tags').tagsInput({autocomplete:{source:availableTags,selectFirst:true,width:'600px',autoFill:true}});</script>";
	$out.=" <script>$('.tags').tagsInput({    
  autocomplete_url:'/kms/lib/tags/get_tags.php?mod=".$_GET['mod']."',
  autocomplete:{selectFirst:true,width:'600px',autoFill:true}
});
	</script>";
	return $out;
	}

}
?>
