<?php

namespace VadimRomanov\Migrations;


use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Main\SystemException;
use VadimRomanov\Tools;

class IBlockMigration
{

    protected function addIblock($typeCode, $code, $name)
    {
        $result = [];
        try {
            $ib = new \CIBlock;
            $arFields = array(
                "ACTIVE" => 'Y',
                "NAME" => !empty($name) ? $name : $code,
                "CODE" => $code,
                "API_CODE" => str_replace('_', '', $code),
                "IBLOCK_TYPE_ID" => $typeCode,
                "SITE_ID" => array("s1"),

            );
            $res = $ib->Add($arFields);
            if ($res) {
                $result['STATUS'] = 'success';
                $result['IBLOCK']['ID'] = $res;
            } else {
                $result['STATUS'] = 'fail';
                $result['ERROR'] = 'Не удалось добавить инфоблок';
            }
            return $result;

        } catch (\Exception) {
            $result['ERROR'] = 'Ошибка: ' . $ib->LAST_ERROR . '<br>';
            return $result;
        }
    }

    public function findTypeIblock($typeCode)
    {


        $result = \Bitrix\Iblock\TypeTable::getList([
            'select' => [
                'ID',
            ],
            'filter' => ['=ID' => $typeCode],
        ])->fetchAll();
        return array_shift($result);

    }

    public function addTypeIblock($typeCode)
    {
        $result = [
            'status' => false,
            'error' => false
        ];

        $arFields = array(
            'ID' => $typeCode['ID'],
            'SECTIONS' => 'N',
            'IN_RSS' => 'N',
            'SORT' => 100,
            'LANG' => array(
                'ru' => array(
                    'NAME' => $typeCode['NAME'],
                )
            )
        );

        $obBlocktype = new \CIBlockType;

        try {
            $res = $obBlocktype->Add($arFields);
            if ($res) {
                $result['STATUS'] = 'success';
                $result['IBLOCK_TYPE'] = $res;
            }
            return $result;
        } catch (\Exception) {
            $result['ERROR'] = 'Error: ' . $obBlocktype->LAST_ERROR . '<br>';
            return $result;
        }
    }

    protected function findIblock($typeCode, $code)
    {
        $arIblock = \CIBlock::GetList(
            array(),
            array(
                'TYPE' => $typeCode,
                //'SITE_ID' => SITE_ID,
                'CODE' => $code,
                'CHECK_PERMISSIONS' => 'N'
            )
        )->fetch();
        if (!empty($arIblock)) {
            return $arIblock['ID'];
        } else {
            return false;
        }
    }


    protected function updateFields($IBlockId, $iblockDefaultFields)
    {
        $sort = 10;
        foreach ($iblockDefaultFields as $fieldName => $fieldValue) {
            $caption = $fieldValue[0] ?? $fieldName;
            if (!empty($fieldValue[1])) {
                $listField = new \CListElementField($IBlockId, $fieldName, $caption, $sort);

                $addInList = $fieldValue[1]['IU_ADD_IN_LIST'] ?? false;

                if ($addInList == true) {
                    $listField->SetSettings(["SHOW_ADD_FORM" => 'Y', "SHOW_EDIT_FORM" => 'Y']);
                    $sort += 10;
                }
                //$listField->Update(["SORT" => $sort]);

                $settings = $fieldValue[1]['SETTINGS'] ?? [];
                if (!empty($settings)) {
                    $listField->SetSettings($settings);
                }
            }
        }
    }

    protected function isExistPropertyFields($iblockId, $arCdodeProp)
    {
        $result = [];
        $rsProperty = \CIBlockProperty::GetList(array(), array('IBLOCK_ID' => $iblockId, 'CODE' => $arCdodeProp));
        while ($element = $rsProperty->Fetch()) {
            $result[] = $element['CODE'];
        }
        return $result;
    }

