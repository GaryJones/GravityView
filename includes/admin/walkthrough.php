<?php

class GravityView_Admin_Walkthrough {

	function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'print_scripts' ));

		add_action( 'admin_footer', array( $this, 'admin_head' ) );

		add_action( 'in_admin_header', array( $this, 'render_walkthrough_ol') );
	}

	function add_tip_container() {

	}

	function admin_head() {
		?>
	<script>
		jQuery( document ).ready(function($) {

			var gv_tour_settings = {
				'modal': true,
				'expose': true,
				'autoStart' : true,
				'cookieMonster': false,
				'cookieName': 'gvtour-'+ adminpage, // Each page can have its own tour
				'cookiePath': gvTour.cookiepath,
				'cookieDomain': gvTour.cookiedomain,
				'tipLocation': 'bottom',
				'tipContainer': '#gv-walkthrough-container',
				'template': {
					'link': '<a href="#close" class="joyride-close-tip"><i class="dashicons dashicons-dismiss" ></i></a>',
					'button'  : '<a href="#" class="joyride-next-tip button button-primary"></a>',
				},
				'preStepCallback': function( index, $tip ) {
					console.log(index, $tip);
					return false;
				},
				'postExposeCallback': function( index, $tip, element ) {
					console.log(index, $tip, element);
					if( element.hasClass('gv-only-on-load') ) {
						//$(element).appendTo('#gv-tour-disabled');
					}
					return false;
				}
			};

			$( 'body' )
				.append( '<div id="gv-walkthrough-container" />' )
				.on( 'gv-tabscreate gv-show-view-config', function() {

					// If they have added widgets, they know how to add widgets.
					if( $('#directory-header-widgets').find('div.gv-fields').length > 0 ) {
						$('#gv-tour').find('.gv-no-widgets').appendTo('#gv-tour-disabled');
					}

					// If they have added fields, they know how to add fields.
					if( $('#directory-active-fields').find('div.gv-fields').length > 0 ) {
						$('#gv-tour').find('.gv-no-fields').appendTo('#gv-tour-disabled');
					}

					jQuery("#gv-tour").joyride(gv_tour_settings);
				});

		});
	</script>
	<?php
	}

	function render_walkthrough_ol( ) {
		global $pagenow;

		$gv_page = GravityView_Admin::is_admin_page();
	?>
	<ol id="gv-tour-disabled"></ol>
	<ol id="gv-tour" class="hide-if-js">
		<?php

		switch ( $gv_page ) {
			case 'views':
				$this->walkthrough_views();
				break;
			case 'single':
				if( $pagenow === 'post-new.php' ) {
					$this->walkthrough_new();
				} else {
					$this->walkthrough_single();
				}
				break;
		}
	?>
	</ol>
	<?php
	}

	function walkthrough_views() {
		global $posts;
		/*
		if( empty( $posts ) && empty( $_GET['post_status'] ) ) {
	?>
		<li data-class="add-new-h2">Click to create a new view.</li>
<?php
		} // End empty posts*/
	}

	function walkthrough_single() {

		global $gravityview_view;
	?>
		<li class="gv-no-widgets" data-id="view-configuration-single-entry-link" data-button="Got it!">Don't forget to configure the Single Entry fields!</li>
		<li data-id="gravityview_form_id">Or you can choose from a list of existing forms.</li>
		<li class="gv-no-fields" data-class="gv-add-field">Eample!</li>
	<?php
	}

	function walkthrough_new() {
		?>
		<li class="gv-only-on-load" data-button="Yes, Gimme a Tour">
			<?php echo '<img src="'.plugins_url( 'images/astronaut-200x263.png', GRAVITYVIEW_FILE ).'" class="alignleft" height="87" width="66" alt="The GravityView Astronaut Says:" style="margin:0 10px 10px 0;" />'; ?>
			<h4>Welcome to GravityView! Would you like a tour?</h4>
			<p>If not, click the X button above and you won&rsquo;t be shown this again. You can restart the tour at any time by [[[[[todo]]]]].</p>
		</li>
		<li class="gv-only-on-load" data-id="gv_start_fresh_button">GravityView has preset View Types with all the fields configured - when you choose one, a corresponding Gravity Forms form will be created for you.</li>
		<li class="gv-only-on-load" data-id="gravityview_form_id">Or you can choose from a list of existing forms.</li>
		<li class="gv-only-on-load" data-id="gv-shortcode-helper" data-options="nubPosition:top-right;">You can embed this View in a post or a page by pasting this code.</li>
		<?php
	}

	function print_scripts() {

		wp_enqueue_style( 'gv-joyride', plugins_url('includes/css/admin-joyride.css', GRAVITYVIEW_FILE ) );

		wp_enqueue_script( 'gv-joyride', plugins_url('includes/lib/joyride/jquery.joyride-2.1.js', GRAVITYVIEW_FILE ), array( 'jquery', 'gravityview-jquery-cookie' ), GravityView_Plugin::version, true );

		wp_localize_script( 'gv-joyride', 'gvTour', array(
			'cookiepath' => COOKIEPATH,
			'cookiedomain' => (defined('COOKIE_DOMAIN')) ? COOKIE_DOMAIN : NULL,
		));

	}

}

new GravityView_Admin_Walkthrough;
