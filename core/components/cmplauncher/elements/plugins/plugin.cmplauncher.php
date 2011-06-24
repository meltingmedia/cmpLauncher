<?php
/**
 * cmpLauncher plugin.
 *
 * @package cmplauncher
 */

$cmpdata = $scriptProperties['cmp'];
if (empty($cmpdata)) return;
$modx->lexicon->load('cmplauncher:default');

$ctxMgr = $modx->getObject('modContext',array('key' => 'mgr'));
$mgrHost = $ctxMgr->getOption('http_host');

$output = '';

switch ($modx->event->name) {
    case 'OnDocFormPrerender':
        $resource =& $modx->event->params['resource'];
        if(!$resource) {
            // a new resource is being to created, do nothing
            break;
        }
        //$currentCtxKey = $resource->get('context_key');
        $currentResTpl = $resource->get('template');
        $currentResId = $resource->get('id');

        $datas = explode(',',$cmpdata);
            foreach ($datas as $data) {
                // isolate each value for manipulations
                $setup = explode(':',$data);
                // the results
                // is it targeting a template or a resource ? (t/r)…
                $constraint = $setup[0];
                // … with this ID
                $cid = $setup[1];
                // the action ID
                $action = $setup[2];
                // if their is a fourth parameter, there will be a redirection to the action ID
                $autoRun = $setup[3];

                // grab the action id
                $a = $modx->getObject('modAction',$action);
                // load the lexicon to make use of it
                $modx->lexicon->load($a->get('lang_topics'));
                // grab the lexicon string used in modMenu
                $menu = $modx->getObject('modMenu',array("action" => $action));
                // the lexicon value supposed to be the component name
                $cmpName = $modx->lexicon($menu->get('text'));

                $debugMsg = ' Constraint: (t=template/r=resource) '.$constraint.'='.$cid.';action ID :'.$action;
                $debug = !empty($scriptProperties['debug']) ? $debugMsg : '';

                if (!empty($autoRun)) {
                    // we've been asked to launch the CMP, will do (good boy!)
                    if ($constraint == 'r' && $currentResId == $cid || $constraint == 't' && $currentResTpl == $cid) {
                        header('location:'.$modx->getOption('server_protocol').'://'.$mgrHost.$modx->getOption('manager_url').'index.php?a='.$action);
                        if (!empty($debug)) {
                            $modx->log(modX::LOG_LEVEL_ERROR, $debugMsg);
                        }
                    }
                } else if ($constraint == 'r' && $currentResId == $cid || $constraint == 't' && $currentResTpl == $cid) {
                    // seems we got a match (either resource or template id)
                    $output = '<div id="cmp-launcher"><span>'.$modx->lexicon('cmplauncher.launch').'</span><a href="index.php?a='.$action.'" class="x-btn x-btn-text bmenu x-btn-noicon">'.$cmpName.'</a>'.$debug.'</div>';
                    $modx->regClientCSS(MODX_ASSETS_URL.'components/cmplauncher/css/cmplauncher.css');
                }
            }

        $modx->event->output($output);
        break;
}
return;