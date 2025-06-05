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

if (defined('WP_DEBUG') && WP_DEBUG) {
    add_action('after_setup_theme', function () {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    });
}

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


// Modificar los roles de perfil.
function custom_user_roles_setup() {
    // Eliminar roles
    remove_role('subscriber');
    remove_role('contributor');
    remove_role('author');
    remove_role('editor');

    // Agrega "Cliente"
    add_role(
        'cliente',
        'Cliente',
        [
            'read' => true,
        ]
    );

    // Agrega "Abogado"
    add_role(
        'abogado',
        'Abogado',
        [
            'read' => true,
            'edit_posts' => true,
        ]
    );
}
add_action('init', 'custom_user_roles_setup');

//CPT de casos
function registrar_cpt_casos() {
    $labels = array(
        'name'                  => 'Casos',
        'singular_name'         => 'Caso',
        'menu_name'             => 'Casos',
        'name_admin_bar'        => 'Caso',
        'add_new'               => 'Añadir nuevo',
        'add_new_item'          => 'Añadir nuevo caso',
        'new_item'              => 'Nuevo caso',
        'edit_item'             => 'Editar caso',
        'view_item'             => 'Ver caso',
        'all_items'             => 'Todos los casos',
        'search_items'          => 'Buscar casos',
        'not_found'             => 'No se encontraron casos.',
        'not_found_in_trash'    => 'No hay casos en la papelera.',
        'archives'              => 'Archivo de casos',
        'insert_into_item'      => 'Insertar en caso',
        'uploaded_to_this_item' => 'Subido a este caso',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_menu'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'author', 'custom-fields'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'casos'),
        'capability_type'    => 'post',
        'show_in_rest'       => true,
    );

    register_post_type('caso', $args);

    register_post_type('evento', [
        'labels' => ['name' => 'Eventos'],
        'public' => true,
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'registrar_cpt_casos');

function columnas_personalizadas_casos($columns) {
    $nuevas_columnas = [];

    $nuevas_columnas['cb'] = $columns['cb'];
    $nuevas_columnas['title'] = $columns['title'];
    $nuevas_columnas['acf_desc'] = 'Descripción';
    $nuevas_columnas['acf_client'] = 'Cliente';
    $nuevas_columnas['acf_lawyers'] = 'Abogados';

    foreach ($columns as $key => $value) {
        if (!isset($nuevas_columnas[$key])) {
            $nuevas_columnas[$key] = $value;
        }
    }

    return $nuevas_columnas;
}
add_filter('manage_caso_posts_columns', 'columnas_personalizadas_casos');

function contenido_columna_personalizada_casos($column, $post_id) {
    if ($column === 'acf_desc') {
        $desc = get_field('desc', $post_id);
        echo $desc ? esc_html($desc) : '—';
    }

    if ($column === 'acf_client') {
        $client_id = get_field('client', $post_id);
        if ($client_id) {
            $user = get_userdata($client_id);
            echo $user ? esc_html($user->display_name) : '[Usuario no encontrado]';
        } else {
            echo '—';
        }
    }

    if ($column === 'acf_lawyers') {
        if (have_rows('lawyers', $post_id)) {
            $nombres = [];

            while (have_rows('lawyers', $post_id)) {
                the_row();
                $lawyer_id = get_sub_field('lawyer');

                if ($lawyer_id) {
                    $user = get_userdata($lawyer_id);
                    $nombres[] = $user ? $user->display_name : '[Desconocido]';
                }
            }

            echo !empty($nombres) ? esc_html(implode(', ', $nombres)) : '—';
        } else {
            echo '—';
        }
    }
}
add_action('manage_caso_posts_custom_column', 'contenido_columna_personalizada_casos', 10, 2);


// Mostrar filtros en la tabla de administración de "casos"
function filtros_por_cliente_y_abogado_en_casos($post_type) {
    if ($post_type !== 'caso') {
        return;
    }

    // Filtro de clientes
    $clientes = get_users(['role__in' => ['cliente', 'subscriber'], 'orderby' => 'display_name']);
    echo '<select name="filtro_cliente">';
    echo '<option value="">Todos los clientes</option>';
    foreach ($clientes as $cliente) {
        $selected = isset($_GET['filtro_cliente']) && $_GET['filtro_cliente'] == $cliente->ID ? 'selected' : '';
        echo '<option value="' . esc_attr($cliente->ID) . '" ' . $selected . '>' . esc_html($cliente->display_name) . '</option>';
    }
    echo '</select>';

    // Filtro de abogados
    $abogados = get_users(['role__in' => ['abogado', 'editor', 'administrator'], 'orderby' => 'display_name']);
    echo '<select name="filtro_abogado">';
    echo '<option value="">Todos los abogados</option>';
    foreach ($abogados as $abogado) {
        $selected = isset($_GET['filtro_abogado']) && $_GET['filtro_abogado'] == $abogado->ID ? 'selected' : '';
        echo '<option value="' . esc_attr($abogado->ID) . '" ' . $selected . '>' . esc_html($abogado->display_name) . '</option>';
    }
    echo '</select>';
}
add_action('restrict_manage_posts', 'filtros_por_cliente_y_abogado_en_casos');

// Aplicar filtro por cliente
function filtrar_casos_por_cliente($query) {
    global $pagenow;

    if (
        is_admin() &&
        $pagenow === 'edit.php' &&
        isset($_GET['post_type']) && $_GET['post_type'] === 'caso' &&
        $query->is_main_query()
    ) {
        if (!empty($_GET['filtro_cliente'])) {
            $cliente_id = intval($_GET['filtro_cliente']);
            $query->set('meta_query', [[
                'key' => 'client',
                'value' => $cliente_id,
                'compare' => '='
            ]]);
        }
    }
}
add_action('pre_get_posts', 'filtrar_casos_por_cliente');

// Aplicar filtro por abogado dentro de repetidor (con SQL personalizado)
function filtrar_por_abogado_en_repetidor($where, $query) {
    global $wpdb;

    if (
        is_admin() &&
        $query->is_main_query() &&
        isset($_GET['post_type']) && $_GET['post_type'] === 'caso' &&
        !empty($_GET['filtro_abogado'])
    ) {
        $abogado_id = intval($_GET['filtro_abogado']);
        // Asegura que la tabla postmeta esté correctamente unida
        $where .= $wpdb->prepare(
            " AND EXISTS (
                SELECT 1 FROM {$wpdb->postmeta} pm
                WHERE pm.post_id = {$wpdb->posts}.ID
                AND pm.meta_key LIKE %s
                AND pm.meta_value = %d
            )",
            'lawyers_%_lawyer',
            $abogado_id
        );
    }

    return $where;
}
add_filter('posts_where', 'filtrar_por_abogado_en_repetidor', 10, 2);