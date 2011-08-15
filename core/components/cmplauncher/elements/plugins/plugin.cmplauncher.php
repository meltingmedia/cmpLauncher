<?php
/**
 * cmpLauncher plugin.
 *
 * @package cmplauncher
 */

$cmpLauncher = $modx->getService('cmplauncher','cmpLauncher',$modx->getOption('cmplauncher.core_path',null,$modx->getOption('core_path').'components/cmplauncher/').'model/cmplauncher/',$scriptProperties);
if (!($cmpLauncher instanceof cmpLauncher)) return;

if (!$cmpLauncher->checkAction($_GET['a'])) return;
if (!$cmpLauncher->init($scriptProperties)) return;

$debug = $scriptProperties['cmp_debug'];
$display = $scriptProperties['cmp_display'];
$autoLaunch = $scriptProperties['cmp_autolaunch'];

$resource = $modx->getObject('modResource', $_GET['id']);

$output = '';

switch ($modx->event->name) {
    case 'OnBeforeManagerPageInit':
        $auto = true;
        if (!$autoLaunch) break;

        $cmpLauncher->process($autoLaunch, $resource, $debug, $auto);
        break;

    case 'OnDocFormPrerender':
        $auto = false;
        if(!$display) break;

        $cmpLauncher->process($display, $resource, $debug, $auto);
        break;

    default:
        break;
}
return;