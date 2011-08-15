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
 * Properties for the cmpLauncher plugin.
 *
 * @package cmplauncher
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'cmp_debug',
        'desc' => 'Enable debugging which adds a MODX log entry of the parameters instead of launching the plugin.',
        'type' => 'combo-boolean',
        'options' => '',
        //'value' => '',
        //'lexicon' => 'cmplauncher:properties',
    ),
    array(
        'name' => 'cmp_display',
        'desc' => 'Display an ExtJS widget, while editing the given resources, telling a CMP is used to manage some data.',
        'type' => 'textfield',
        'options' => '',
        //'value' => '',
        //'lexicon' => 'cmplauncher:properties',
    ),
    array(
        'name' => 'cmp_autolaunch',
        'desc' => 'Auto launch a CMP for the given resources.',
        'type' => 'textfield',
        'options' => '',
        //'value' => '',
        //'lexicon' => 'cmplauncher:properties',
    ),
);

return $properties;