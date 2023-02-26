<?php

namespace VadimRomanov;

use http\Exception;
use VadimRomanov\Migrations\IBlockMigration;
use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Main\SystemException;

class FabricContacts extends IBlockMigration
{
    private $iblock = [
        'CODE' => 'contacts',
        'NAME' => 'Контакты'
    ];

    private $iblockType = [
        'ID' => 'content',
        'NAME' => 'Контент'
    ];

    protected $iblockFields = [
        'CITY' => ['N', 'S',
            [
                'EDIT_FORM_LABEL' => 'Город',
                'IU_ADD_IN_LIST' => true,
            ],
        ],
        'PHONE' => ['N', 'S',
            [
                'EDIT_FORM_LABEL' => 'Телефон',
                'IU_ADD_IN_LIST' => true,
            ],
        ],
        'EMAIL' => ['N', 'S',
            [
                'EDIT_FORM_LABEL' => 'Email',
                'IU_ADD_IN_LIST' => true,
            ],
        ],
        'COORDS' => ['N', 'S:map_yandex',
            [
                'EDIT_FORM_LABEL' => 'Координаты',
                'IU_ADD_IN_LIST' => true,
            ],
        ],
    ];
    private $arContactElements = [
        [
            'NAME' => 'Офис 1',
            'PROPERTY_VALUES' => [
                'CITY' => 'Санкт-Петербург',
                'PHONE' => '78123353684',
                'EMAIL' => 'nana@mail.ru',
                'COORDS' => '59.858492, 30.341346',
            ]
        ],
        [
            'NAME' => 'Офис 2',
            'PROPERTY_VALUES' => [
                'CITY' => 'Москва',
                'PHONE' => '74953353684',
                'EMAIL' => 'fdfana@mail.ru',
                'COORDS' => '55.762237, 37.496208',
            ]
        ],
        [
            'NAME' => 'Офис 3',
            'PROPERTY_VALUES' => [
                'CITY' => 'Солнечногорск',
                'PHONE' => '74962643909',
                'EMAIL' => 'ooona@mail.ru',
                'COORDS' => '56.179956, 36.967648',
            ]
        ],
        [
            'NAME' => 'Офис 4',
            'PROPERTY_VALUES' => [
                'CITY' => 'Солнечногорск',
                'PHONE' => '74962643909',
                'EMAIL' => 'ooona@mail.ru',
                'COORDS' => '56.179956, 36.967648',
            ]
        ],
        [
            'NAME' => 'Офис5',
            'PROPERTY_VALUES' => [
                'CITY' => 'Клин',
                'PHONE' => '74962643909',
                'EMAIL' => 'dsdfa@mail.ru',
                'COORDS' => '56.331595, 36.728711',
            ]
        ],
        [
            'NAME' => 'Офис 6',
            'PROPERTY_VALUES' => [
                'CITY' => 'село Рогачёво',
                'PHONE' => '74962643909',
                'EMAIL' => 'o33na@mail.ru',
                'COORDS' => '56.433509, 37.158559',
            ]
        ]
    ];


    public function __construct()
    {
        if (!Loader::IncludeModule("iblock")) {
            throw new SystemException('iblock not installed');
        }
    }

    public function fabricOffice()
    {

        $result = [
            'STATUS' => 'NO_NEEDED',
            'MSG' => '',
            'ERROR' => '',
        ];
        $error = [];
        $msg = [];

            //check isset iblock type
            $resTypeIblick = $this->findTypeIblock($this->iblockType['ID']);
            //$msg[] = 'Не удалось добавить данные';

            //create typeIblock
            if (empty($resTypeIblick)) {

                $resTypeIblick = $this->addTypeIblock($this->iblockType);
                if (!isset($typeIblock['ERROR'])) {
                    $msg[] = 'Тип инфоблока Контент успешно добавлен';
                } else {
                    $error[] = "Ошибка добавления iblockType " . $typeIblock['ERROR'];
                }
            }
            //create iblock
            $this->iblock['ID'] = $this->findIblock($this->iblockType['ID'], $this->iblock['CODE']);
            //create iblock
            if (empty($this->iblock['ID'])) {

                $resIblock = $this->addIblock($this->iblockType['ID'], $this->iblock['CODE'], $this->iblock['NAME']);
                if (!isset($resIblock['ERROR'])) {
                    $msg[] = 'Инфоблок Контакты успешно добавлен';
                    $this->iblock['ID'] = $resIblock['ID'];
                } else {
                    $error[] = "Ошибка добавления инфоблока " . $resIblock['ERROR'];
                }
            }


            if (!empty($this->iblock['ID'])) {
                //create property
                $propertyCodeIblock = array_keys($this->iblockFields);
                $issetProp = $this->isExistPropertyFields($this->iblock['ID'], $propertyCodeIblock[0]);
                if (empty($issetProp)) {
                    $msg[] = 'Свойства инфоблока Контакты успешно добавлены';
                    $this->addPropertyFields($this->iblock['ID'], $this->iblockFields);
                }

                //create elements

                foreach ($this->arContactElements as $item){
                    $resAddEl = $this->addElementIblock($this->iblock['ID'], $item);
                    if(isset($resAddEl['ERROR'])){
                        $error[] = "Элемент не добавлен " .$resAddEl['ERROR'];
                    }

                }


            } else {
                $error[] = "Свойства и элементы инфоблока не добавлены, т.к. нет инфоблок не найден ";
            }


            //Tools::logFile($arPropCode, '$arPropCode fabric');

            return [
                'STATUS' => 'created',
                'MSG' => $msg,
                'ERROR' => $error,
            ];



    }


}