<?php

//Versandkosten
	Configure::write('padcon.delivery_cost.versandkostenfrei_ab', 500);
	Configure::write('padcon.delivery_cost.paket', 9);
	Configure::write('padcon.delivery_cost.paeckchen', 6);
	Configure::write('padcon.delivery_cost.frei', 0);
	
//Standardtext Settings
	Configure::write('padcon.zahlungsbedingung.skonto.tage', 10);
	Configure::write('padcon.zahlungsbedingung.skonto.wert', 2);
	Configure::write('padcon.zahlungsbedingung.netto.tage', 30);
	Configure::write('padcon.lieferzeit.min', 2);
	Configure::write('padcon.lieferzeit.max', 3);
	
	Configure::write('padcon.lieferzeit.week', date('W')+3);
	Configure::write('padcon.lieferzeit.year', date('Y'));
	
//Angebot - Offer
	Configure::write('padcon.Angebot.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.min').'-'.Configure::read('padcon.lieferzeit.max').' Wochen.');
	
//Auftragsbestätigung - Confirmation	
	Configure::write('padcon.Auftragsbestaetigung.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.week').'. KW '.Configure::read('padcon.lieferzeit.year').'');

//Lieferschein - Delivery
	Configure::write('padcon.Lieferschein.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.week').'. KW '.Configure::read('padcon.lieferzeit.year').'');
	
//Rechnung - Billing
	Configure::write('padcon.Rechnung.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.week').'. KW '.Configure::read('padcon.lieferzeit.year').'');
	
//Product
	Configure::write('padcon.product.number.präfix', 'PD-');
	Configure::write('padcon.product.material.präfix', 'Bezug');
	Configure::write('padcon.product.color.präfix', 'Farbe');
	Configure::write('padcon.product.size.präfix', 'Maße');
	Configure::write('padcon.product.size.suffix', 'cm');
	Configure::write('padcon.product.size.noSize', 'gemäß Beschreibung');
	Configure::write('padcon.product.feature.präfix', 'Beschreibung');
	Configure::write('padcon.product.farbindex', 'Farbe laut Farben-Index');
	
//Währung
	Configure::write('padcon.currency.symbol', '€');
	Configure::write('padcon.currency.format', '€');
	
//Katalog
	Configure::write('padcon.catalog.price.suffix', 'mit_Preis');
?>