
		<div id="main-menu">
			<p>
				<a href="index.php?page=compare" class="top-link<?php if ( $type === 'compare' ) { echo ' top-active'; } ?>">
					Variable&nbsp;Comparison<br />Cheat&nbsp;sheet
					<img src="./page/screenshot-var-compare.png" width="220" height="220" alt="Variable Comparison Cheatsheet Screenshot" />
				</a>
				<a href="index.php?page=arithmetic" class="top-link<?php if ( $type === 'arithmetic' ) { echo ' top-active'; } ?>">
					Variable&nbsp;Arithmetic<br />Cheat&nbsp;sheet
					<img src="./page/screenshot-var-arithm.png" width="220" height="220" alt="Variable Arithmetic Cheatsheet Screenshot" />
				</a>
				<a href="index.php?page=test" class="top-link<?php if ( $type === 'test' ) { echo ' top-active'; } ?>">
					Variable&nbsp;Testing<br />Cheat&nbsp;sheet
					<img src="./page/screenshot-var-tests.png" width="220" height="220" alt="Variable Testing Cheatsheet Screenshot" />
				</a>
			</p>
		</div>
		

		<div class="important">
			<h3>Please note: these cheat sheets are generated live with PHP <?php echo htmlspecialchars( PHP_VERSION, ENT_QUOTES, 'UTF-8' ); ?>.</h3>
			<p>Alternatively, you can <a href="./static_results/">browse static versions</a> of the cheat sheets generated with various PHP versions.</p>
		</div>
