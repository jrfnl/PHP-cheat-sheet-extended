<?php
// Prevent direct calls to this file
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
?>

		<img src="./<?php echo $dir; ?>page/images/gluek_100179589_2f40795a85_m.jpg" width="240" height="180" alt="Sad ElePHPant" class="e404"/>
		
		<font size="1"><table class="e404" dir="ltr" border="1" cellspacing="0" cellpadding="1">
		<tr>
			<th align="left" class="e404-title" colspan="5">
				<span>( ! )</span> PHP Fatal error: this page does not exist in /my/phpcheatsheets.com on line <i>1</i>
			</th>
		</tr>
		<tr>
			<th align="left" class="e404-cs" colspan="5">Call Stack</th>
		</tr>
		<tr>
			<th align="center">#</th>
			<th align="left">Time</th>
			<th align="left">Memory</th>
			<th align="left">Function</th>
			<th align="left">Location</th>
		</tr>
		<tr>
			<td align="center">1</td>
			<td align="center">0.123</td>
			<td align="right">123</td>
			<td>{main}(  )</td>
			<td>../my/phpcheatsheets.com<b>:</b>0</td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td align="center">0.234</td>
			<td align="right">234</td>
			<td>Cheatsheet->find_page(  )</td>
			<td>../my/phpcheatsheets.com<b>:</b>27</td>
		</tr>
		<tr>
			<td align="center">3</td>
			<td align="center">0.345</td>
			<td align="right">345</td>
			<td>Cheatsheet->are_you_sure->look_again(  )</td>
			<td>../my/phpcheatsheets.com<b>:</b>123</td>
		</tr>
		<tr>
			<td align="center">4</td>
			<td align="center">0.404</td>
			<td align="right">404</td>
			<td>Cheatsheet->oh_dear->display_404(  )</td>
			<td>../my/phpcheatsheets.com<b>:</b>61</td>
		</tr>
		</table></font>