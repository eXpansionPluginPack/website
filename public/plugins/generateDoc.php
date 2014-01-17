<?php

$dir = '_data/eXpansion';
$dirs = scandir($dir);

foreach ($dirs as $file) {
	if (strpos($file, '.ini') !== FALSE) {
		
		$ini = parse_ini_file($dir.'//'.$file, true);
		
		$plugin = 'ManiaLivePlugins\\eXpansion\\'.str_replace(".ini","", $file)."\\";
		
		$confs = array();
		foreach($ini['types'] as $confName => $type){
			$confs[$confName] = new configuration();
			$confs[$confName]->varName = $plugin.$confName;
			
			$type = explode(',', $type);
			$confs[$confName]->type = $type[0] . (isset($type[1]) ? '('.$type[1].')' : '');
		}
		
		foreach($ini['default'] as $confName => $default){
			
			if(is_array($default)){
				foreach($default as $val){
					$confs[$confName]->defaultConf .= $plugin.$confName.'[] = '.$val."\n";
				}			
			}else{
				$confs[$confName]->defaultConf .= $plugin.$confName.'[] = '.$default."\n";
			}
		}
		
		if(isset($ini['name'])){
			foreach($ini['name']as $confName => $name){
				$confs[$confName]->name = $name; 
			}
		}
		
		if(isset($ini['description'])){
			foreach($ini['description']as $confName => $description){
				$confs[$confName]->description = $description; 
			}
		}
		
		if(isset($ini['defConfDescription'])){
			foreach($ini['defConfDescription']as $confName => $default_description){
				$confs[$confName]->defConfDesc = $default_description; 
			}
		}
		
		if(isset($ini['more'])){
			foreach($ini['more']as $confName => $default_description){
				$confs[$confName]->defConfDesc = $default_description; 
			}
		}
		print_r($confs);
		
		$content = file_get_contents ('../info/'.str_replace('.ini', '.txt', $file));
		$content = explode('[h1]Configuration options[/h1]', $content);
		
		$newContent = $content[0];
		$newContent .= '[h1]Configuration options[/h1]'."\n";
		
		foreach($confs as $confName => $conf){
			
			$newContent .= '[h2]'.(empty($conf->name) ? $confName : $conf->name) .'[/h2]'."\n";
			$newContent .= $conf->description."\n"."\n";
			
			$newContent .= '[b]Var Name : [/b]'.$confName.' ('.$conf->type.')'."\n";
			
			$newContent .= '[h3]Default Configuration[/h3]'."\n";
			$newContent .= '[code]'.$conf->defaultConf.'[/code]'."\n"."\n";
			$newContent .= $conf->defConfDesc."\n";
			$newContent .= $conf->more."\n";
			
		}
		
		file_put_contents('../info/'.str_replace('.ini', '.txt', $file), $newContent);
	}
}

class configuration{
	
	public $name;
	public $varName;
	public $type;
	
	public $description = "";
	public $more = "";
	
	public $defaultConf = "";
	public $defConfDesc = "";
}