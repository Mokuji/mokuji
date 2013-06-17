<?php

require_once('../system/dependencies/Initializer.php');

use \dependencies\Initializer;

Initializer::get_instance()
  ->set_environment(Initializer::ENV_BACKEND)
  ->set_root('../')
  ->set_url_path(str_replace('/admin/index.php', '', $_SERVER['PHP_SELF']))
  ->enable_debugging(true)
  ->run_environment();