<?php
include_once "FetchCards.php";
$fetch = new FetchCards();
$fetch->getCardsForExpansion("Magic 2013");
$fetch->getCardsForExpansion("Magic 2012");
$fetch->getCardsForExpansion("Magic 2011");
$fetch->getCardsForExpansion("Magic 2010");

$fetch->getCardsForExpansion("Return to Ravnica");

$fetch->getCardsForExpansion("Avacyn Restored");
$fetch->getCardsForExpansion("Dark Ascension");
$fetch->getCardsForExpansion("Innistrad");

$fetch->getCardsForExpansion("New Phyrexia");
$fetch->getCardsForExpansion("Mirrodin Besieged");
$fetch->getCardsForExpansion("Scars of Mirrodin");

$fetch->getCardsForExpansion("Rise of the Eldrazi");
$fetch->getCardsForExpansion("Worldwaker");
$fetch->getCardsForExpansion("Zendikar");
?>
