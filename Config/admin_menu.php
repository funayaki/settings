<?php

namespace Config;

CroogoNav::add('sidebar', 'settings', array(
	'icon' => 'cog',
	'title' => __d('croogo', 'Settings'),
	'url' => array(
		'admin' => true,
		'plugin' => 'settings',
		'controller' => 'settings',
		'action' => 'prefix',
		'Site',
	),
	'weight' => 60,
	'children' => array(
		'site' => array(
			'title' => __d('croogo', 'Site'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Site',
			),
			'weight' => 10,
		),

		'meta' => array(
			'title' => __d('croogo', 'Meta'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Meta',
			),
			'weight' => 20,
		),

		'reading' => array(
			'title' => __d('croogo', 'Reading'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Reading',
			),
			'weight' => 30,
		),

		'writing' => array(
			'title' => __d('croogo', 'Writing'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Writing',
			),
			'weight' => 40,
		),

		'comment' => array(
			'title' => __d('croogo', 'Comment'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Comment',
			),
			'weight' => 50,
		),

		'service' => array(
			'title' => __d('croogo', 'Service'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'settings',
				'action' => 'prefix',
				'Service',
			),
			'weight' => 60,
		),

		'languages' => array(
			'title' => __d('croogo', 'Languages'),
			'url' => array(
				'admin' => true,
				'plugin' => 'settings',
				'controller' => 'languages',
				'action' => 'index',
			),
			'weight' => 70,
		),

	),
));