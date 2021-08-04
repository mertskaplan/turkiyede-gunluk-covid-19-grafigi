<!DOCTYPE html>
<?php
setlocale(LC_TIME, 'tr_TR.UTF-8');
date_default_timezone_set('Europe/Istanbul');
include 'functions.php';
?>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Türkiye'de Covid-19 aşı, vaka, hasta ve ölüm grafiği</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Türkiye'de Covid-19 vaka, hasta ve ölüm grafiği">
    <meta name="keywords" content="covid-19">
    <meta name="author" content="Mert S. Kaplan, mail@mertskaplan.com">
    <meta name="robots" content="index,follow" />
    <meta name="application-name" content="Türkiye'de Covid-19 grafiği">

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/ms-icon-144x144.png">

    <link href="assets/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tarih', 'Günlük test sayısı', 'Günlük vaka sayısı', 'Günlük hasta sayısı', 'Günlük vefat sayısı', 'Günlük iyileşen sayısı', 'Toplam test sayısı', 'Toplam hasta sayısı', 'Toplam vefat sayısı', 'Toplam iyileşen sayısı', 'Toplam yoğun bakım hastası sayısı', 'Toplam entübe sayısı', 'Hastalarda zatüre oranı', 'Günlük ağır hasta sayısı', 'Yatak doluluk oranı', 'Erişkin yoğun bakım doluluk oranı', 'Ventilatör doluluk oranı', 'Ortalama filyasyon süresi', 'Ortalama temaslı tespit süresi', 'Filyasyon oranı', 'Toplam aşı sayısı', '1. doz aşı sayısı', '2. doz aşı sayısı', '3. doz aşı sayısı', '1 doz aşı yaptıranların 18 yaş ve üzeri nüfusa oranı', '2 doz aşı yaptıranların 18 yaş ve üzeri nüfusa oranı', '3 doz aşı yaptıranların 18 yaş ve üzeri nüfusa oranı', 'Vaka - vefat oranı', 'Hasta - vefat oranı', 'Ağır hasta - vefat oranı',  'Aktif hasta sayısı', 'Aktif hasta oranı', 'Toplam vaka sayısı', 'Aktif vaka sayısı', 'Aktif vaka oranı', 'Günlük vaka değişim oranı'],

<?php
$population         = 83614362;     // https://data.tuik.gov.tr/Bulten/Index?p=Istatistiklerle-Cocuk-2020-37228
$populationUnder18  = 22750657;

$json = find('var geneldurumjson = ', ';//]]>', curl('https://covid19.saglik.gov.tr/TR-66935/genel-koronavirus-tablosu.html'));
$infection = json_decode($json[0], true);

$vaccine = json_decode(file_get_contents('https://raw.githubusercontent.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/main/vaccine.json'), true);

/* Combine case numbers with vaccine numbers */
$iv = array();
foreach($infection as $i) {
    $mach = false;
    foreach($vaccine as $v) {
        if ($i['tarih'] == $v['tarih']) {
            array_push($iv, array_merge($i, $v));
            $mach = true;
            break;
        }
    }
    if (!$mach) {
        array_push($iv, array_merge($i, array('toplam_asi' => '', '1_doz_asi' => '', '2_doz_asi' => '', '3_doz_asi' => '')));
    }
}
/* end - Combine case numbers with vaccine numbers */

foreach($iv as $key => $value) {
    $iv[$key]['tarih'] = strftime('%e %B %Y', strtotime($value['tarih']));
}

$iv = json_encode($iv);
//$iv = str_replace('.', '', $iv);
$iv = json_decode($iv, true);
$iv = array_reverse($iv);

