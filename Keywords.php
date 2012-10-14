<?php
class Keywords
{
	public function __construct()
	{
		$this->keywords["deathtouch"] = Keywords::DEATHTOUCH;
		$this->keywords["defender"] = Keywords::DEFENDER;
		$this->keywords["double strike"] = Keywords::DOUBLE_STRIKE;
		$this->keywords["first strike"] = Keywords::FIRST_STRIKE;
		$this->keywords["flash"] = Keywords::FLASH;
		$this->keywords["flying"] = Keywords::FLYING;
		$this->keywords["haste"] = Keywords::HASTE;
		$this->keywords["hexproof"] = Keywords::HEXPROOF;
		$this->keywords["intimidate"] = Keywords::INTIMIDATE;
		$this->keywords["lifelink"] = Keywords::LIFELINK;
		$this->keywords["reach"] = Keywords::REACH;
		$this->keywords["shroud"] = Keywords::SHROUD;
		$this->keywords["trample"] = Keywords::TRAMPLE;
		$this->keywords["vigilance"] = Keywords::VIGILANCE;
		$this->keywords["exalted"] = Keywords::EXALTED;
	}

	public function getKeywords()
	{
		return $this->keywords;
	}
	
	private $keywords = array();
	
	const DEATHTOUCH = 0;
	const DEFENDER = 1;
	const DOUBLE_STRIKE = 2;
	// enchant
	// equip
	const FIRST_STRIKE = 3;
	const FLASH = 4;
	const FLYING = 5;
	const HASTE = 6;
	const HEXPROOF = 7;
	const INTIMIDATE = 8;
	// landwalk
	const LIFELINK = 9;
	// protection
	const REACH = 10;
	const SHROUD = 11;
	const TRAMPLE = 12;
	const VIGILANCE = 13;

	const EXALTED = 14;
	// banding
	// rampage
	// cumulative upkeep
	// flanking
	// phasing
	// buyback
	// shadow
	// cycling
	// echo
	// horsemanship
	// fading
	// kicker
	// flashback
	// madness
	// fear
	// morph
	// amplify
	// provoke
	// storm
	// affinity
	// entwine
	// modular
	// sunburst
	// bushido
	// soulshift
	// splice
	// offering
	// ninjutsu
	// epic
	// convoke
	// dread
	// transmute
	// bloodthirst
	// haunt
	// replicate
	// forecast
	// graft
	// recover
	// ripple
	// split second
	// suspend
	// vanishing
	// absorb
	// aura swap
	// delve
	// fortify
	// frenzy
	// gravestorm
	// poisonous
	// transfigure
	// champion
	// changeling
	// evoke
	// hideaway
	// prowl
	// reinforce
	// conspire
	// persist
	// wither
	// retrace
	// devour
	// unearth
	// cascade
	// annihilator
	// level up
	// rebound
	// totem armor
	// infect
	// battle cry
	// living weapon
	// undying
	// miracle
	// soulbound
	// overload
	// scavenge
	// unleash
}
?>
