
		<div id="main-menu">
			<p>
				<a href="index.php?page=compare" class="top-link<?php if ( $type === 'compare' ) print ' top-active'; ?>">
					Variable&nbsp;Comparison Cheat&nbsp;sheet
					<img src="./<?php if ( isset( $dir ) ) print $dir; ?>page/screenshot-var-compare.png" width="220" height="220" alt="Screenshot" />
				</a>
				<a href="index.php?page=arithmetic" class="top-link<?php if ( $type === 'arithmetic' ) print ' top-active'; ?>">
					Variable&nbsp;Arithmetic Cheat&nbsp;sheet
					<img src="./<?php if ( isset( $dir ) ) print $dir; ?>page/screenshot-var-arithm.png" width="220" height="220" alt="Screenshot" />
				</a>
				<a href="index.php?page=test" class="top-link<?php if ( $type === 'test' ) print ' top-active'; ?>">
					Variable&nbsp;Testing Cheat&nbsp;sheet
					<img src="./<?php if ( isset( $dir ) ) print $dir; ?>page/screenshot-var-tests.png" width="220" height="220" alt="Screenshot" />
				</a>
			</p>
		</div>
		

		<div class="important">
			<h3>Please note: these cheat sheets are generated live with PHP <?php print htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' ); ?>.</h3>
			<p>Alternatively, you can <a href="./static_results/">browse static versions</a> of the cheat sheets generated with various PHP versions.</p>
		</div>