foreach($iv as &$b) {
    $b['tarih'] = trim($b['tarih']);                                      								// 0
	$b['gunluk_test'] = clearInteger($b['gunluk_test']);												// 1
    $b['gunluk_vaka'] = clearInteger($b['gunluk_vaka']);												// 2
    $b['gunluk_hasta'] = clearInteger($b['gunluk_hasta']);												// 3
    $b['gunluk_vefat'] = clearInteger($b['gunluk_vefat']);     											// 4
    $b['gunluk_iyilesen'] = clearInteger($b['gunluk_iyilesen']);										// 5
	$b['toplam_test'] = clearInteger($b['toplam_test']);												// 6
    $b['toplam_hasta'] = clearInteger($b['toplam_hasta']);		// toplam vaka diye geçiyor				// 7
	$b['toplam_vefat'] = clearInteger($b['toplam_vefat']);												// 8
	$b['toplam_iyilesen'] = clearInteger($b['toplam_iyilesen']);										// 9
	$b['toplam_yogun_bakim'] = clearInteger($b['toplam_yogun_bakim']);									// 10
	$b['toplam_entube'] = clearInteger($b['toplam_entube']);											// 11
    $b['hastalarda_zaturre_oran'] = clearPercent($b['hastalarda_zaturre_oran']);						// 12
    $b['agir_hasta_sayisi'] = clearInteger($b['agir_hasta_sayisi']); 									// 13
    $b['yatak_doluluk_orani'] = clearPercent($b['yatak_doluluk_orani']);								// 14
    $b['eriskin_yogun_bakim_doluluk_orani'] = clearPercent($b['eriskin_yogun_bakim_doluluk_orani']);	// 15
    $b['ventilator_doluluk_orani'] = clearPercent($b['ventilator_doluluk_orani']);						// 16
    $b['ortalama_filyasyon_suresi'] = clearPercent($b['ortalama_filyasyon_suresi']);					// 17
    $b['ortalama_temasli_tespit_suresi'] = clearInteger($b['ortalama_temasli_tespit_suresi']);			// 18
    $b['filyasyon_orani'] = clearPercent($b['filyasyon_orani']);										// 19

    (!empty($b['toplam_asi'])) ? $b['toplam_asi'] = (int)$b['toplam_asi'] : $b['toplam_asi'] = null;    // 20
    (!empty($b['1_doz_asi'])) ? $b['1_doz_asi'] = (int)$b['1_doz_asi'] : $b['1_doz_asi'] = null;        // 21
    (!empty($b['2_doz_asi'])) ? $b['2_doz_asi'] = (int)$b['2_doz_asi'] : $b['2_doz_asi'] = null;        // 22
    (!empty($b['3_doz_asi'])) ? $b['3_doz_asi'] = (int)$b['3_doz_asi'] : $b['3_doz_asi'] = null;        // 23
	
    (!empty($b['1_doz_asi'])) ? $b['1_doz_orani'] = percent($population - $populationUnder18, $b['1_doz_asi']) : $b['1_doz_orani'] = null; // 24
    (!empty($b['2_doz_asi'])) ? $b['2_doz_orani'] = percent($population - $populationUnder18, $b['2_doz_asi']) : $b['2_doz_orani'] = null; // 25
    (!empty($b['3_doz_asi'])) ? $b['3_doz_orani'] = percent($population - $populationUnder18, $b['3_doz_asi']) : $b['3_doz_orani'] = null; // 26

    $b['vaka_vefat'] = percent($b['gunluk_vaka'], $b['gunluk_vefat']);                                  // 27
    $b['hasta_vefat'] = percent($b['gunluk_hasta'], $b['gunluk_vefat']);                                // 28
    $b['agir_hasta_vefat'] = percent($b['agir_hasta_sayisi'], $b['gunluk_vefat']);                      // 29
}

    // önceki hafta ortalamasına kıyasla oranları verilebilir

