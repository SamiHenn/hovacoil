<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 25-Sep-16
 * Time: 11:58 AM
 */

namespace sogo;


/**
 * Login Class By Sogo
 */
class Login {

	/**
	 * Login constructor.
	 */
	function __construct() {

		if ( ! is_admin() ) {

			add_action( 'wp_enqueue_scripts', array( $this, 'load_login_scripts' ) );

		}
		// Register ajax actions
		add_action( 'wp_ajax_nopriv_sogo_login', array( $this, 'handle_login' ) );


		add_action( 'wp_ajax_nopriv_sogo_register', array( $this, 'handle_register' ) );

		add_action( 'wp_ajax_sogo_logout', array( $this, 'handle_logout' ) );
	}

	function load_login_scripts() {
//        wp_enqueue_script('google-login', 'https://apis.google.com/js/api:client.js', array(), '', false);
		wp_enqueue_script( 'sogo-login', get_template_directory_uri() . '/assets/js/login.js', array(), '', true );
	}


	function handle_login() {


		// Login form arguments.
		if ( ! isset( $_POST['data'] ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'Empty values', 'sogo' ),
			) );
			die();
		}
		$data = $_POST['data'];

		$data = wp_parse_args( $data );
		if ( ! wp_verify_nonce( $data['nonce'], 'sogo_login_nonce' ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'No access', 'sogo' ),
			) );
			die();
		}

		// check if google login

		if ( $data['google_login'] == true ) {
			// Automatic login //
			$username = $data['username'];
			$user     = get_user_by( 'login', $username );

			// Redirect URL //
			if ( ! is_wp_error( $user ) ) {
				wp_clear_auth_cookie();
				wp_set_current_user( $user->ID );
				wp_set_auth_cookie( $user->ID );
				echo json_encode( array(
					'error'   => false,
					'message' => __( 'User Login successfully', 'sogo' ),
				) );

			}

		} else {
			// login success - do sign in
			$creds                  = array();
			$creds['user_login']    = $data['username'];
			$creds['user_password'] = $data['password'];
			$creds['remember']      = $data['rememberme'];
			$user                   = wp_signon( $creds, false );
			if ( is_wp_error( $user ) ) {
				echo json_encode( array(
					'error'   => true,
					'message' => $user,
				) );
			} else {
				echo json_encode( array(
					'error'   => false,
					'message' => __( 'User Login successfully', 'sogo' ),
				) );
			}
		}


		die();
	}

	function handle_logout() {
		if ( is_user_logged_in() ) {
			wp_logout();
//			wp_redirect( site_url( '/' ) );
            echo 1;
		}
		die();
	}

	function handle_register() {


		// Login form arguments.
		if ( ! isset( $_POST['data'] ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'Empty values', 'sogo' ),
			) );
			die();
		}
		$data = $_POST['data'];

		$data = wp_parse_args( $data );

