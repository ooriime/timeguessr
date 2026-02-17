<?php
/**
 * Génère des images placeholder avec GD library
 * Images avec le texte de l'événement historique
 */

$events = [
    ['filename' => '1906_earthquake_sf.jpg', 'year' => 1906, 'text' => "1906\nTREMBLEMENT DE TERRE\nSAN FRANCISCO\nFoules dans les rues"],
    ['filename' => '1917_revolution_russia.jpg', 'year' => 1917, 'text' => "1917\nREVOLUTION RUSSE\nPETROGRAD\nBataillon feminin"],
    ['filename' => '1929_wall_street_crash.jpg', 'year' => 1929, 'text' => "1929\nKRACH WALL STREET\nNEW YORK\nFoule devant la bourse"],
    ['filename' => '1936_olympics_berlin.jpg', 'year' => 1936, 'text' => "1936\nJEUX OLYMPIQUES\nBERLIN\nCeremonie nazie"],
    ['filename' => '1945_ve_day.jpg', 'year' => 1945, 'text' => "1945\nVICTOIRE EN EUROPE\nLONDRES\nFoules celebrant"],
    ['filename' => '1947_independence_india.jpg', 'year' => 1947, 'text' => "1947\nINDEPENDANCE INDE\nGANDHI\nFin colonisation britannique"],
    ['filename' => '1956_hungarian_revolution.jpg', 'year' => 1956, 'text' => "1956\nREVOLUTION HONGROISE\nBUDAPEST\nManifestants vs URSS"],
    ['filename' => '1960_independence_congo.jpg', 'year' => 1960, 'text' => "1960\nINDEPENDANCE CONGO\nLEOPOLDVILLE\nDecolonisation africaine"],
    ['filename' => '1963_march_washington.jpg', 'year' => 1963, 'text' => "1963\nMARCHE WASHINGTON\nI HAVE A DREAM\nMartin Luther King"],
    ['filename' => '1968_prague_spring.jpg', 'year' => 1968, 'text' => "1968\nPRINTEMPS DE PRAGUE\nINVASION SOVIETIQUE\nResistance pacifique"],
    ['filename' => '1969_moonlanding_crowds.jpg', 'year' => 1969, 'text' => "1969\nAPOLLO 11\nPREMIER PAS LUNE\nBuzz Aldrin"],
    ['filename' => '1973_chile_coup.jpg', 'year' => 1973, 'text' => "1973\nCOUP D'ETAT CHILI\nSANTIAGO\nPalais bombarde"],
    ['filename' => '1979_iran_revolution.jpg', 'year' => 1979, 'text' => "1979\nREVOLUTION IRAN\nTEHERAN\nKhomeini au pouvoir"],
    ['filename' => '1986_chernobyl.jpg', 'year' => 1986, 'text' => "1986\nCATASTROPHE NUCLEAIRE\nTCHERNOBYL\nPire accident nucleaire"],
    ['filename' => '1989_tiananmen.jpg', 'year' => 1989, 'text' => "1989\nPLACE TIANANMEN\nPEKIN\nManifestations etudiantes"],
    ['filename' => '1989_berlin_wall.jpg', 'year' => 1989, 'text' => "1989\nCHUTE MUR BERLIN\nFoules euphoriques\nFin Guerre froide"],
    ['filename' => '1994_mandela_election.jpg', 'year' => 1994, 'text' => "1994\nNELSON MANDELA\nAFRIQUE DU SUD\nFin apartheid"],
    ['filename' => '2001_september_11.jpg', 'year' => 2001, 'text' => "2001\nWORLD TRADE CENTER\nNEW YORK\nAvant 11 septembre"],
    ['filename' => '2011_arab_spring.jpg', 'year' => 2011, 'text' => "2011\nPRINTEMPS ARABE\nLE CAIRE\nPlace Tahrir"],
    ['filename' => '2020_covid_lockdown.jpg', 'year' => 2020, 'text' => "2020\nPANDEMIE COVID-19\nMONDE ENTIER\nConfinement mondial"],
];

$dir = 'assets/images/historical/';
$success = 0;

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Génération images</title>";
echo "<style>body{background:#1a1a1a;color:#fff;padding:40px;font-family:Arial;}</style></head><body>";
echo "<h1>🎨 Génération des images placeholder</h1>";

foreach ($events as $event) {
    $width = 1200;
    $height = 600;

    $image = imagecreatetruecolor($width, $height);

    // Couleurs dégradées selon l'année
    $year_color_factor = ($event['year'] - 1900) / 120;
    $r = 40 + ($year_color_factor * 100);
    $g = 60 + ($year_color_factor * 80);
    $b = 90 + ($year_color_factor * 120);

    $bg_color = imagecolorallocate($image, $r, $g, $b);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $shadow_color = imagecolorallocate($image, 0, 0, 0);

    imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

    // Ajouter un effet de vignette
    for ($i = 0; $i < 100; $i++) {
        $alpha = ($i / 100) * 50;
        $vignette = imagecolorallocatealpha($image, 0, 0, 0, 127 - $alpha);
        imagerectangle($image, $i, $i, $width - $i, $height - $i, $vignette);
    }

    // Texte multiligne
    $lines = explode("\n", $event['text']);
    $y_start = 200;
    $line_height = 80;

    foreach ($lines as $index => $line) {
        $font_size = ($index === 0) ? 5 : 4; // Plus grand pour l'année
        $y = $y_start + ($index * $line_height);

        // Ombre
        imagestring($image, $font_size, ($width / 2) - (strlen($line) * 8) + 2, $y + 2, $line, $shadow_color);
        // Texte
        imagestring($image, $font_size, ($width / 2) - (strlen($line) * 8), $y, $line, $text_color);
    }

    $filepath = $dir . $event['filename'];
    imagejpeg($image, $filepath, 90);
    imagedestroy($image);

    echo "<p style='color:#10b981'>✓ {$event['filename']} ({$event['year']})</p>";
    $success++;
}

echo "<hr><h2>✅ $success images générées !</h2>";
echo "<p><a href='update_data_real_images.php' style='color:#3b82f6;font-size:1.5em'>➡️ Mettre à jour data.json</a></p>";
echo "</body></html>";
?>
