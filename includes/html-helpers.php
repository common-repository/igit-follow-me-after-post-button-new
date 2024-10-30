<?php
function igit_network_input_select($name, $hint,$db_value) {
	global $igit_plug_opts,$plgin_dir,$twt_img_data;
	$imgpath = $plgin_dir.$twt_img_data[$name]['baseUrl'];
	if($db_value == $name)
	{
		$checkedtwt = 'checked="checked" ';
	}
	return sprintf('<div style="float:left;border:1px solid #EEE;margin:5px;background:#FFF;padding:5px 8px 5px 8px;"><label class="%s" title="%s"><div align="center" style="padding:2px;background-color:#EEE;"><input %sname="twt_image[]" type="radio" value="%s"  id="%s" /></div><div align="center"><img src="%s" align="absmiddle" border="0" /></div></label></div>',
		$name,
		$hint,
		$checkedtwt,
		$name,
		$name,
		$imgpath
	);
}
?>