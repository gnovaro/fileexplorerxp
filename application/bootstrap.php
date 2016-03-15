<?php
    error_reporting(E_ALL);
    session_start();
    //Load config if not exist run setup
    if (!file_exists(dirname(__DIR__).'/config.php'))
    {
        header("location: setup.php");
    }
    require dirname(__DIR__).'/config.php';

    /**
     * Internacionalization i18n
     */
    define('DEFAULT_LANG','es');
    // Auto detect user lang
    $user_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
    $user_lang = 'es';
    //debug
    //echo $user_lang;
	$lang = file_exists(__DIR__."/i18n/$user_lang.php") ? $user_lang : DEFAULT_LANG;
    $lang_keys = require(__DIR__."/i18n/$lang.php");
    require __DIR__.'/classes/I18n.php';
