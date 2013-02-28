<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"        => ":attribute muss akzeptiert werden.",
	"active_url"      => "Das Feld :attribute ist keine gültige URL.",
	"after"           => "Das Datum :attribute muss ein Datum nach :date sein.",
	"alpha"           => "Das Feld :attribute darf nur Buchstaben enthalten.",
	"alpha_dash"      => "Das Feld :attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.",
	"alpha_num"       => "Das Feld :attribute darf nur Buchstaben und Zahlen enthalten.",
	"before"          => "Das Feld :attribute muss ein Datum vor :date sein.",
	"between"         => array(
		"numeric" => "Das Feld :attribute muss zwischen :min - :max sein.",
		"file"    => "Die Datei :attribute muss zwischen :min - :max Kilobyte groß sein.",
		"string"  => "Das Feld :attribute muss zwischen :min - :max Zeichen lang sein.",
	),
	"confirmed"       => "Die Bestätigung des Feldes :attribute stimmt nicht mit dem Feld überein.",
	"date"            => "Das Datum :attribute ist kein gültiges Datum.",
	"date_format"     => "Das Datum :attribute stimmt nicht mit dem Muster :format überein.",
	"different"       => "Die Felder :attribute und :other müssen unterschiedlich sein.",
	"digits"          => "Das Feld :attribute muss genau :digits Zahlen lang sein.",
	"digits_between"  => "Das Feld :attribute muss zwischen :min und :max Zahlen lang sein.",
	"email"           => "Die E-Mail-Adresse :attribute ist ungültig.",
	"exists"          => "Das gewählte :attribute ist ungültig.",
	"image"           => "Die Datei :attribute muss ein Bild sein.",
	"in"              => "Das gewählte :attribute ist ungültig.",
	"integer"         => "Das Feld :attribute muss eine Ganzzahl sein.",
	"ip"              => "Das Feld :attribute muss eine gültige IP-Adresse sein.",
	"match"           => "Das Format des Feldes :attribute ist ungültig.",
	"max"             => array(
		"numeric"     => "Das Feld :attribute muss kleiner sein als :max.",
		"file"        => "Die Datei :attribute muss kleiner sein als :max Kilobyte.",
		"string"      => "Das Feld :attribute darf nicht mehr als :max Zeichen haben.",
	),
	"mimes"           => "Die Datei :attribute muss von einem dieser Typen sein: :values.",
	"min"             => array(
		"numeric"     => "Das Feld :attribute muss mindestens :min sein.",
		"file"        => "Die Datei :attribute muss mindestens :min Kilobyte groß sein.",
		"string"      => "Die Zeichenkette :attribute muss mindestens :min Zeichen lang sein.",
	),
	"notin"           => "Das gewählte Feld :attribute ist ungültig.",
	"numeric"         => "Das Feld :attribute muss eine Zahl sein.",
	"required"        => "Das Feld :attribute ist ein Pflichtfeld.",
	"required_with"   => "Das Feld :attribute muss angegeben werden, wenn :values angegeben wurde.",
	"same"            => "Die Felder :attribute und :other müssen übereinstimmen.",
	"size"            => array(
		"numeric"    => "Das Feld :attribute muss :size groß sein.",
		"file"       => "Die Datei :attribute muss :size Kilobyte groß sein.",
		"string"     => "Die Zeichenkette :attribute muss genau :size Zeichen lang sein.",
	),
	"unique"          => "Das Feld :attribute ist bereits belegt.",
	"url"             => "Das Format der URL :attribute ist ungültig.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);