for ($x = 0; isset($iv[$x]); $x++) {

    if ($x > 479) { // 3 Temmuz 2021 day 479
        $iv[$x]['toplam_test'] = $iv[$x - 1]['toplam_test'] + $iv[$x]['gunluk_test'];
//        $iv[$x]['toplam_vaka'] = $iv[$x - 1]['toplam_vaka'] + $iv[$x]['gunluk_vaka'];
        $iv[$x]['toplam_vefat'] = $iv[$x - 1]['toplam_vefat'] + $iv[$x]['gunluk_vefat'];
        $iv[$x]['toplam_iyilesen'] = $iv[$x - 1]['toplam_iyilesen'] + $iv[$x]['gunluk_iyilesen'];
    }

    if ($x < 276) { // 12 Aralık 2021 day 276
        $iv[$x]['toplam_hasta'] = $iv[$x]['toplam_hasta'];
        if ($x < 274) { // 10 Aralık 2021 day 274
            $iv[$x]['aktif_hasta'] = $iv[$x]['toplam_hasta'] - ($iv[$x]['toplam_iyilesen'] + $iv[$x]['toplam_vefat']);  // 30
            $iv[$x]['aktif_hasta_orani'] = percent($population, $iv[$x]['aktif_hasta']);                // 31
        } else {
            $iv[$x]['aktif_hasta'] = null;
            $iv[$x]['aktif_hasta_orani'] = null;
        }
        $iv[$x]['toplam_vaka'] = null;                                                                  // 32
        $iv[$x]['aktif_vaka'] = null;                                                                   // 33
        $iv[$x]['aktif_vaka_orani'] = null;                                                             // 34
    } else {
        $iv[$x]['aktif_hasta'] = null;
        $iv[$x]['aktif_hasta_orani'] = null;
        if ($x > 479) {
            $iv[$x]['toplam_vaka'] = $iv[$x - 1]['toplam_vaka'] + $iv[$x]['gunluk_vaka'];
        } else {
            $iv[$x]['toplam_vaka'] = $iv[$x]['toplam_hasta'];                                                  
        }
        $iv[$x]['toplam_hasta'] = null;
        $iv[$x]['aktif_vaka'] = $iv[$x]['toplam_vaka'] - ($iv[$x]['toplam_iyilesen'] + $iv[$x]['toplam_vefat']);
        $iv[$x]['aktif_vaka_orani'] = percent($population, $iv[$x]['aktif_vaka']);
    }

    if (!$x == 0 && !empty($iv[$x - 1]['gunluk_vaka'])) {
        $iv[$x]['gunluk_vaka_degisim_orani'] = number_format($iv[$x]['gunluk_vaka'] / $iv[$x - 1]['gunluk_vaka'], 2);
    } else {
        $iv[$x]['gunluk_vaka_degisim_orani'] = 1;                                                       // 35
    }
}

/*
for ($x = 479 + 1; isset($iv[$x]); $x++) { // 3 Temmuz 2021 day 479
    $iv[$x]['toplam_test'] = $iv[$x - 1]['toplam_test'] + $iv[$x]['gunluk_test'];
    $iv[$x]['toplam_vaka'] = $iv[$x - 1]['toplam_vaka'] + $iv[$x]['gunluk_vaka'];
    $iv[$x]['toplam_vefat'] = $iv[$x - 1]['toplam_vefat'] + $iv[$x]['gunluk_vefat'];
    $iv[$x]['toplam_iyilesen'] = $iv[$x - 1]['toplam_iyilesen'] + $iv[$x]['gunluk_iyilesen'];
}
*/
foreach($iv as &$b) {
    $c = array_values($b);
    echo "                ";
    print_r(json_encode($c));
    echo ",\n";
}

//print_r($iv[479]);
//print_r($iv[480]);
//print_r($iv[275]);
//print_r($iv[234]);
//print_r($iv[277]);
//print_r($iv[506]);

