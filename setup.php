<?php

function plugin_init_knowbasefilter() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['menu_items']['knowbasefilter'] = 'PluginKnowbasefilterMenu';
}

function plugin_version_knowbasefilter() {
    return [
        'name'           => 'Knowbase Filter',
        'version'        => '1.0.1',
        'author'         => 'Arnold Bonnemaison',
        'license'        => 'GPLv3+',
        'homepage'       => '',
        'minGlpiVersion' => '10.0.0'
    ];
}

function plugin_knowbasefilter_check_prerequisites() {
    return true;
}

function plugin_knowbasefilter_check_config() {
    return true;
}

function plugin_knowbasefilter_install() {
    return true;
}

function plugin_knowbasefilter_uninstall() {
    return true;
}


