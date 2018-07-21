<?php

if ( file_exists( Plugin_ROOT . 'panel/redux-framework/framework.php' ) ) {
	require_once Plugin_ROOT . 'panel/redux-framework/framework.php';
}
if ( file_exists( Plugin_ROOT . 'panel/redux-extensions/extensions-init.php' ) ) {
	require_once Plugin_ROOT . 'panel/redux-extensions/extensions-init.php';
}

if ( file_exists( Plugin_ROOT . 'panel/options-init.php' ) ) {
	require_once Plugin_ROOT . 'panel/options-init.php';
}