?>
        ]);

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        const graphics = [0,21,22,23,24,25,26];             // showVaccine
        const graphicsDailyInfection = [0,2,3,13,4,27];     // showDailyInfection
        const graphicsActiveInfection = [0,30,31,33,34,35]; // showActiveInfection
        const graphicsSick = [0,3,13,4,28,29];              // showSick
        const graphicsDeath = [0,4,27,28,29];               // showDeath

        view = new google.visualization.DataView(data);
        view.setColumns(graphics);
        var options = {
                title: 'Türkiye\'de günlük Covid-19 aşısı grafiği',
                vAxes: {
                    0: {
                        title: 'Uygulanan doz sayısı'
                    },
                    1: {
                        title: 'Aşılama oranı',
                        gridlines: {color: 'transparent'},
                        format: '\'%\'#',
                        minValue: 0,
                        maxValue: 100
                    },
                },
                series: {
                    '3':{targetAxisIndex:1},
                    '4':{targetAxisIndex:1},
                    '5':{targetAxisIndex:1},
                },
                legend: {position: 'bottom'}
            }
        chart.draw(view, options);

        var showVaccine = document.getElementById("vaccine");
        showVaccine.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphics);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 aşısı grafiği',
                vAxes: {
                    0: {
                        title: 'Uygulanan doz sayısı'
                    },
                    1: {
                        title: 'Aşılama oranı',
                        gridlines: {color: 'transparent'},
                        format: '\'%\'#',
                        minValue: 0,
                        maxValue: 100
                    },
                },
                series: {
                    '3':{targetAxisIndex:1},
                    '4':{targetAxisIndex:1},
                    '5':{targetAxisIndex:1},
                },
                legend: {position: 'bottom'}
            }
            chart.draw(view, options);
        }
        
        var showDailyInfection = document.getElementById("dailyInfection");
        showDailyInfection.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphicsDailyInfection);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 vakası grafiği',
                vAxes: {
                    0: {
                        title: 'Vaka sayısı'
                    },
                    1: {
                        title: 'Vaka oranı',
                        gridlines: {color: 'transparent'},
                        format: '\'%\'#',
                        minValue: 0,
                        maxValue: 5
                    },
                },
                series: {
                    '4':{targetAxisIndex:1},
                },
                legend: {position: 'bottom'}
            }
            chart.draw(view, options);
        }

        var showActiveInfection = document.getElementById("activeInfection");
        showActiveInfection.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphicsActiveInfection);
            var options = {
                title: 'Türkiye\'de aktif Covid-19 vakası grafiği',
                vAxes: {
                    0: {
                        title: 'Vaka sayısı'
                    },
                    1: {
                        title: 'Büyüme faktörü',
                        gridlines: {color: 'transparent'},
                        minValue: 0,
                        maxValue: 2
                    },
                },
                series: {
                    '0':{targetAxisIndex:0},
                    '1':{targetAxisIndex:1},
                    '2':{targetAxisIndex:0},
                    '3':{targetAxisIndex:1},
                    '4':{targetAxisIndex:1}
                },
                legend: {position: 'bottom'}
            }
            chart.draw(view, options);
        }

        var showSick = document.getElementById("sick");
        showSick.onclick = function() {
            view = new google.visualization.DataView(data);
//            view.hideColumns([1]); 
            view.setColumns(graphicsSick);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 hastası grafiği',
                vAxes: {
                    0: {
                        title: 'Hasta sayısı'
                    },
                    1: {
                        title: 'Hasta oranı',
                        gridlines: {color: 'transparent'},
                        format: '\'%\'#',
                        minValue: 0,
                        maxValue: 30
                    },
                },
                series: {
                    '3':{targetAxisIndex:1},
                    '4':{targetAxisIndex:1},
                },
                legend: {position: 'bottom'}
            }
            chart.draw(view, options);
        }

        var showDeath = document.getElementById("death");
        showDeath.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphicsDeath);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 vefat grafiği',
                vAxes: {
                    0: {
                        title: 'Vefat sayısı'
                    },
                    1: {
                        title: 'Vefat oranı',
                        gridlines: {color: 'transparent'},
                        format: '\'%\'#',
                        minValue: 0,
                        maxValue: 30
                    },
                },
                series: {
                    '1':{targetAxisIndex:1},
                    '2':{targetAxisIndex:1},
                    '3':{targetAxisIndex:1},
                },
                legend: {position: 'bottom'}
            }
            chart.draw(view, options);
        }
    }
    </script>
