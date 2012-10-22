<?php
final class CardType
{
	const BASIC_LAND = 0;
	const LAND = 1;
	const CREATURE = 2;
	const INSTANT = 3;
	const SORCERY = 4;
	const ENCHANTMENT = 5;
	const ARTIFACT = 6;
	const PLANESWALKER = 7;
	const SNOW = 8;
	const LEGENDARY = 9;
	const TRIBAL = 10;

	public function __construct($typeString)
	{
		$this->fullType = $typeString;
		$this->cardTypes = array();
		$this->subTypes = array();

		// type — sub_types
		$index = strpos($typeString, "-");
		
		// get the basic type first
		$type = "";
		if ($index === FALSE)
		{
			$type = $typeString;
		}
		else
		{
			// there is always a space before the dash
			$type = substr($typeString, 0, $index - 1);
		}

		$typePieces = explode(" ", $type);
		foreach($typePieces as $typePiece)
		{
			if (strcasecmp($typePiece, "Basic") == 0)
			{
				array_push($this->cardTypes, self::BASIC_LAND);
			}
			else if (strcasecmp($typePiece, "Land") == 0)
			{
				array_push($this->cardTypes, self::LAND);
			}
			else if (strcasecmp($typePiece, "Creature") == 0)
			{
				array_push($this->cardTypes, self::CREATURE);
			}
			else if (strcasecmp($typePiece, "Instant") == 0)
			{
				array_push($this->cardTypes, self::INSTANT);
			}
			else if (strcasecmp($typePiece, "Sorcery") == 0)
			{
				array_push($this->cardTypes, self::SORCERY);
			}
			else if (strcasecmp($typePiece, "Enchantment") == 0)
			{
				array_push($this->cardTypes, self::ENCHANTMENT);
			}
			else if (strcasecmp($typePiece, "Artifact") == 0)
			{
				array_push($this->cardTypes, self::ARTIFACT);
			}
			else if (strcasecmp($typePiece, "Planeswalker") == 0)
			{
				array_push($this->cardTypes, self::PLANESWALKER);
			}
			else if (strcasecmp($typePiece, "Snow") == 0)
			{
				array_push($this->cardTypes, self::SNOW);
			}
			else if (strcasecmp($typePiece, "Legendary") == 0)
			{
				array_push($this->cardTypes, self::LEGENDARY);
			}
			else if (strcasecmp($typePiece, "Tribal") == 0)
			{
				array_push($this->cardTypes, self::TRIBAL);
			}
			else
			{
				throw new Exception("Unknown type piece: $typePiece");
			}
		}
		
		// get the list of sub types, they are space separated
		// find first space and start from there, dash is always followed by a space
		$space = strpos($typeString, " ", $index);
		$subTypeText = substr($typeString, $space + 1);
		$this->subTypes = explode(" ", $subTypeText);
	}
	
	public function getString()
	{
		return $this->fullType;
	}
	
	public function isType($type)
	{
		foreach($this->cardTypes as $typePiece)
		{
			if ($typePiece == $type)
			{
				return true;
			}
		}
		return false;
	}
	
	public function isSubType($type)
	{
		foreach($this->subTypes as $subType)
		{
			if (strcasecmp($subType, $type) == 0)
			{
				return true;
			}
		}
		return false;
	}
	
	public function getSubTypes()
	{
		return $this->subTypes;
	}
	
	private $cardTypes;
	private $subTypes;
	private $fullType;
}
?>
