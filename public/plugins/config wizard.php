<?php

class Page {

    public function init() {
        if (array_key_exists("step", $_REQUEST)) {
            switch ($_REQUEST['step']) {
                case "2":
                    require_once(__DIR__ . DIRECTORY_SEPARATOR . "_data" . DIRECTORY_SEPARATOR . "step2.php");
                    break;
                case "3":
                    require_once(__DIR__ . DIRECTORY_SEPARATOR . "_data" . DIRECTORY_SEPARATOR . "step3.php");
                    break;
                default:
                    require_once(__DIR__ . DIRECTORY_SEPARATOR . "_data" . DIRECTORY_SEPARATOR . "step1.php");
                    break;
            }
        } else {
            require_once(__DIR__ . DIRECTORY_SEPARATOR . "_data" . DIRECTORY_SEPARATOR . "step1.php");
        }
    }
}