</head>
<body>
	<div class="mskMenu">
		<a class="button" id="vaccine" href="#vaccine">Aşılama verileri</a>
		<a class="button" id="dailyInfection" href="#dailyInfection">Günlük vaka verileri</a>
        <a class="button" id="activeInfection" href="#activeInfection">Aktif vaka verileri</a>
		<a class="button" id="sick" href="#sick">Hasta verileri</a>
		<a class="button" id="death" href="#death">Vefat verileri</a>
	</div>
    <div id="curve_chart" style="width: calc(100vw - 25px); height: calc(100vh - 70px)"></div>
	<div class="msk-Notes">
		<h2>Grafik bilgi notu</h2>
		<ol>
			<li><strong>Grafik</strong>, Türkiye’ye dair <strong>Sağlık Bakanlığı</strong>nın paylaştığı <strong>Covid-19</strong> verilerinin tek bir tablo üzerinde görselleştirmesi amacıyla hazırlanmıştır. Ancak aşılama sayılarının milyonlarla, vefat sayılarının ise yüzlerle ifade edilmesi gibi nedenlerle tüm veriler tek tablo üzerinde anlamlı bir sonuç oluşturamadığı için anlamlı okumaların yapılabilmesi için belirli veri setleri gizlenerek beş sekme oluşturulmuştur.</li>
			<li>Günlük <strong>Covid-19</strong> vaka, hasta ve vefat sayısı gibi veriler Sağlık Bakanlığının yayımladığı <a href="https://covid19.saglik.gov.tr/TR-66935/genel-koronavirus-tablosu.html" target="_blank">Genel Koronavirüs Tablosu</a>’ndan <strong>anlık ve otomatik</strong> olarak çekilmektedir.</li>
			<li>Aşılama sayıları ile ilgili olarak Bakanlık tarafından sadece toplam aşı miktarları paylaşıldığı için birinci ve ikinci doz aşılara dair günlük aşılama sayıları Bakanlığın <a href="https://covid19asi.saglik.gov.tr" target="_blank">covid19asi.saglik.gov.tr</a> adresli internet sitesinin <a href="https://web.archive.org/web/*/https://covid19asi.saglik.gov.tr/" target="_blank">The Wayback Machine</a> üzerindeki ilgili güne dair son kaydı esas alınarak, üçüncü doz aşılara dair günlük aşılama sayıları ise yine Bakanlığın <a href="https://covid19.saglik.gov.tr" target="_blank">covid19.saglik.gov.tr</a> adresli internet sitesinin <a href="https://web.archive.org/web/*/https://covid19.saglik.gov.tr/" target="_blank">The Wayback Machine</a> üzerindeki ilgili güne dair son kaydı esas alınarak <strong>derlenmiş ve günlük olarak güncellenmektedir.</strong></li>
			<li><em>“Vaka - vefat oranı”, “Hasta - vefat oranı”</em>, <em>“Ağır hasta - vefat oranı”</em> ve uygulanan aşı dozu sayısının 18 yaş ve üstü nüfusa oranı, Bakanlıktan ve <a href="https://data.tuik.gov.tr/Bulten/Index?p=Istatistiklerle-Cocuk-2020-37228" target="_blank">TÜİK</a>'ten alınan veriler işlenerek elde edilmiştir.</li>
			<li>Sayı niteliğindeki verilere dair referans aralığı tablonun sol bölümünde, oran niteliğindeki verilere dair referans aralığı ise tablonun sağ bölümünde gösterilmiştir.</li>
			<li><em>"Aktif hasta sayısı"</em> ve <em>"aktif vaka sayısı"</em>, Bakanlığın vaka ve hasta sayılarını açıkladığı ve açıklamayı terk ettiği tarihler göz önünde bulundurularak <em>"toplam vaka/hasta"</em> sayısından <em>"toplam iyileşen sayısı"</em> ve <em>"toplam vefat sayısı"</em> çıkarılarak hesaplanmıştır. <em>"Aktif hasta oranı"</em> ve <em>"aktif vaka oranı"</em> ise nüfusa bölünerek elde edilen günlük insidans oranıdır.</li>
			<li><em>"Günlük vaka değişim oranı"</em>, ilgili o güne dair açıklanan günlük yeni vaka sayısının bir önceki günkü yeni vaka sayısına bölünerek elde edilen büyüme faktörü metriğidir. Büyüme faktörünün 1’den fazla olması salgının hızlı olduğunu, 1’den az olması ise salgının yavaşladığını gösterir.</li>
			<li><strong>PHP</strong> ve <strong>JS</strong> ile hazırlanan ve veri görselleştirmesi için <strong>Google Charts</strong>’ın kullanıldığı grafik açık kaynak kodlu olup, <a href="https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi" target="_blank">GitHub</a> üzerinden kaynak kodlarına erişilebilir.</li>
			<li>Aşılara dair derlenen <a href="https://raw.githubusercontent.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/main/vaccine.json" target="_blank">JSON</a> ve <a href="https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/blob/main/vaccine.xlsx?raw=true" target="_blank">Excel</a> formatındaki verilere grafiğin GitHub sayfasından erişilebilir. Veriler Bakanlığın standartlarına(!) uygun olarak hazırlanmıştır ve verilerin güvenilirliği ile devamlılığı konusunda grafik çalışmasının bir iddiası yoktur.</li>
			<li>Grafikle ilgili olarak soru, öneri ve eleştiri gibi konularda <em class="msk-selectAll">mail@mertskaplan.com</em> adresi ile iletişime geçebilirsiniz.</li>
		</ol>
	</div>
	<div class="msk-footer">
	     <p>İçerik <a rel="license" title="Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International" href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">CC BY-NC-SA 4.0</a>, kaynak kodları <a title="Massachusetts Institute of Technology License" href="https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/blob/main/LICENSE" target="_blank">MIT</a> lisansı altındadır.</p>
	</div>
</body>
</html>