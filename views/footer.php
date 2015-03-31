<?php
// Prevent direct calls to this file
if ( ! defined( 'APP_DIR' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
?>

	</div><!-- end of div.content -->
</div><!-- end of div.content-wrapper -->

<div class="footer">
	<div>
		<p id="share">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://phpcheatsheets.com/" data-text="These PHP cheat sheets are awesome!" data-via="jrf_nl" data-related="jrf_nl" title="Share this website on Twitter">Tweet</a>
			<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

			<script src="http://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
			<script type="IN/Share" data-url="http://phpcheatsheets.com/" data-counter="right"></script>

		</p>
		<p id="license">This PHP cheat sheet collection is inspired by the <a href="http://www.blueshoes.org/en/developer/php_cheat_sheet/" target="_blank">Blueshoes cheat sheet</a> and licensed under the <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GPLv3</a> software license. You can view and fork the source on <a href="http://github.com/jrfnl/PHP-cheat-sheet-extended" target="_blank">GitHub</a>. Pull requests welcome.</p>

		<div id="paypal-donate">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick" />
				<input type="hidden" name="hosted_button_id" value="8HS8MNK72DLH2" />
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
				<img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1" />
			</form>
		</div>

		<p id="call-to-donate">You can show your appreciation for the effort which has gone into creating these cheatsheets by giving a donation to the <a href="http://remembermewhenimgone.org/" title="Visit the Remember me when I'm gone project">Remember me when I&#39;m gone</a> non-profit project. Thanks!
		</p>

		<p id="copyright">&copy; 2006-<?php echo date( 'Y' ); ?> <a href="<?php echo BASE_URI; ?>about/">Advies en zo, Meedenken en -doen</a></p>

	</div>
</div><!-- end of div.footer -->

</body>
</html>