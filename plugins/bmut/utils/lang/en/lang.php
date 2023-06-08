<?php return [
    'plugin' => [
        'name' => 'Utils',
        'description' => 'Utils',
    ],
    'fields' => [
        'page' => 'Page',
        'select_page' => 'Select page',
        'title' => 'Title',
        'description' => 'Description',
        'keywords' => 'Keywords',
        'og_title' => 'og:title',
        'og_description' => 'og:description',
        'seoImage' => 'og:image',
        'robots' => 'Robots.txt',
        'sitemap' => 'Sitemap.xml',
        'name' => 'Name',
        'is_active' => 'Active',
        'order' => 'Order',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'script' => 'Script',
        'noscript' => 'NoScript',
        'parent_page' => 'Parent Page',
        'dom_element' => 'Page Element',
        'image' => 'Image',
        'subtitle' => 'Subtitle',
        'index' => 'Index',
        'follow' => 'Follow',
        'theme' => 'Tema',
        'type' => 'Type',
        'changeFreq' => 'ChangeFreq',
        'priority' => 'Priority',
        'detect_browser_language' => 'Detect browser language',
        'prefer_user_session' => 'Prefer user session language',
        'is_expired' => 'Expired',
        'expires_at' => 'Expires at',
        'structured_data' => 'Structured Data',
        'blog_richeditor' => 'Blog richeditor'
    ],
    'permissions' => [
        'utils' => 'Utils',
        'seo' => 'Seo',
        'config' => 'Configuration',
        'scripts' => 'Scripts',
        'page' => 'Page Content',
        'manage' => 'Manage',
    ],
    'menu' => [
        'seo' => 'Seo',
        'settings' => 'Settings',
        'scripts' => 'Scripts',
        'headers' => 'Headers',
        'breadcrumbs' => 'Breadcrumbs',
        'sitemap' => 'Sitemap',
    ],
    'tabs' => [
        'seo' => 'Seo',
        'robots' => 'Robots',
        'multilanguage' => 'Multilanguage',
        'blog' => 'Blog'
    ],
    'comments' => [
        'dom_element' => 'Identificador de donde copiar el título en páginas dinámicas',
    ],
    'options' => [
        'select_page' => 'Select Page',
        'select_type' => 'Select Type',
    ],
    'controller' => [
        'behavior_sortable_relations_controller' => 'Sortable Relations controller behavior',
        'behavior_sortable_relations_controller_description' => 'Manage the sort order of model relations directly in the view list of the relation controller.',
        'property_behavior_sortable_relations_parent_class' => 'Parent model class',
        'property_behavior_sortable_relations_parent_class_description' => 'A model class name, the parent model that holds the relations on the form.',
        'property_behavior_sortable_relations_parent_class_placeholder' => '--select model--',
        'property_behavior_sortable_relations_parent_class_required' => 'Please select a model class',
    ],
    'common' => [
        'reorder' => 'Reorder',
    ],
];
