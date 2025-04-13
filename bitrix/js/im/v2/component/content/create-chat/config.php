<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/create-chat-content.bundle.css',
	'js' => 'dist/create-chat-content.bundle.js',
	'rel' => [
		'im.v2.lib.feature',
		'im.v2.component.animation',
		'ui.entity-selector',
		'main.core',
		'im.v2.component.elements',
		'ui.notification',
		'main.core.events',
		'main.popup',
		'im.public',
		'im.v2.application.core',
		'im.v2.lib.create-chat',
		'im.v2.lib.permission',
		'im.v2.provider.service',
		'im.v2.const',
		'ui.forms',
	],
	'skip_core' => false,
];