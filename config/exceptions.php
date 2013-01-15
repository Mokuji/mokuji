<?php if(!TX) die('No direct access.');

define('EX_ERROR', 1);

define('EX_EXCEPTION', 2);

define('EX_EXPECTED', 4);

define('EX_UNEXPECTED', 8);

define('EX_AUTHORISATION', 16);

define('EX_EMPTYRESULT', 32);

define('EX_VALIDATION', 64);

define('EX_USER', 128);

define('EX_PROGRAMMER', 256);

define('EX_SQL', 512);

define('EX_CONNECTION', 1024);

define('EX_INVALIDARGUMENT', 2048);

define('EX_DEPRECATED', 4096);

define('EX_RESTRICTION', 8192);

define('EX_NOTFOUND', 16384);

define('EX_FILEMISSING', 32768);

define('EX_INPUTMISSING', 65536);

define('EX_MODEL_VALIDATION', 131072);
