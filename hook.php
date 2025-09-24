<?php

function PluginKnowbasefilterMenu() {
    global $MENU;

    $MENU['tools'][__('Filtrage Base de Connaissances', 'knowbasefilter')] = '/plugins/knowbasefilter/front/filterinterface.php';
}

