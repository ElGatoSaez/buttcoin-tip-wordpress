<?php

/* 
Plugin Name: Buttcoin Tipping
Plugin URI: http://github.com/ElGatoSaez/buttcoin-tip-wordpress
Description: Tip a buttcoin to an article
Version: 1.0
Author: Sebastián Sáez
*/

// Acá estamos añadiendo un submenú a los plugins de WordPress
function buttcoin_tipping_menu_item()
	{
		add_submenu_page("options-general.php", "Buttcoin Tipping", "Buttcoin Tipping", "manage_options", "buttcoin-tipping", "buttcoin_tipping_opt");
	}

add_action("admin_menu", "buttcoin_tipping_menu_item");

function buttcoin_tipping_opt
	{
		?>
			<div class="wrap">
				<h1>Buttcoin Tipping Options</h1>
					<form method="post" action="options.php">
						<?php
							settings_fields("buttcoin_tipping_config_section");
							
							do_settings_sections("buttcoin-tipping");
							
							submit_button();
						?>
					</form>
			</div>
		<?php
	}

function buttcoin_tipping_settings()
	{
		add_settings_section("buttcoin_tipping_config_section", "", null, "buttcoin-tipping");
		
		add_settings_field("buttcoin-tipping-account", "Your buttcoin account", "buttcoin_tipping_account_textbox", "buttcoin-tipping", "buttcoin_tipping_config_section");
		add_settings_field("buttcoin-tipping-amount", "Amount you want people to tip", "buttcoin_tipping_amount_textbox", "buttcoin-tipping", "buttcoin_tipping_config_section");
		add_settings_field("buttcoin-tipping-callback", "API Callback URL (Leave it blank if you don't know what does it mean)", "buttcoin_tipping_callback_textbox", "buttcoin-tipping", "buttcoin_tipping_config_section");
		
		register_setting("butting_tipping_config_section", "buttcoin-tipping-account");
		register_setting("butting_tipping_config_section", "buttcoin-tipping-amount");
		register_setting("butting_tipping_config_section", "buttcoin-tipping-callback");
	}

function
 