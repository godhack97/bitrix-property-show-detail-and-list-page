<?
if (\Bitrix\Main\Loader::includeModule('iblock')) {
	$IBLOCK_ID = 1; // Идентификатор инфоблока
	$properties = CIBlockProperty::GetList(
		Array("sort"=>"asc", "name"=>"asc"), 
		Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID)
		);

	while ($prop_fields = $properties->GetNext())
	{
		\Bitrix\Iblock\Model\PropertyFeature::setFeatures(
		 $prop_fields["ID"],[[
			"MODULE_ID"=>"iblock",
			"IS_ENABLED"=>"Y",
			"FEATURE_ID" => "DETAIL_PAGE_SHOW"
			]]
		);
	}
}
?>
