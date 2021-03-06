<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
	throw new Exception('401 Unauthorized');
}
$eqLogics = wifismartplug::byType('wifismartplug');
?>

<table class="table table-condensed tablesorter" id="table_healthmpower">
	<thead>
		<tr>
			<th>{{Image}}</th>
			<th>{{Module}}</th>
			<th>{{ID}}</th>
			<th>{{IP}}</th>
			<th>{{Modèle}}</th>
			<th>{{Mac Address}}</th>
			<th>{{Date création}}</th>
		</tr>
	</thead>
	<tbody>
	 <?php
foreach ($eqLogics as $eqLogic) {
    
    // recup macAddress
    $macAddress = '';
    foreach ($eqLogic->getCmd() as $cmd)
    {
      //  log::add('smartplug', 'debug','health'.$cmd->getName(). ' id '.$cmd->getEqLogic_id() );
        if($cmd->getName() == 'macAddress')   {
            
            $macAddress = $cmd->execCmd(); // recup value
            log::add('wifismartplug', 'debug','healthmacadresse'.$macAddress );
        }
    }
    
    $opacity = '';
    if ($eqLogic->getIsEnable() != 1) {
        $opacity = 'opacity:0.3;';
    }
    if ($eqLogic->getConfiguration('model', '') != '') {
        $image = '<img src="plugins/wifismartplug/docs/images/' . $eqLogic->getConfiguration('model', '') . '.jpg" height="55" width="55" />';
    } else {
        $image = '<img src="plugins/mpower/docs/images/mpower_icon.png" height="55" width="55" />';
    }
echo '<tr><td>' . $image . '</td><td><a href="' . $eqLogic->getLinkToConfiguration() . '" style="text-decoration: none;">' . $eqLogic->getHumanName(true) . '</a></td>';
echo '<td><span class="label label-info" style="font-size : 1em;">' . $eqLogic->getId() . '</span></td>';
echo '<td><span class="label label-info" style="font-size : 1em;">' . $eqLogic->getConfiguration('addr') . '</span></td>';
echo '<td><span class="label label-info" style="font-size : 1em;">' . $eqLogic->getConfiguration('model') . '</span></td>';
    echo '<td><span class="label label-info" style="font-size : 1em;">' .  $macAddress. '</span></td>';

echo '<td><span class="label label-info" style="font-size : 1em;">' . $eqLogic->getConfiguration('createtime') . '</span></td></tr>';
}
?>
	</tbody>
</table>
