<?
namespace Local\Custom\Agents;

use Bitrix\Main\Loader;
use CIBlockElement;
use CEventLog;
use Bitrix\Main\Type\DateTime as BitrixDateTime;

class Agent
{
    static function Agent_ex_610($lastTimeExec = ""): string
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        $result = CIblockElement::GetList(
            ['ID' => 'ASC'],
            [
                'IBLOCK_ID' => IBLOCK_REVIEWS_ID,
                "DATE_MODIFY_FROM" => $lastTimeExec ?: (new BitrixDateTime())->add("-1 day"),
            ],
            ['ID'],
            false,
            ['ID']
        );

        $count = 0;

        while ($result->GetNext())
        $count++;
       // if ($count > 0)
        //{
            CEventLog::Add([
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => 'ex2_610',
                'MODULE_ID' => '',
                'DESCRIPTION' => "Изменилось рецензий: $count",
            ]);
       // }

        return "\\" . __METHOD__ . "(\"" . (new BitrixDateTime())->toString() . "\");";
    }
}

