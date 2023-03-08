<?php

namespace VadimRomanov;

use http\Exception;
use React\Promise\Promise;
use VadimRomanov\Migrations\IBlockMigration;
use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Main\SystemException;
use Recoil\ReferenceKernel\ReferenceKernel;

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

    private function createTypeIblock($result)
    {


        //check isset iblock type
        $resTypeIblock = $this->issetTypeIblock($this->iblockType['ID']);
        Tools::logFile($resTypeIblock, '$resTypeIblock before create typeIblock');
        //create typeIblock
        if (empty($resTypeIblock)) {

            $resTypeIblock = $this->addTypeIblock($this->iblockType);

           Tools::logFile($resTypeIblock, '$resTypeIblock after create create typeIblock');

            if ($resTypeIblock['STATUS'] == 'success') {
                $result['MSG'][] = 'Тип инфоблока Контент успешно добавлен';
                $result['STATUS'] = 'resolve';
            } else {
                $result['STATUS'] = 'fail';
                throw new \Exception("Ошибка добавления iblockType " . $resTypeIblock);
            }
        }else{
            $result['STATUS'] = 'resolve';
        }


        if (empty($resTypeIblock)) {
            throw new \Exception("Тип инфоблока не удалось добавить");
        }
        //yield;
        return $result;
    }

    private function createIblock($result)
    {
        //yield;

        $this->iblock['ID'] = $this->findIblock($this->iblockType['ID'], $this->iblock['CODE']);
        //create iblock
        if (empty($this->iblock['ID'])) {

            $resIblock = ReferenceKernel::start(function () {
                $result = yield $this->addIblock($this->iblockType['ID'], $this->iblock['CODE'], $this->iblock['NAME']);
                Tools::logFile($result, 'create Iblock');
                return $result;
            });

            if (!isset($resIblock['ERROR'])) {
                $result['MSG'][] = 'Инфоблок Контакты успешно добавлен';
                $result['STATUS'] = 'iblockCreated';
                $this->iblock['ID'] = $resIblock['ID'];
            } else {
                $result['STATUS'] = 'fail';
                throw new \Exception("Ошибка добавления инфоблока " . $resIblock['ERROR']);
            }
        }


        if (empty($this->iblock['ID'])) {
            throw new \Exception("Инфоблок не удалось добавить");
        } else {
            return $result;
        }
    }

    private function createPropIblock($result)
    {
        //yield;
        //create property if empty
        $propertyCodeIblock = array_keys($this->iblockFields);
        $issetProp = $this->isExistPropertyFields($this->iblock['ID'], $propertyCodeIblock[0]);
        if (empty($issetProp)) {
            $result['MSG'][] = 'Свойства инфоблока Контакты успешно добавлены';
            $this->addPropertyFields($this->iblock['ID'], $this->iblockFields);
        }
        return $result;
    }

    private function createElementsIblock($result)
    {
        //yield;
        if (!$this->isExistElements($this->iblock['CODE'])) {
            foreach ($this->arContactElements as $item) {
                $resAddEl = $this->addElementIblock($this->iblock['ID'], $item);
                if ($resAddEl['ID']) {
                    $result['MSG'][] = $resAddEl['MSG'];
                }
                if (isset($resAddEl['ERROR'])) {

                    $result['STATUS'] = 'fail';
                    throw new \Exception("Элемент не добавлен " . $resAddEl['ERROR']);

                }
            }
            if (empty($error)) {
                $result['STATUS'] = 'allCreated';
            }
        } else {
            $result['STATUS'] = 'allCreated';
        }
        return $result;
    }

    /**
     * This method create typeIblock, iblock, it`s prop, it`s demo elements
     * @return array
     */
    public function fabricOffice(): array
    {
        $error = [];
        $msg = [];
        $result = [];

        try {
            $result = ReferenceKernel::start(function () {
                global $result;
                $result = yield $this->createTypeIblock($result);
                $result = yield $this->createIblock($result);
                $result = yield $this->createPropIblock($result);
                $result = yield $this->createElementsIblock($result);
                Tools::logFile($result, '$result in reference');
                return $result;
            });
        } catch (\Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }


        Tools::logFile($result, '$result after ref');
//            ->otherwise(function (\Exception $x) {
//
//                // Propagate the rejection
//                $result['ERROR'] = $x->getMessage();
//                return $result;
//            });


        return $result;
    }
}