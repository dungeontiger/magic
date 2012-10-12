<?php
include_once "FetchCards.php";
$fetch = new FetchCards();
$fetch->getCardsForExpansion("Magic 2013");
$fetch->getCardsForExpansion("New Phyrexia");
$fetch->getCardsForExpansion("Shadowmoor");
?>
