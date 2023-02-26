<?php
namespace VadimRomanov;

use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

class HelperIblock{

	private static $_istance = null;

    public $iblock = null;

	public static function getInstance(){
		if(is_null(self::$_istance)){
			self::$_istance = new self();
		}

		return self::$_istance;
	}

	/**
	 * @param $iblockCode
	 *
	 * @return mixed
	 * @throws SystemException
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\LoaderException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 */
	public function getIBlock($iblockCode){
		if( ! Loader::IncludeModule("iblock")){
			throw new SystemException('iblock not installed');
		}

		$ilblock = \Bitrix\Iblock\IblockTable::getList([
				'filter' => ['=CODE' => $iblockCode],
			])->fetch();
		if( ! $ilblock){
			throw new \Exception('Не найден iblock '.$iblockCode);
		}

		$this->iblock = $ilblock;


		return $ilblock;
	}


	public function getTablePathIblock($iblockCode){
		$this->getIBlock($iblockCode);
		return \Bitrix\Iblock\Iblock::wakeUp($this->iblock['ID'])->getEntityDataClass();
	}

    /**
     * Возвращает ID инфоблока по его коду
     *
     * @param string $iblockCode
     * @param int    $cacheTime
     *
     * @return int
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static function getIblockIdByCode(string $iblockCode, int $cacheTime = 86400000): int
    {
        $iblock = \Bitrix\Iblock\IblockTable::getList([
            'filter' => [
                '=CODE' => $iblockCode
            ],
            'select' => ['ID'],
            'limit'  => 1,
            'cache'  => [
                'ttl' => $cacheTime
            ]
        ])->fetch();

        return ($iblock['ID'] > 0) ? $iblock['ID'] : 0;
    }

}