    protected function addPropertyFields($IBlockId, $IBlockFields)
    {
        $ufe = new \CIBlockPropertyEnum();

        $topSortProp = \CIBlockProperty::GetList(['sort' => 'desc', 'name' => 'asc'], ['IBLOCK_ID' => $IBlockId])->fetch()['SORT'];

        $count = !empty($topSortProp) ? $topSortProp : 0;

        $sort = $count + 10;
        global $CACHE_MANAGER;

        foreach ($IBlockFields as $fieldName => $fieldValue) {
            $typeAr = explode(':', $fieldValue[1]);
            $aUserField = array(
                'IBLOCK_ID' => $IBlockId,
                'CODE' => 'UF_' . strtoupper($fieldName),
                'MULTIPLE' => !empty($fieldValue[2]['MULTIPLE']) ? $fieldValue[2]['MULTIPLE'] : 'N',
                'PROPERTY_TYPE' => $typeAr[0], //  S - строка, N - число, F - файл, L - список, E - привязка к элементам, G - привязка к группам.
                'USER_TYPE' => $typeAr[1] ?? '',
                'SORT' => $sort,
                'IS_REQUIRED' => $fieldValue[0],
                'NAME' => $fieldValue[2]['EDIT_FORM_LABEL'],
                'FILTRABLE' => 'N',
                'SEARCHABLE' => 'N',
                'FEATURES' => [
                    [
                        'MODULE_ID' => 'iblock',
                        'FEATURE_ID' => Iblock\Model\PropertyFeature::FEATURE_ID_LIST_PAGE_SHOW,
                        'IS_ENABLED' => 'Y'
                    ],
                    [
                        'MODULE_ID' => 'iblock',
                        'FEATURE_ID' => Iblock\Model\PropertyFeature::FEATURE_ID_DETAIL_PAGE_SHOW,
                        'IS_ENABLED' => 'Y'
                    ]
                ],
                'ACTIVE' => 'Y',
                // 'LIST_TYPE' => 'L' // L, C
            );

            if (in_array($fieldValue[1], ['E', 'G', 'E:EList', 'S:ElementXmlID', 'E:EAutocomplete', 'iblock_element', 'iblock_section'])) {
                if (!empty($fieldValue[4])) {
                    $ib = explode(':', $fieldValue[4]);
                    if (!empty($ib[0]) && !empty($ib[1])) {
                        $iblock_id = $this->addIblock($ib[0], $ib[1], $ib[0]);
                        if (intval($iblock_id) > 0) {
                            $aUserField['LINK_IBLOCK_TYPE_ID'] = $ib[0];
                            $aUserField['LINK_IBLOCK_ID'] = $iblock_id;
                        }
                    }
                }
            }

            $addInList = false;
            if (isset($fieldValue[2]['IU_ADD_IN_LIST'])) {
                $addInList = $fieldValue[2]['IU_ADD_IN_LIST'];
                unset($fieldValue[2]['IU_ADD_IN_LIST']);
            }

            if (isset($fieldValue[2]) && is_array($fieldValue[2])) {
                $aUserField = array_merge($aUserField, $fieldValue[2]);
            }

            $iblockproperty = new \CIBlockProperty;
            $ufId = $iblockproperty->Add($aUserField);
            //$ufId = $this->addIblockElementProperty($aUserField);

            if ($fieldValue[1] == 'L' && intval($ufId) > 0) {
                $uf_sort = 10;

                foreach ($fieldValue[3] as $i => $item) {
                    if (!isset($item['XML_ID'])) $item['XML_ID'] = 'X' . ($i + 1);
                    if (!isset($item['SORT'])) $item['SORT'] = $uf_sort * ($i + 1);
                    if (!isset($item['DEF'])) $item['DEF'] = 'N';
                    $ufe->Add([
                        'PROPERTY_ID' => $ufId,
                        'VALUE' => $item['VALUE'],
                        'XML_ID' => $item['XML_ID'],
                        'DEF' => $item['DEF'],
                    ]);
                }
            }

            $CACHE_MANAGER->ClearByTag("create_property" . $IBlockId);;
            $sort += 10;
        }
    }

    protected function addElementIblock($iblockId, $element, $userCreateId = 1)
    {
        $el = new \CIBlockElement;
        $result = [];
        try {
            $prop = [
                "ACTIVE" => "Y",
                "MODIFIED_BY" => $userCreateId,
                "IBLOCK_ID" => $iblockId,
                'NAME' => $element['NAME'],
                "PROPERTY_VALUES" => $element['PROPERTY_VALUES']
            ];
            $elId = $el->Add($prop);

            if ($elId) {
                $result['STATUS'] = 'success';
                $result['ID'] = $elId;
            } else {
                $errorAddEl = $el->LAST_ERROR;
                return $result['ERROR'] = 'Ошибка при добавлении елемента: ' . $el->LAST_ERROR . '<br>';
            }
        } catch (\Exception $e) {
            return $result['ERROR'] = 'Критическая ошибка при добавлении елемента: ' . $el->LAST_ERROR . '<br>';
        }

    }

}