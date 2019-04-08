<?php
$IBLOCK_ID = 17;
$DETAIL_PAGE_SHOW_ENABLED = 'Y';
$LIST_PAGE_SHOW_ENABLED = 'Y';
\Bitrix\Main\Loader::includeMOdule('iblock');
$featureId = 'DETAIL_PAGE_SHOW';
$dbData = \Bitrix\Iblock\PropertyFeatureTable::getList([
    'select' => array('ID', 'PROPERTY_ID', 'IS_ENABLED', 'FEATURE_ID')
]);
$all_property_value = $dbData->fetchAll();//Все сохранённые значения свойств

foreach ($all_property_value as $item) {
    if ($item['FEATURE_ID'] == 'DETAIL_PAGE_SHOW') {
        $DETAIL_PAGE_SHOW[$item['PROPERTY_ID']] = $item;
    } elseif ($item['FEATURE_ID'] == 'LIST_PAGE_SHOW') {
        $LIST_PAGE_SHOW[$item['PROPERTY_ID']] = $item;
    }
}

if (CModule::IncludeModule("iblock")) { //получаем все свойства инфоблока
    $properties = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
    $arrIdProp = array();
    while ($prop_fields = $properties->GetNext()) {
        $arrIdProp[] = $prop_fields["ID"];
    }
}

foreach ($arrIdProp as $item) {
    if ($DETAIL_PAGE_SHOW_ENABLED == 'Y') { //если требуется всем свойствам добавить отображение на детальной странице
        if (!empty($DETAIL_PAGE_SHOW[$item])) { // проверяем есть ли уже свойство в базе
            if ($DETAIL_PAGE_SHOW[$item]['IS_ENABLED'] == 'N') { //Если оно отрицательное то изменяем его
                \Bitrix\Iblock\PropertyFeatureTable::Update($DETAIL_PAGE_SHOW[$item]['ID'], [
                    'PROPERTY_ID' => $item,
                    'MODULE_ID' => 'iblock',
                    'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                    'IS_ENABLED' => 'Y'
                ]);
            }
        } else {
            \Bitrix\Iblock\PropertyFeatureTable::Add([
                'PROPERTY_ID' => $item,
                'MODULE_ID' => 'iblock',
                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                'IS_ENABLED' => 'Y'
            ]);
        }
    } elseif ($DETAIL_PAGE_SHOW_ENABLED == 'N') {
        if (!empty($DETAIL_PAGE_SHOW[$item])) {
            if ($DETAIL_PAGE_SHOW[$item]['IS_ENABLED'] == 'Y') {
                \Bitrix\Iblock\PropertyFeatureTable::Update($DETAIL_PAGE_SHOW[$item]['ID'], [
                    'PROPERTY_ID' => $item,
                    'MODULE_ID' => 'iblock',
                    'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                    'IS_ENABLED' => 'N'
                ]);
            }
        } else {
            \Bitrix\Iblock\PropertyFeatureTable::Add([
                'PROPERTY_ID' => $item,
                'MODULE_ID' => 'iblock',
                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                'IS_ENABLED' => 'N'
            ]);
        }
    }
    if ($LIST_PAGE_SHOW_ENABLED == 'Y') {
        if (!empty($LIST_PAGE_SHOW[$item])) {
            if ($LIST_PAGE_SHOW[$item]['IS_ENABLED'] == 'N') {
                \Bitrix\Iblock\PropertyFeatureTable::Update($LIST_PAGE_SHOW[$item]['ID'], [
                    'PROPERTY_ID' => $item,
                    'MODULE_ID' => 'iblock',
                    'FEATURE_ID' => 'LIST_PAGE_SHOW',
                    'IS_ENABLED' => 'Y'
                ]);
            }
        } else {
            \Bitrix\Iblock\PropertyFeatureTable::Add([
                'PROPERTY_ID' => $item,
                'MODULE_ID' => 'iblock',
                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                'IS_ENABLED' => 'Y'
            ]);
        }
    } elseif ($LIST_PAGE_SHOW_ENABLED == 'N') {
        if (!empty($LIST_PAGE_SHOW[$item])) {
            if ($LIST_PAGE_SHOW[$item]['IS_ENABLED'] == 'Y') {
                \Bitrix\Iblock\PropertyFeatureTable::Update($LIST_PAGE_SHOW[$item]['ID'], [
                    'PROPERTY_ID' => $item,
                    'MODULE_ID' => 'iblock',
                    'FEATURE_ID' => 'LIST_PAGE_SHOW',
                    'IS_ENABLED' => 'N'
                ]);
            }
        } else {
             \Bitrix\Iblock\PropertyFeatureTable::Add([
                'PROPERTY_ID' => $item,
                'MODULE_ID' => 'iblock',
                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                'IS_ENABLED' => 'N'
            ]);
        }
    }
}