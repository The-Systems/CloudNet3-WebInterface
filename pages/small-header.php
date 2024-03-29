<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="<?= \webinterface\main::getUrl(); ?>/assets/styles.css" rel="stylesheet">
    <script src="<?= \webinterface\main::getUrl(); ?>/assets/js/charts-ram.js" defer></script>
    <script src="<?= \webinterface\main::getUrl(); ?>/assets/js/charts-cpu.js" defer></script>
</head>
<body class="dark:bg-gray-900 bg-gray-100">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<div class="md:flex flex-col md:flex-row md:min-h-screen md:mx-auto w-full">
    <div class="w-full overflow-x-hidden flex flex-col">
