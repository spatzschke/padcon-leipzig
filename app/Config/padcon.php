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
	
	if(date('W')+3 > 53) {
		$kw = (date('W')+3)-52; 
		
		Configure::write('padcon.lieferzeit.week', date('W', '01.01')+$kw-1);
		Configure::write('padcon.lieferzeit.year', date('Y'));
	} else {
		Configure::write('padcon.lieferzeit.week', date('W')+3);
		Configure::write('padcon.lieferzeit.year', date('Y'));
	}
	
	
//Angebot - Offer
	Configure::write('padcon.Angebot.header.Anfragenummer','Bezug nehmend auf Ihre Anfrage vom %s, mit der Nummer %s unterbreiten wir Ihnen folgendes Angebot:');
	Configure::write('padcon.Angebot.header.default','Bezug nehmend auf Ihre Anfrage vom %s unterbreiten wir Ihnen folgendes Angebot:');
	
	Configure::write('padcon.Angebot.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.min').'-'.Configure::read('padcon.lieferzeit.max').' Wochen.');
	Configure::write('padcon.Angebot.additional_text.deliveryFree','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt frei Haus. <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.min').'-'.Configure::read('padcon.lieferzeit.max').' Wochen.');
	
//Auftragsbestätigung - Confirmation
	Configure::write('padcon.Auftragsbestaetigung.header.Bestellnummer','Ihre Bestellung Nr.: %s vom %s bestätige ich wie folgt:');
	Configure::write('padcon.Auftragsbestaetigung.header.default','Ihre Bestellung Nr.: %s vom %s bestätige ich wie folgt:');
	Configure::write('padcon.Auftragsbestaetigung.header.pattern','Vielen Dank für Ihr Interesse an unseren Produkten.  Ihre Musterabforderung haben wir  erhalten. Wir werden  ihnen folgende Muster als kostenlose Probestellung für einen Zeitraum von 4 Wochen  wie folgt zur Verfügung stellen:');
	
	Configure::write('padcon.Auftragsbestaetigung.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von '.Configure::read('padcon.delivery_cost.paket').',00 Euro (Lieferung frei Haus ab einem Nettobestellwert von '.Configure::read('padcon.delivery_cost.versandkostenfrei_ab').',00 Euro). <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.week').'. KW '.Configure::read('padcon.lieferzeit.year').'');
	Configure::write('padcon.Auftragsbestaetigung.additional_text.deliveryFree','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage netto <br />Die Lieferung erfolgt frei Haus. <br />Lieferzeit: ca. '.Configure::read('padcon.lieferzeit.min').'-'.Configure::read('padcon.lieferzeit.max').' Wochen.');
	Configure::write('padcon.Auftragsbestaetigung.additional_text.pattern','Erhalten:');
	
//Lieferschein - Delivery
	Configure::write('padcon.Lieferschein.header.Bestellnummer','Ihre Bestellung Nr.: %s vom %s liefern wir wie folgt:');
	Configure::write('padcon.Lieferschein.header.default','Ihre Bestellung vom %s liefern wir wie folgt:');
	Configure::write('padcon.Lieferschein.header.pattern','Bezugnehmend auf Ihre Musterabforderung vom %s liefern wir folgende/s Lagerungshilfsmittel als Probestellung:');
	
	Configure::write('padcon.Lieferschein.additional_text.pattern','Wir bitten die Produkte entsprechend geltender Hausstandards zu reinigen und zu behandeln. Irreparable Beschriftungen verpflichten zum Kauf.<br>Wir bitten um Rücksendung der Probestellung nach 4 Wochen bzw. um persönliche Rücksprache. Sollten wir keine Information Ihrerseits erhalten, behalten wir uns vor zu gegebener Zeit die Muster in Rechnung zu stellen.');
	
//Rechnung - Billing
	Configure::write('padcon.Rechnung.header.Bestellnummer','Ihre Bestellung Nr.: %s vom %s lieferten wir mit dem Lieferschein Nr.: %s vom %s. Wir berechnen wie folgt:');
	Configure::write('padcon.Rechnung.header.default','Wir berechnen wie folgt:');
	Configure::write('padcon.Rechnung.header.Anfrage','Ihre Bestellung vom %s lieferten wir mit dem Lieferschein Nr.: %s vom %s. Wir berechnen wie folgt:');
	

	Configure::write('padcon.Rechnung.additional_text.default','Zahlungsbedingung: '.Configure::read('padcon.zahlungsbedingung.skonto.tage').' Tage '.Configure::read('padcon.zahlungsbedingung.skonto.wert').'% Skonto oder '.Configure::read('padcon.zahlungsbedingung.netto.tage').' Tage Netto.');
	
//Product
	Configure::write('padcon.product.producer.padcon', 'Fa. padcon');
	Configure::write('padcon.product.number.präfix', 'PD-');
	Configure::write('padcon.product.material.präfix', 'Bezug');
	Configure::write('padcon.product.material.noMaterial', 'ohne Bezug');
	Configure::write('padcon.product.core.präfix', 'Kern');
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