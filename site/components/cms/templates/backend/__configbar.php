<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<script id="configbar_item_tmpl" type="text/x-jquery-tmpl">
  <li class="${component.name}-${name}">
    <a href="#" data-view="${component.name}/${name}" title="${prefered_description}">${prefered_title}</a>
  </li>
</script>

<ul id="configbar"></ul>
