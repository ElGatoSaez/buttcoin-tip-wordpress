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

function buttcoin_tipping_opt()
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
		
		add_settings_field("buttcoin-tipping-account", "Your buttcoin account", "buttcoin_tipping_account_text", "buttcoin-tipping", "buttcoin_tipping_config_section");
		add_settings_field("buttcoin-tipping-amount", "Amount you want people to tip", "buttcoin_tipping_amount_text", "buttcoin-tipping", "buttcoin_tipping_config_section");
		add_settings_field("buttcoin-tipping-callback", "API Callback URL (Leave it blank if you don't know what does it mean)", "buttcoin_tipping_callback_text", "buttcoin-tipping", "buttcoin_tipping_config_section");
		
		register_setting("butting_tipping_config_section", "buttcoin-tipping-account");
		register_setting("butting_tipping_config_section", "buttcoin-tipping-amount");
		register_setting("butting_tipping_config_section", "buttcoin-tipping-callback");
	}

function buttcoin_tipping_account_text()
	{
		?>
			<input type="text" name="buttcoin-tipping-account" <?php $acc = get_option('buttcoin-tipping-account'); ?> />
		<?php
	}

function buttcoin_tipping_amount_text()
	{
		?>
			<input type="text" name="buttcoin-tipping-amount" <?php $butts = get_option('buttcoin-tipping-amount'); ?> />
		<?php
	}

function buttcoin_tipping_callback_text()
	{
		?>
			<input type="text" name="buttcoin-tipping-callback" <?php $cburl = get_option('buttcoin-tipping-callback'); ?> />
		<?php
	}

function original_buttcoin_tipping()
	{
		$apiButt = "https://hira.io/butt.php?a=new&amount=" . $butts . "&callback=" . $cburl . "&deposit_to=" . $acc;
		// Retreiving those contents
		$getJson = file_get_contents($apiButt);
		// Decoding that JSON to be readable
		$nowJson = json_decode($getJson, true);
		// Getting the Transaction ID
		$tID = $nowJson['id'];
		// Then getting the final webpage (dun dun dun dun)
		$fURL = "https://hira.io/buttwait.php?tid=" . $tID;
		
		global $fURL;
	}
function add_buttcoin_tipping_icon($content)
	{
		$html = "<div class='buttcoin-tipping-wrapper'><div class='butt-on'> Dona un buttcoin: </div>";
		
		global $post;

		$html = $html . "<div class='butt'><a target='_blank' href=" . "'" . $fURL . "'" . ">Dona acá</a></div>";
		
		return $content = $content . $html;
}

add_filter("the_content", "add_buttcoin_tipping_icon");
?>  