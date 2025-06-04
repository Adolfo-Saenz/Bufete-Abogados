<?php

use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
    ->withProviders([
        App\Providers\ThemeServiceProvider::class,
    ])
    ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


add_action('init', function () {
  if (!isset($_POST['custom_register'])) return;

  $first = sanitize_text_field($_POST['first_name']);
  $last = sanitize_text_field($_POST['last_name']);
  $email = sanitize_email($_POST['email']);
  $pass = $_POST['password'];

  $username = sanitize_user(strtolower($first . '-' . $last));
  if (username_exists($username) || email_exists($email)) {
    wp_die('El usuario o email ya existe');
  }

  $user_id = wp_create_user($username, $pass, $email);
  if (is_wp_error($user_id)) {
    wp_die('Error al crear usuario');
  }

  // Meta estándar
  wp_update_user([
    'ID' => $user_id,
    'first_name' => $first,
    'last_name'  => $last,
  ]);

  // ACF fields (debes tener ACF instalado)
  update_field('tlf', sanitize_text_field($_POST['tlf']), 'user_' . $user_id);
  update_field('country', sanitize_text_field($_POST['country']), 'user_' . $user_id);
  update_field('city', sanitize_text_field($_POST['city']), 'user_' . $user_id);

  // Subir imagen
  if (!empty($_FILES['profile_image']['name'])) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $uploaded = media_handle_upload('profile_image', 0);
    if (!is_wp_error($uploaded)) {
      update_field('profile-image', $uploaded, 'user_' . $user_id);
    }
  }

  // Login automático tras registro
  wp_set_current_user($user_id);
  wp_set_auth_cookie($user_id);
  wp_redirect(home_url());
  exit;
});

function redirect_wp_login_page_alternative() {
    $login_page = home_url('/formulario-de-registro/');
    $request_uri = $_SERVER['REQUEST_URI'];

    // Si es wp-login.php pero NO contiene action=logout, action=lostpassword, etc.
    if (strpos($request_uri, 'wp-login.php') !== false && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        // Permitir logout, lostpassword, resetpass, register, etc. sin redirigir
        $allowed_actions = ['logout', 'lostpassword', 'resetpass', 'rp', 'register'];

        if (!in_array($action, $allowed_actions)) {
            wp_redirect($login_page);
            exit;
        }
    }
}
add_action('login_init', 'redirect_wp_login_page_alternative');