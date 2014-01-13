<div class="row">
    <div class="col-md-12">
        <h1>Step2 - Configure</h1>
        <p>It's encouraged not to fill community keys, codes or passwords. Just leave those fields blank and edit them to your local configure file.</p>
        <form action="?step=3" method="POST" onsubmit="submitt()">
            <?php
            $additionalPlugins = json_decode($_POST['plugins']);
            echo '<input type="hidden" name="plugins" value=\'' . $_POST['plugins'] . '\'>';
            unset($additionalPlugins[0]);
            foreach ($additionalPlugins as $plugin) {
                genconfig($plugin);
            }

            $ini = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . "plugins.ini", true);
            foreach ($ini['core']['plugin'] as $plugin) {
                genconfig($plugin);
            }
            foreach ($ini['autoload']['plugin'] as $plugin) {
                genconfig($plugin);
            }

            $file = __DIR__ . DIRECTORY_SEPARATOR . 'eXpansion/AutoLoad.ini';
            $autoload = parse_ini_file($file, true);
            ?>

            <div class="row">
                <h1>Autoload</h1>
                <p>You can disable some of the plugins from the autoload by drag'n'droping the plugins to disabled container.</p>

                <div class="col-md-3">
                    <div>
                        <h3>Disabled Plugins</h3>
                        <ul id="disable" class="connected">                            
                        </ul>                        
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div>
                        <h3>Autoloaded Plugins</h3>
                        <ul id="available" class="connected">
                            <?php
                            foreach ($autoload['options']['disable'] as $item) {
                                $item = str_replace("eXpansion\\", "", $item);
                                echo "<li>$item</li>\n";
                            }
                            ?>
                        </ul>                        
                    </div>

                </div>
            </div>
            <input type="hidden" id="disabledAutoLoad" name="disabledAutoLoad" />
            <input type="submit" value="Apply" class="apply"/>
        </form>

        <style>
            .apply {
                padding: 0.5em 3em;
            }
            .row {
                margin: 0.5em;
            }
            .col-md-3 input {
                min-width: 100%;
                padding: 2px;
                border: 1px solid black;
            }
            select {
                min-width: 100%;
                padding: 2px;
                border: 1px solid black;

            }
            .connected {                
                padding: 0;                
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .connected li {
                cursor: move;
                list-style: none;
                border: 1px solid #CCC;
                background: #F6F6F6;
                font-family: "Tahoma";
                color: #1C94C4;
                margin: 5px;
                padding: 5px;

            }
            li.disabled {
                background: white;
            }
            #disable, #available {
                min-height: 2em;
                border: 1px dashed #aaa;

            }
        </style>
        <script>
            jQuery('#available, #disable').sortable({
                connectWith: '.connected',
            });

            function submitt() {
                var array = [];
                $('#disable li').each(function(index) {
                    array.push($(this).text());
                });
                console.log(JSON.stringify(array));
                $("#disabledAutoLoad").val(JSON.stringify(array));
            }




        </script>
    </div>
</div>

<?php

function genconfig($plugin) {
    $plugin = str_replace("\\", DIRECTORY_SEPARATOR, $plugin);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $plugin . ".ini";
    if (!file_exists($file))
        return;

    $ini = parse_ini_file($file, true);
    $name = str_replace("eXpansion", "", $plugin);
    $name = str_replace(array("\\", "/"), "", $name);
    echo "<h2>$name</h2>\n";

    foreach ($ini['types'] as $item => $type) {
        $type = explode(",", $type);
        $type = trim($type[0]);

        switch ($type) {
            case "array":
                multiInput($ini, $item, $plugin);
                break;
            case "bool":
                boolInput($ini, $item, $plugin);
                break;
            case "int":
            case "float":
                inputNumeric($ini, $item, $plugin);
                break;
            case "string":
                inputBox($ini, $item, $plugin);
                break;
            default:
                inputBox($ini, $item, $plugin);
                break;
        }
    }
}

function multiInput($ini, $item, $plugin) {
    $value = "";
    $plugin = str_replace("eXpansion\\", "", $plugin);
    echo '<div class="row">';
    echo "<div class='item col-md-3'>" . $item . "</div>\n";
    if (is_array($ini['default'][$item])) {
        echo '<div class="value col-md-3">';

        foreach ($ini['default'][$item] as $value) {
            echo '<input type="text" name="' . $plugin . "#" . $item . '[]" value="' . $value . '"/>' . "\n";
        }
        echo '</div>';
    }
    if (isset($ini['description'][$item])) {
        echo '<div class="col-md-6">' . $ini['description'][$item] . '</div>';
    }
    echo '</div>';
}

function inputNumeric($ini, $item, $plugin) {
    $value = "";
    $plugin = str_replace("eXpansion\\", "", $plugin);
    echo '<div class="row">';
    echo "<div class='item col-md-3'>" . $item . "</div>";
    if (isset($ini['default'][$item]))
        $value = $ini['default'][$item];
    echo '<div class="value col-md-3"><input type="number" step="any" name="' . $plugin . "#" . $item . '" value="' . $value . '"/></div>';
    if (isset($ini['description'][$item])) {
        echo '<div class="col-md-6">' . $ini['description'][$item] . '</div>';
    }
    echo '</div>';
}

function inputBox($ini, $item, $plugin) {
    $plugin = str_replace("eXpansion\\", "", $plugin);
    $value = "";
    echo '<div class="row">';
    echo "<div class='item col-md-3'>" . $item . "</div>";
    if (isset($ini['default'][$item]))
        $value = $ini['default'][$item];
    echo '<div class="value col-md-3"><input type="text" name="' . $plugin . "#" . $item . '" value="' . $value . '"/></div>';
    if (!empty($ini['description'][$item])) {
        echo '<div class="col-md-6">' . $ini['description'][$item] . '</div>';
    }

    echo '</div>';
}

function boolInput($ini, $item, $plugin) {
    $value = "";
    $plugin = str_replace("eXpansion\\", "", $plugin);
    echo '<div class="row">';
    echo "<div class='item col-md-3'>" . $item . "</div>";
    if (isset($ini['default'][$item]))
        $value = $ini['default'][$item];
    echo '<div class="value col-md-3"><select name="' . $plugin . "#" . $item . '">';
    if ($value == "true") {
        echo '<option value="true" selected="selected">true</option>';
        echo '<option value="false">false</option>';
    } else {
        echo '<option value="true">true</option>';
        echo '<option value="false" selected="selected">false</option>';
    }

    echo '</select>' . '</div>';
    if (!empty($ini['description'][$item])) {
        echo '<div class="col-md-6">' . $ini['description'][$item] . '</div>';
    }
    echo '</div>';
}
?>