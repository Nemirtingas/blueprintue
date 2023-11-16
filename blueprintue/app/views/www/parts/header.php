<?php

/* @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Rancoud\Security\Security;

/* @var $data array */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Security::escHTML($this->title); ?></title>

    <?php echo $this->noRobotsIndex(); ?>
    <meta content="<?php echo Security::escAttr($this->description); ?>" name="description">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=5.0" name="viewport">
    <link href="/site.css" rel="stylesheet">

    <!--[if IE]>
    <meta HTTP-EQUIV="REFRESH" content="0; url=/ie.html">
    <![endif]-->

    <!-- favicons -->
    <link href="/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
    <link href="/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
    <link crossorigin="use-credentials" href="/site.webmanifest" rel="manifest">
    <meta content="#1a1c1f" name="msapplication-TileColor">
    <meta content="#ffffff" name="theme-color">

    <!-- http://humanstxt.org -->
    <link type="text/plain" rel="author" href="/humans.txt">
</head>