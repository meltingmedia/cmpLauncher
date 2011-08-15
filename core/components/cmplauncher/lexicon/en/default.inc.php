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
 * Default English Lexicon Entries for cmpLauncher
 *
 * @package cmplauncher
 * @subpackage lexicon
 */
$_lang['cmplauncher.launch'] = 'Launch CMP : ';

// Error msgs
$_lang['cmplauncher.err_expected_numeric'] = 'Expected numeric values for constraint id: [[+id]] and for action id: [[+action]].';
$_lang['cmplauncher.err_nf_action'] = 'The given action ID ([[+action]]) is not valid one.';
$_lang['cmplauncher.err_unknow_constraint_type'] = 'Unknow constraint type: [[+type]].';

// Debug msgs
$_lang['cmplauncher.debug_auto'] = 'automaticly launch';
$_lang['cmplauncher.debug_display'] = 'display';
$_lang['cmplauncher.debug_msg'] = 'I\'ve been told to [[+type]] the CMP [[+cmp]] (id=[[+cmpID]]) while editing [[+case]] [[+constraintID]]';
$_lang['cmplauncher.debug_resource'] = 'the resource having id:';
$_lang['cmplauncher.debug_template'] = 'a resource with a template id:';