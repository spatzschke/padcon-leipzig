<?php

//Versandkosten
	Configure::write('padcon.delivery_cost.versandkostenfrei_ab', 500);
	Configure::write('padcon.delivery_cost.paket', 9);
	Configure::write('padcon.delivery_cost.paeckchen', 6);
	Configure::write('padcon.delivery_cost.frei', 0);
	
	
//Angebot - Offer
	Configure::write('padcon.Angebot.additional_text.default','Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von 8,00 Euro (Lieferung frei Haus ab einem Nettobestellwert von 500,00 Euro). <br />Lieferzeit: ca. 2-3 Wochen.');
	
	
//Auftragsbestätigung - Confirmation	
	Configure::write('padcon.Auftragsbestaetigung.additional_text.default','Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />Lieferung frei Haus<br />Lieferzeit: ca. 40. KW 2014');

//Lieferschein - Delivery
	Configure::write('padcon.Lieferschein.additional_text.default','Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />Lieferung frei Haus<br />Lieferzeit: ca. 40. KW 2014');
	


//Rechnung - Billing
	Configure::write('padcon.Rechnung.additional_text.default','Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />Lieferung frei Haus<br />Lieferzeit: ca. 40. KW 2014');
	

?>