<h1>Plugins configuration Wizard - Step 1 </h1>
<p>You can easily create plugins configurations file using this wizard, dran'n'drop additional plugins you wish to enable and click apply after you are done.
    The plugins pack will do quite good also only with autoload. </p>

<div class="row">    
    <div class="col-md-3">
        <form action="?step=2" method="POST" onsubmit="submitt()">
            <input type="hidden" id="plugins" name="plugins" />

            <h2>Enabled Plugins</h2>
            <ul id="enabled" class="connected">
                <li class="disabled">eXpansion\AutoLoad</li>                    
            </ul>

            <input type="submit" value="Submit" />
        </form>
    </div>   
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h2>Optional plugins</h2>
        <?php
        $ini = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . "plugins.ini", true);
        echo "<div>\n";
        echo "<ul id='available' class='connected'>";
        foreach ($ini['optional']['plugin'] as $plugin) {
            $plugin = str_replace("eXpansion\\", "", $plugin);
            echo "<li>$plugin</li>\n";
        }

        echo "</ul>";
        echo "</div>"
        ?>
    </div>        


</div>
<div class="row">
    <div class="col-md-12">


    </div>
</div>

<script>
    jQuery('#available, #enabled').sortable({
        connectWith: '.connected',
        items: ':not(.disabled)'
    });
    
    function submitt() {
        var array = [];
        $('#enabled li').each(function(index) {
            array.push("eXpansion\\" + $(this).text());
        });
        $("#plugins").val(JSON.stringify(array));
    }




</script>

<style>
    .connected {                
        padding: 0;
        width: 300px;
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
    #enabled, #available {
        min-height: 2em;
        border: 1px dashed #aaa;

    }
</style>