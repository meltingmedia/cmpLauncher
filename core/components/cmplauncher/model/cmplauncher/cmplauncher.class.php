<?php
/**
 * cmpLauncher
 *
 * Copyright 2011 by Romain Tripault // Melting Media <romain@melting-media.com>
 *
 * cmpLauncher is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * cmpLauncher is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * cmpLauncher; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package cmplauncher
 */
/**
 * The base class for cmpLauncher.
 *
 * @package cmplauncher
 */
class cmpLauncher {
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('cmplauncher.core_path',$config,$this->modx->getOption('core_path').'components/cmplauncher/');
        $assetsUrl = $this->modx->getOption('cmplauncher.assets_url',$config,$this->modx->getOption('assets_url').'components/cmplauncher/');
        //$connectorUrl = $assetsUrl.'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            //'imagesUrl' => $assetsUrl.'images/',

            //'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            //'processorsPath' => $corePath.'processors/',
        ),$config);

        $this->modx->addPackage('cmplauncher',$this->config['modelPath']);
        $this->modx->lexicon->load('cmplauncher:default');
    }

    /**
     * Checks if the action is updating a resource
     *
     * @param int $action
     * @return bool
     */
    public function checkAction($action) {
        if (!is_numeric($action)) return false;
        $edit = $this->modx->getObject('modAction', array('controller' => 'resource/update'));
        if ($edit->get('id') != $action) return false;
        return true;
    }

    /**
     * Checks if there is any value to process in the plugin property sets
     *
     * @param array $scriptProperties
     * @return bool
     */
    public function init($scriptProperties) {
        $display = $scriptProperties['cmp_display'];
        $autoLaunch = $scriptProperties['cmp_autolaunch'];
        if (!$display && !$autoLaunch) return false;
        return true;
    }

    /**
     * Sanitize the parameters & execute the constraints if any match
     *
     * @param array $datas the constraints parameters
     * @param array $current the requested modResource
     * @param bool $debug activate the debug messages
     * @param bool $auto automatic redirection
     * @return void
     */
    public function process($datas, $current, $debug, $auto) {
        $rawData = explode(',',str_replace(' ','',strtolower($datas)));
        sort($rawData);
        foreach ($rawData as $data) {
            $setup = explode(':',$data);
            if (!$this->_sanitize($setup)) return;

            $constraint = array();
            $constraint['type'] = $setup[0];
            $constraint['id'] = $setup[1];
            $constraint['action'] = $setup[2];
            //
            $resource = array();
            $resource['tpl'] = $current->get('template');
            $resource['id'] = $current->get('id');

            if ($constraint['type'] == 'r' && $constraint['id'] == $resource['id'] || $constraint['type'] == 't' && $constraint['id'] == $resource['tpl']) {
                // automatic redirection
                if ($auto) {
                    if ($debug == 1) {
                        $this->_debug($constraint, $auto);
                        return;
                    }
                    // do the redirection
                    $params['a'] = $constraint['action'];

                    $this->modx->sendRedirect('manager/index.php?' . http_build_query($params));
                    return;
                }

                // display the widget
                $menu = $this->modx->getObject('modMenu',array("action" => $constraint['action']));
                $cmpName = $this->modx->lexicon($menu->get('text'));

                // display the debug infos
                if ($debug == 1) {
                    $this->_debug($constraint, $auto);
                    return;
                }

                // no debug, then output
                $content = $this->modx->lexicon('cmplauncher.launch');
                //$modx->regClientCSS($modx->getOption('cmplauncher.assets_url').'css/cmplauncher.css');
                $this->modx->regClientStartupScript($this->config['jsUrl'].'mgr/cmplauncher.js');
                $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    cmpLauncher.config = '.$this->modx->toJSON($this->config).';
    var w = MODx.load({
        xtype : "cmplauncher-window-cmp"
        ,cmp: "'.$cmpName.'"
        ,action: '.$constraint['action'].'
        ,content: "'.$content.'"
        ,renderTo: "modx-content"
    })
    w.show();
});
</script>');
            }
        }
    }

    /**
     * Debug message in MODX error log
     *
     * @param array $constraint the constraint parameters received
     * @param bool $auto automatic redirection
     * @return void
     */
    private function _debug($constraint, $auto) {
        $type = $auto ? $this->modx->lexicon('cmplauncher.debug_auto') : $this->modx->lexicon('cmplauncher.debug_display');
        switch ($constraint['type']) {
            case 't':
                $case = $this->modx->lexicon('cmplauncher.debug_template');
                break;
            case 'r':
                $case = $this->modx->lexicon('cmplauncher.debug_resource');
                break;
            default:
                $case = 'error';
                break;
        }
        $menu = $this->modx->getObject('modMenu',array("action" => $constraint['action']));
        $cmpName = $this->modx->lexicon($menu->get('text'));

        $debugMsg = $this->modx->lexicon('cmplauncher.debug_msg',array(
            'type' => $type,
            'cmp' => $cmpName,
            'cmpID' => $constraint['action'],
            'case' => $case,
            'constraintID' => $constraint['id'],
        ));
        $this->modx->log(modX::LOG_LEVEL_ERROR, $debugMsg);
    }

    /**
     * Sanitize & make sure the params are ok.
     *
     * @param array $params the parameters to check (type, id, action id)
     * @return bool
     */
    private function _sanitize($params) {
        $allowed = array('r', 't');
        if (!in_array($params[0], $allowed)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $this->modx->lexicon('cmplauncher.err_unknow_constraint_type', array('type' => $params[0])));
            return false;
        }

        if (!is_numeric($params[1]) || !is_numeric($params[2])) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $this->modx->lexicon('cmplauncher.err_expected_numeric', array('id' => $params[1], 'action' => $params[2])));
            return false;
        }

        $action = $this->modx->getObject('modAction', $params[2]);
        if (!$action) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $this->modx->lexicon('cmplauncher.err_nf_action', array('action' => $params[2])));
            return false;
        }
        // everything seems fine
        return true;
    }
}