<h1>Finalized Config - Step 3</h1>
<p>Copy and paste the following configurations to your manialive config.ini </p>
<br/>
<?php
$bufferPlugins = "";
$bufferSettings = "";
foreach ($_POST as $key => $value) {
    if ($key == "plugins") {
        $plugins = json_decode($_POST['plugins']);
        foreach ($plugins as $plugin) {
           $plugin = str_replace("eXpansion\\", "", $plugin);
            $bufferPlugins .= "manialive.plugins[] = 'eXpansion\\" . $plugin . "'\n";
        }
    }
    if ($key == "disabledAutoLoad") {
        $autoload = json_decode($_POST['disabledAutoLoad']);        
        foreach ($autoload as $item) {
            $bufferSettings .= "ManiaLivePlugins\\eXpansion\\AutoLoad\\Config.disable[] = \"eXpansion\\" . $item . "\";";
        } 
    }
    if (strstr($key, "#")) {
        list ($plugin, $item) = explode("#", $key);
        $plugin = str_replace("eXpansion", "", $plugin);
        $plugin = str_replace(array("\\", "/"), "", $plugin);
        $ini = parse_ini_file(__DIR__ . "/eXpansion/" . $plugin . ".ini", true);
        if (is_array($value)) {
            foreach ($value as $val) {
                if (isset($ini['default'][$item])) {
                    if ($ini['default'][$item] != $val && !empty($val)) {
                        $bufferSettings .= "ManiaLivePlugins\\eXpansion\\" . $plugin . "\\Config." . $item . "[] = \"" . $val . "\";\n";
                    }
                } else {
                    $bufferSettings .= "ManiaLivePlugins\\eXpansion\\" . $plugin . "\\Config." . $item . "[] = \"" . $val . "\";\n";
                }
            }
        } else {
            $forceOptions = array("Dedimania", "MusicBox", "ForceMod");
            if (isset($ini['default'][$item]) && !in_array($plugin, $forceOptions)) {
                if ($ini['default'][$item] != $value)
                    $bufferSettings .= "ManiaLivePlugins\\eXpansion\\" . $plugin . "\\Config." . $item . " = \"" . $value . "\";\n";
            } else {
                $bufferSettings .= "ManiaLivePlugins\\eXpansion\\" . $plugin . "\\Config." . $item . " = \"" . $value . "\";\n";
            }
        }
    }
}
?>
<pre><code><?php
        echo $bufferPlugins . "\n\n" . $bufferSettings;
        ?>
</code></pre>

