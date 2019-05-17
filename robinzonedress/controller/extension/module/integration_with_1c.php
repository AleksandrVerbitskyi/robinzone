<?php

class ControllerExtensionModuleIntegrationWith1C extends Controller {
    public function index() {
        $import = new Import\Import;
        $import->startImport();
        die("Finished successfully");
    }
}