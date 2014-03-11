<?php

class OrderShell extends AppShell {

        function main() // main needs to define
        {
                App::import("Component", "BusinessLogic");
                $this->BusinessLogic = &new BusinessLogic();

                $option = !empty($this->args[0]) ? $this->args[0] : "";
                echo "Cron started without any issue.";

                switch ($option)
                {
                        case "first":
                        $result= $this->BusinessLogic->first_method();
                        break;
                        case "second":
                        $result= $this->BusinessLogic->deleteauto();
                        break;
                        default:
                        echo "No Parameters passed .";
                }
        }
}