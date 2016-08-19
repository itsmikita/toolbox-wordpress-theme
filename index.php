<?php

use Toolbox\View;

get_header();
get_footer();

$data = [];

print View::render( 'index', $data );