## cmpLauncher

cmpLauncher is an Extra for MODX Revolution CMF (http://modx.com).
It allows you to display a link or redirect a user to a particular CMP (Component/Extra page)
based on the template ID or the resource ID you are editing.

NOTE: there is not ACL check in the plugin for now, so the links/redirections will occurs to any user.

## Usage

Once installed (via the package manager) edit the plugin property named "cmp" (check http://rtfm.modx.com/display/revolution20/Properties+and+Property+Sets#PropertiesandPropertySets-AssigningPropertySetstoElements for more infos on properties)
and use the following syntax:

`t:id:id,r:id:id:1,…`

Parameters:

* the first one is the constraint (t stand for template, r for resource)
* the second one is the template or resource ID
* the third one is the action ID
* the fourth parameter, if set, enables the automatic redirection to the CMP

Please, for now declare resources constraints after all your templates ones so
they can override. For example, let's say you want all resources using template ID 3
provide a link to the action ID 80, but you want the resource ID 20 (which uses the
template ID 3) to automaticly redirect the user to action 79, you would have to use:

`t:3:80,r:20:79:1`


## Credits & support

This plugin is inspired from Jakob Class' great work on the Babel plugin:

https://github.com/mikrobi/babel

Would you like to support?
Since my mother language isn't English, i might (more than probably) have written
ugly English. Feel free to provide a better one. Also, if you speak another language,
do not hesitate to provide a translation.

Can you write better code? Go on, fork, commit, pull request (comments on what i've
done badly are also welcomed… help me become a better dev!).

## Copyright Information

cmpLauncher is distributed as GPL (as MODx Revolution is), but the copyright owner
(Romain Tripault) grants all users of cmpLauncher the ability to modify, distribute
and use cmpLauncher in MODx development as they see fit, as long as attribution
is given somewhere in the distributed source of all derivative works.