//		debug($data['email']);
		if ( ! wp_verify_nonce( $data['nonce'], 'sogo_register_nonce' ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'No access', 'sogo' ),
			) );
			die();
		}

		// if we have user name / email we can continue.
		if ( empty( $data['email'] ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'Email is not valid', 'sogo' ),
			) );
			die();
		}

		$email = $data['email'];

		// if we have user name / email we can continue.
		$username = $email;
		if ( empty( $username ) ) {
			echo json_encode( array(
				'error'   => true,
				'message' => __( 'User name is not valid', 'sogo' ),
			) );
			die();
		}

		$password  = empty( $data['password'] ) ? wp_generate_password( 6, false ) : $data['password'];
		$firstname = empty( $data['first_name'] ) ? '' : $data['first_name'];
		$lastname  = empty( $data['last_name'] ) ? '' : $data['last_name'];

		$user_id = username_exists( $username );

		if ( ! $user_id and email_exists( $email ) == false ) {
			$userdata = array(
				'user_login'   => $username,
				'user_email'   => $email,
				'user_pass'    => $password,
				'first_name'   => $firstname,
				'last_name'    => $lastname,
				'display_name' => $firstname . ' ' . $lastname,

			);
			$user_id  = wp_insert_user( $userdata );

			if ( ! is_wp_error( $user_id ) ) {
				//wp_new_user_notification( $user_id, null, 'both' );
				$user = get_user_by( 'ID', $user_id );

				foreach ( $data['meta'] as $key=>$value ) {
					update_user_meta( $user_id, $key, $value );
				}

				wp_clear_auth_cookie();
				wp_set_current_user( $user_id );
				wp_set_auth_cookie( $user_id );
				sogo_new_user_email( $user, $user->user_login, $password );
				wp_send_json( array(
					'error'   => false,
					'message' => __( 'User Created successfully, Please wait...', 'sogo' ),
					'redirect' => site_url('/' . get_field('_sogo_login_url', 'option'))
				) );
			} else {

				wp_send_json( array(
					'error'   => true,
					'message' => $user_id->get_error_message()
				) );

			}
		} else {
			if ( $data['google_sign_in'] == true ) {
				// Automatic login //

				$user = get_user_by( 'email', $email );

				// Redirect URL //
				if ( ! is_wp_error( $user ) ) {
					wp_clear_auth_cookie();
					wp_set_current_user( $user->ID );
					wp_set_auth_cookie( $user->ID );
					wp_send_json( array(
						'error'   => false,
						'message' => __( 'Login successfully', 'sogo' ),
					) );

				}
			} else {
				wp_send_json( array(
					'error'   => true,
					'message' => __( 'User name / email already exist', 'sogo' ),
				) );
			}

			die();
		}

		die();
	}

	/**
	 * get login form
	 */
	public function get_login_form( $args = array() ) {

		// Login form arguments.
		$defaults = array(
			'echo'           => true,
			'redirect'       => site_url( '/' ),
			'label_username' => __( 'Username', 'sogo' ),
			'label_password' => __( 'Password', 'sogo' ),
			'label_remember' => __( 'Remember Me', 'sogo' ),
			'label_log_in'   => __( 'Sign In', 'sogo' ),
			'remember'       => true,
			'value_username' => null,
			'value_remember' => true,
		);

		$args = wp_parse_args( $args, $defaults );

		?>
        <form id="sogo_login_form" action="" method="post">

            <!--            <p class="login-username">-->
            <!--                <label for="username"> --><?php //echo esc_html($args['label_username'])
			?><!--</label>-->
            <!--                <input type="text" name="username" id="username" class="input"-->
            <!--                       value="--><?php //echo esc_attr($args['value_username'])
			?><!--"/>-->
            <!--            </p>-->
            <div class="form-group input-group">
                <span class="input-group-addon icon-avatar" id="basic-addon1"></span>
                <input type="text" class="form-control required" name="username" id="username"
                       title="<?php echo esc_attr( __( 'Username', 'sogoc' ) ) ?>"
                       placeholder="<?php _e( 'Username', 'sogoc' ) ?>">
            </div>
            <!--            <p class="login-password">-->
            <!--                <label for="password">--><?php //echo esc_html($args['label_password'])
			?><!--</label>-->
            <!--                <input type="password" name="password" id="password" class="input" value=""/>-->
            <!--            </p>-->
            <div class="form-group input-group">
                <span class="input-group-addon icon-lock" id="basic-addon1"></span>
                <input type="password" class="form-control required" name="password" id="password"
                       title="<?php echo esc_attr( __( 'Password', 'sogoc' ) ) ?>"
                       placeholder="<?php _e( 'Password', 'sogoc' ) ?>">
            </div>
            <!--            <p class="login-remember">-->
            <!--                <label>-->
            <!--                    <input name="rememberme"-->
            <!--                           type="checkbox"-->
            <!--                           id="rememberme"-->
            <!--                           value="forever" -->
			<?php //echo($args['value_remember'] ? ' checked="checked"' : '')
			?><!-- />-->
            <!--                    --><?php //echo esc_html($args['label_remember'])
			?>
            <!--                </label>-->
            <!--            </p>-->
            <div class="checkbox-group login-remember">
                <input name="rememberme"
                       type="checkbox"
                       id="rememberme"
                       value="forever" <?php echo( $args['value_remember'] ? ' checked="checked"' : '' ) ?> />
                <label for="rememberme"><?php echo esc_html( $args['label_remember'] ) ?></label>
            </div>
            <a href="<?php echo site_url( '/wp-login.php?action=lostpassword' ) ?>"
               class="forgot-password"><?php _e( 'Forgot Password?', 'sogoc' ) ?></a>
            <p class="login-submit padding-top-md margin-bottom-lg">
                <span class="error"></span>
                <input type="submit" name="wp-submit" id="login_submit" class="btn btn-main"
                       value="<?php echo esc_attr( $args['label_log_in'] ) ?>"/>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( $args['redirect'] ) ?>"/>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'sogo_login_nonce' ); ?>">
            </p>
        </form>
		<?php
	}

	/**
	 * get register form.
	 *
	 * @param array $args
	 */
	public function get_register_form( $args = array() ) {

		// Login form arguments.
		$defaults = array(
			'username'    => true,
			'email'       => true,
			'firstname'   => true,
			'lastname'    => true,
			'password'    => true,
			're-password' => true,
			'tac'         => true,
			'tac_text'    => __( 'I agreed with the terms and conditions of this site', 'sogo' ),
			'before_tac'  => false,
			'google'      => false,

		);

		$args = wp_parse_args( $args, $defaults );

		?>
        <form id="sogo_registration_form" class="sogo_form" action="" method="POST">
            <fieldset>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'sogo_register_nonce' ); ?>">
				<?php if ( $args['username'] ) : ?>
                    <!--					<p>-->
                    <!--						<label for="sogo_user_login">--><?php //_e( 'Username', 'sogo' ); ?><!--</label>-->
                    <!--						<input name="username" id="sogo_user_login" class="required" type="text"/>-->
                    <!--					</p>-->
                    <div class="form-group">

                        <input type="text" class="form-control required" name="username" id="sogo_user_login"
                               title="<?php echo esc_attr( __( 'Username', 'sogoc' ) ) ?>"
                               placeholder="<?php _e( 'Username', 'sogoc' ) ?>">
                    </div>
				<?php endif; ?>
				<?php if ( $args['firstname'] ) : ?>
                    <!--					<p>-->
                    <!--						<label for="sogo_user_first">--><?php //_e( 'First Name', 'sogo' ); ?><!--</label>-->
                    <!--						<input name="firstname" id="sogo_user_first" type="text"/>-->
                    <!--					</p>-->
                    <div class="form-group input-group">
                        <span class="input-group-addon icon-avatar" id="basic-addon1"></span>
                        <input type="text" class="form-control required" name="firstname" id="sogo_user_first"
                               title="<?php echo esc_attr( __( 'First Name', 'sogoc' ) ) ?>"
                               placeholder="<?php _e( 'First Name', 'sogoc' ) ?>">
                    </div>
				<?php endif; ?>
				<?php if ( $args['lastname'] ) : ?>
                    <!--					<p>-->
                    <!--						<label for="sogo_user_last">--><?php //_e( 'Last Name', 'sogo' ); ?><!--</label>-->
                    <!--						<input name="lastname" id="sogo_user_last" type="text"/>-->
                    <!--					</p>-->
                    <div class="form-group input-group">
                        <span class="input-group-addon icon-avatar" id="basic-addon1"></span>
                        <input type="text" class="form-control required" name="lastname" id="sogo_user_last"
                               title="<?php echo esc_attr( __( 'Last Name', 'sogoc' ) ) ?>"
                               placeholder="<?php _e( 'Last Name', 'sogoc' ) ?>">
                    </div>
				<?php endif; ?>
				<?php if ( $args['email'] ) : ?>
                    <!--					<p>-->
                    <!--						<label for="sogo_user_email">--><?php //_e( 'Email', 'sogo' ); ?><!--</label>-->
                    <!--						<input name="email" id="sogo_user_email" class="required" type="email"/>-->
                    <!--					</p>-->
                    <div class="form-group input-group">
                        <span class="input-group-addon icon-mail" id="basic-addon1"></span>
                        <input type="email" class="form-control required" name="email" id="sogo_user_email"
                               title="<?php echo esc_attr( __( 'E-mail', 'sogoc' ) ) ?>"
                               placeholder="<?php _e( 'E-mail', 'sogoc' ) ?>">
                    </div>
				<?php endif; ?>
                <div class="form-group input-group">
                    <span class="input-group-addon icon-phone" id="basic-addon11"></span>
                    <input type="text" class="form-control required" name="user_phone" id="sogo_user_phone"
                           title="<?php echo esc_attr( __( 'Phone', 'sogoc' ) ) ?>"
                           placeholder="<?php _e( 'Phone', 'sogoc' ) ?>">
                </div>
				<?php if ( $args['password'] ) : ?>
                    <p>
                        <label for="password"><?php _e( 'Password', 'sogo' ); ?></label>
                        <input name="password" id="password" class="required" type="password"/>
                    </p>
				<?php endif; ?>
				<?php if ( $args['re-password'] ) : ?>
                    <p>
                        <label for="password_again"><?php _e( 'Password Again', 'sogo' ); ?></label>
                        <input name="confirm_password" id="password_again" class="required" type="password"/>
                    </p>
				<?php endif; ?>
				<?php if ( $args['before_tac'] ) : ?>
                    <p>
						<?php echo $args['before_tac'] ?>
                    </p>
				<?php endif; ?>
                <p class="padding-y-sm black">
					<?php echo sogo_option( 'register_agree_text' ) ?>
                </p>
				<?php if ( $args['tac'] ) : ?>
                    <!--					<p>-->
                    <!--						<label for="tac">--><?php //echo $args['tac_text'] ?><!--</label>-->
                    <!--						<input name="tac" id="tac" class="required" type="checkbox"/>-->
                    <!--					</p>-->
                    <div class="checkbox-group">
                        <input name="tac" id="tac" class="required" type="checkbox"/>
                        <label for="tac"><?php echo $args['tac_text'] ?></label>
                    </div>
				<?php endif; ?>
                <p class="padding-top-md">
                    <span class="error"></span>
                    <input type="submit" class="btn btn-main" value="<?php _e( 'Register', 'sogo' ); ?>"/>
                </p>
            </fieldset>
        </form>

        <script>
            var googleUser = {};
            // do google login
            var startApp = function () {
                gapi.load('auth2', function () {
                    // Retrieve the singleton for the GoogleAuth library and set up the client.
                    auth2 = gapi.auth2.init({
                        client_id: '820525119567-6tvqadlg87q2s49d6ucc3019g4ona30c.apps.googleusercontent.com',
                        //    cookiepolicy: 'single_host_origin',
                        // Request scopes in addition to 'profile' and 'email'
                        //scope: 'additional_scope'
                    });
                    attachSignin(document.getElementById('customBtn'));
                });
            };

            function attachSignin(element) {
                console.log(element.id);
                console.log(jQuery('.nonce').val());
                auth2.attachClickHandler(element, {},
                    function (googleUser) {
                        var f = jQuery('#sogo_registration_form');
                        var profile = googleUser.getBasicProfile();
                        var data = {
                            'action': 'sogo_register',
                            'data': {
                                'firstname': profile.getGivenName(),
                                'lastname': profile.getFamilyName(),
                                'email': profile.getEmail(),
                                'google_sign_in': true,
                                'nonce': f.find('input[name="nonce"]').val(),

                            }
                        };
                        jQuery.ajax({
                            type: "post",
                            dataType: "json",
                            url: sogo.ajaxurl,
                            data: data,
                            success: function (response) {
                                console.log(response);
                                if (!response.error) {

                                    location.reload();
                                }
                                else {
                                    f.find('.error').html(response.message);
                                }
                            }
                        });
                        document.getElementById('name').innerText = "Signed in: " +
                            googleUser.getBasicProfile().getName();
                    }, function (error) {
                        alert(JSON.stringify(error, undefined, 2));
                    });
            }
        </script>
        <div id="gRegisterWrapper">
            <div id="customBtn" class="customGPlusSignIn btn btn-main btn-gmail margin-top-lg">
                <span class="icon icon-mail"></span>
                <span class="buttonText">Gmail</span>
            </div>
        </div>
        <div id="name"></div>
        <script>startApp();</script>

        <div class="business-register text-center margin-top-lg padding-top-md">
            <p class="business-title padding-bottom-lg"><?php _e( 'Want to Join as a Business?', 'sogo' ); ?></p>
            <a href="<?php echo get_permalink( sogo_option( 'contact_page' ) ); ?>" class="btn btn-main"
               title="<?php esc_attr_e( 'Register for a business account', 'sogoc' ) ?>"><?php _e( 'Register for a business account', 'sogo' ); ?></a>
        </div>
		<?php
	}
}

//new Login();
