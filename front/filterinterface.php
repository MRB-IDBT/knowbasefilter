<?php

include('../../../inc/includes.php');

use Glpi\Display\Html;

Html::header(__('Filtrage Base de Connaissances', 'knowbasefilter'), $_SERVER['PHP_SELF']);

// Pas de vérification CSRF car uniquement GET

echo "<h2>" . __('Filtrer les articles de la base de connaissances', 'knowbasefilter') . "</h2>";

// Récupération des filtres en GET
$group = $_GET['group'] ?? '';
$profile = $_GET['profile'] ?? '';
$faq = isset($_GET['faq']) ? 1 : 0;

echo "<form method='GET'>";

// On ne met pas de token CSRF car formulaire GET
echo __('Groupe', 'knowbasefilter') . " : <input type='text' name='group' value='" . Html::cleanInputText($group) . "'><br>";
echo __('Profil', 'knowbasefilter') . " : <input type='text' name='profile' value='" . Html::cleanInputText($profile) . "'><br>";
echo __('FAQ seulement ?', 'knowbasefilter') . " <input type='checkbox' name='faq' value='1' " . ($faq ? 'checked' : '') . "><br>";
echo "<input type='submit' value='" . __('Filtrer', 'knowbasefilter') . "'>";
echo "</form>";

global $DB;

$where = [];

if ($faq) {
    $where[] = "kbi.is_faq = 1";
}

if ($group !== '') {
    $group_esc = $DB->escape($group);
    $where[] = "g.name LIKE '%$group_esc%'";
}

if ($profile !== '') {
    $profile_esc = $DB->escape($profile);
    $where[] = "p.name LIKE '%$profile_esc%'";
}

$sql = "
    SELECT DISTINCT kbi.id, kbi.name, kbi.answer, kbi.date_mod, kbi.is_faq
    FROM glpi_knowbaseitems kbi
    LEFT JOIN glpi_groups_knowbaseitems gkbi ON kbi.id = gkbi.knowbaseitems_id
    LEFT JOIN glpi_groups g ON g.id = gkbi.groups_id
    LEFT JOIN glpi_profiles_users pu ON pu.users_id = kbi.users_id
    LEFT JOIN glpi_profiles p ON p.id = pu.profiles_id
";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY kbi.date_mod DESC";

$res = $DB->query($sql);

echo "<table class='tab_cadre_fixe'>";
echo "<tr><th>" . __('ID', 'knowbasefilter') . "</th><th>" . __('Titre', 'knowbasefilter') . "</th><th>" . __('FAQ', 'knowbasefilter') . "</th><th>" . __('Date', 'knowbasefilter') . "</th></tr>";

while ($row = $DB->fetch_assoc($res)) {
    echo "<tr>
        <td>" . Html::encode($row['id']) . "</td>
        <td>" . Html::encode($row['name']) . "</td>
        <td>" . ($row['is_faq'] ? __('Oui', 'knowbasefilter') : __('Non', 'knowbasefilter')) . "</td>
        <td>" . Html::encode($row['date_mod']) . "</td>
    </tr>";
}

echo "</table>";

Html::footer();

