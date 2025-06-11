<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Admin</b> ',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-secondary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => true,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
        'type' => 'navbar-search',
        'text' => 'Busqueda',          // Placeholder for the underlying input.
        'topnav_right' => true,      // Or "topnav => true" to place on the left.
        'url' => 'navbar/search',    // The url used to submit the data ('#' by default).
        'method' => 'post',          // 'get' or 'post' ('get' by default).
        'input_name' => 'searchVal', // Name for the underlying input ('adminlteSearch' by default).
        'id' => 'navbarSearch'       // ID attribute for the underlying input (optional).

        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

            [
            'type' => 'navbar-notification',
            'id' => 'my-notification',
            'icon' => 'fas fa-bell',
            'url' => 'notifications/show',
            'topnav_right' => true,
            'dropdown_mode' => true,
            'dropdown_flabel' => 'All notifications',
            'update_cfg' => [
            'url' => 'notifications/get',
            'period' => 30,
            ],
        ],

        [

            'text'=>'Cambiar Clave',
            'url'  => 'admin/password',// puede ir route tambien
            'topnav_user'=>true,
        ],

        
        [

            'text'=>'link 2',
            'url'=>'#', // puede ir route tambien
            'topnav'=>true,
        ],
        [
            'type' => 'darkmode-widget',
            'topnav_right' => true,     // Or "topnav => true" to place on the left.
        ],
        [
        'type' => 'sidebar-menu-search',
        'text' => 'Buscar en Menu',             // Placeholder for the underlying input.
        'id' => 'sidebarMenuSearch'     // ID attribute for the underlying input (optional).
        ],
        [

            'text'=>'Inicio',
            'url'=>'dashboard', // puede ir route tambien
            'icon'=>'fas fa-fw fa-home',
            'label' =>'Nuevo',
            'label_color'=>'danger',
            'icon_color'=>'green'
        ],



        // Sidebar items:
        //[
        //    'type' => 'sidebar-menu-search',
        //    'text' => 'search',
        //],
        [
            'text' => 'blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',
        ],
     //   [
     //       'text' => 'Paginas',
     //       'url' => 'admin/pages',
     //       'icon' => 'far fa-fw fa-file',
     //       'label' => 4,
     //       'label_color' => 'success',
     //   ],
    //    ['header' => 'CONFIGURACIÓN DE CUENTA'],
        [

            'text' => 'Perfil de usuario',
            'icon' => 'fas fa-fw fa-user',
            'url' => '#',
            'submenu' => [
                 [
            'text' => 'Perfil',
            'url' => '/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Cambiar clave',
            'url'  => 'admin/password',
            'icon' => 'fas fa-fw fa-lock'],
               
            ],
        ],
  //      ['header' => 'PNF: CARRERAS'],
  //      [
  //          'text' => 'Lista de Carreras',
  //          'route' => 'carreras.index',
  //          'icon' => 'far fa-fw fa-file',
  //      ],
  //      [
  //          'text' => 'Agregar Carrera',
  //          'url' => 'admin/carreras/create',
  //          'icon' => 'fas fa-fw fa-file',
  //      ],

                          [
            'text' => 'Areas administrativas',
            'icon' => 'fas fa-fw  fa-building',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista',
                  // 'route' => 'programas.index',
                    'url' => 'admin/areasadmin/create',

                ],
                [
                    'text' => 'Agregar Area',
                    'url' => 'admin/areasadmin/create',
                ],

               
            ],
        ],

      [
            'text' => 'Matricula',
            'icon' => 'fas fa-fw  fa-graduation-cap',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Inscripciones PIU',
                  // 'route' => 'programas.index',
                    'url' => 'admin/programas/create',

                ],
                [
                    'text' => 'Inscripciones PNF',
                    'url' => 'admin/programas/create',
                ],
                                [
                    'text' => 'Inscripciones PER',
                    'url' => 'admin/programas/create',
                ],
                 [
                    'text' => 'Profesores',
                    'url' => 'admin/programas/create',
                ],
                 [
                    'text' => 'Analistas',
                    'url' => 'admin/programas/create',
                ],
               
            ],
        ],

        ['header' => 'GESTIÓN ADMINISTRATIVA'],
                [
            'text' => 'Programas',
            'icon' => 'fas fa-fw fa-university',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Programas',
                  // 'route' => 'programas.index',
                   'route' => 'programas.index',

                ],
                [
                    'text' => 'Agregar Programa',
                    'route' => 'programas.create',
                ],
               
            ],
        ],



        [
            'text' => 'Mallas',
            'icon' => 'fas fa-fw fa-book',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista',
                  // 'route' => 'programas.index',
                    'route' => 'mallas-curriculares.index',

                ],
                [
                    'text' => 'Agregar ',
                    'url' => 'admin/mallas-curriculares/create',
                    'route' => 'mallas-curriculares.create',
                ],

               
            ],
        ],

        [
            'text' => 'Trayectos',
            'icon' => 'fas fa-fw  fa-flag',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista',
                  // 'route' => 'programas.index',
                    'route' => 'trayectos.index',

                ],
                [
                    'text' => 'Agregar ',
                    'url' => 'admin/trayectos/create',
                ],
               
            ],
        ],

                                        [
            'text' => 'Fases',
            'icon' => 'fas fa-fw fa-hourglass',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista',
                  // 'route' => 'programas.index',
                    'url' => 'admin/fases/create',

                ],
                [
                    'text' => 'Agregar ',
                    'url' => 'admin/fases/create',
                ],
               
            ],
        ],

                [
            'text' => 'Especialidades',
            'icon' => 'fas fa-fw fa-trophy',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Especialidades',
                   'route' => 'especialidades.index',
                ],
                [
                    'text' => 'Agregar Especialidad',
                    'url' => 'admin/especialidades/create',
                ],
                [
                    'text' => 'Detalles Contaduria Pública',
                    'url' => 'admin/especialidades/1',
                ],
                 [
                    'text' => 'Detalles Administración',
                    'url' => 'admin/especialidades/2',
                ],
                 [
                    'text' => 'Detalles Ingenieria Electrica',
                    'url' => 'admin/especialidades/3',
                ],
                 [
                    'text' => 'Detalles Ingenieria de Mantenimiento',
                    'url' => 'admin/especialidades/3',
                ],
               
            ],
        ],

                [
            'text' => 'Titulos',
            'icon' => 'fas fa-fw fa-trophy',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Titulos',
                   'route' => 'titulos.index',
                ],
                [
                    'text' => 'Agregar titulos',
                    'url' => 'admin/titulos/create',
                ],
               
            ],
        ],

                [
            'text' => 'Unidad Curricular',
            'icon' => 'fas fa-fw fa-folder-open',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Unidades',
                   'route' => 'unidades-curriculares.index',
                ],
                [
                    'text' => 'Agregar',
                    'url' => 'admin/trayectos/create',
                ],
               
            ],
        ],

                        [
            'text' => 'Prelaciones',
            'icon' => 'fas fa-fw  fa-backward',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Prelaciones',
                   'url' => 'admin/prelaciones/create',
                ],
                [
                    'text' => 'Agregar',
                    'url' => 'admin/prelaciones/create',
                ],
               
            ],
        ],

            [
            'text' => 'Horarios',
            'icon' => 'fas fa-fw fa-calendar',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Horarios',
                   'url' => 'admin/horarios/create',
                ],
                [
                    'text' => 'Agregar Horario',
                    'url' => 'admin/horarios/create',
                ],
               
            ],
        ],

    

                [
            'text' => 'EVALUACIONES',
            'icon' => 'fas fa-fw fa-university',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Evaluaciones PIU',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                [
                    'text' => 'Evaluaciones PNF',
                    'url' => 'admin/evaluaciones/create',
                ],
               
            ],
        ],

            ['header' => 'DOCUMENTOS ADMINISTRATIVOS'],
                [
            'text' => 'Estudiantes Regulares',
            'icon' => 'fas fa-fw  fa-university',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Historial Académico',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Constancia de Estudios',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Carga Horaria',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Credencial de Biblioteca',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Carta de Culminación',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                  [
                    'text' => 'Certificación de Códigos',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                [
                    'text' => 'Retiro Definitivo',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                [
                    'text' => 'Retiro Provisional',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Solicitud de Reingreso',
                    'url' => 'admin/evaluaciones/create',
                ],
                  [
                    'text' => 'Solicitud de Traslado',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Solicitud de Equivalencia',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Proceso para TSU (Prosecución)',
                    'url' => 'admin/evaluaciones/create',
                ],
                [
                    'text' => 'Cambio de Carrera',
                    'url' => 'admin/evaluaciones/create',
                ],
            ],
        ],
            [
            'text' => 'Egresados',
            'icon' => 'fas fa-fw  fa-university',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Paquete para apostillar',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Autenticación de Titulo Fondo Negro',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Autenticación de Notas Certificadas',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Credencial de Biblioteca',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                 [
                    'text' => 'Certificación de actas de Grado',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                  [
                    'text' => 'CAutenticación de Certificación de Mención Honorifica',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                [
                    'text' => 'Certificación de Pensum y Malla',
                  // 'route' => 'programas.index',
                    'url' => 'admin/evaluaciones/create',

                ],
                [
                    'text' => 'Notas Ceritificadas',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Constancia de Posición de Grado',
                    'url' => 'admin/evaluaciones/create',
                ],
                  [
                    'text' => 'Constancia de Posición y Rango',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Solicitud de Equivalencia',
                    'url' => 'admin/evaluaciones/create',
                ],
                 [
                    'text' => 'Proceso para TSU (Prosecución)',
                    'url' => 'admin/evaluaciones/create',
                ],
                [
                    'text' => 'Cambio de Carrera',
                    'url' => 'admin/evaluaciones/create',
                ],
            ],
        ],

        ['header' => 'GESTION DE GRADO'],
        [
            'text' => 'Listado de Graduandos',
            'icon' => 'fas fa-fw fa-graduation-cap',
            'url' => '#',
        ],
             
    ['header' => 'GESTIÓN DE USUARIOS'],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'url' => '#',
            'submenu' => [
                 [
                    'text' => 'Lista de Usuarios',
                    'route' => 'asignar.index',
                ],
                [
                    'text' => 'Roles',
                    //'url' => 'admin/users/roles',
                    'route' => 'roles.index',
                ],
                [
                    'text' => 'Permisos',
                    'url' => 'admin/users/permisos',
                    //'route' => 'permisos.index',
                  
                ],
               
            ],
        ],
        ['header' => 'MENU 2'],
        [
            'text' => 'Importante',
            'icon_color' => 'red',
            'url' => '#',
        ],
        [
            'text' => 'Alerta',
            'icon_color' => 'yellow',
            'url' => '#',
        ],
        [
            'text' => 'Información',
            'icon_color' => 'cyan',
            'url' => '#',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
