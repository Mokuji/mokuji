<?php

require_once('system/dependencies/Initializer.php');

use \dependencies\Initializer;

Initializer::get_instance()
  ->set_environment(Initializer::ENV_FRONTEND)
  ->enable_debugging(true)
  ->run_environment();
