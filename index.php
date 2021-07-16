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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tarih',   'Günlük vaka sayısı',  'Günlük hasta sayısı', 'Günlük vefat sayısı', 'Günlük ağır hasta sayısı', 'Toplam aşı sayısı', '1. doz aşı sayısı', '2. doz aşı sayısı', '3. doz aşı sayısı', 'Vaka - vefat oranı', 'Hasta - vefat oranı', 'Ağır hasta - vefat oranı'],
<?php 
$json = find('var geneldurumjson = ', ';//]]>', curl('https://covid19.saglik.gov.tr/TR-66935/genel-koronavirus-tablosu.html'));
$infection = json_decode($json[0], true);

include_once('vaccine.php');

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
$iv = str_replace('.', '', $iv);
$iv = json_decode($iv, true);
$iv = array_reverse($iv);

foreach($iv as &$b) {
//    unset($b['tarih']);                                   // 0
    unset($b['gunluk_test']);                       
    $b['gunluk_vaka'] = (int)$b['gunluk_vaka'];             // 1
    $b['gunluk_hasta'] = (int)$b['gunluk_hasta'];           // 2
    $b['agir_hasta_sayisi'] = (int)$b['agir_hasta_sayisi']; // 3
    $b['gunluk_vefat'] = (int)$b['gunluk_vefat'];           // 4
    unset($b['gunluk_iyilesen']);
    unset($b['toplam_test']);
    unset($b['toplam_hasta']);
    unset($b['toplam_vefat']);
    unset($b['toplam_iyilesen']);
    unset($b['toplam_yogun_bakim']);
    unset($b['toplam_entube']);
    unset($b['hastalarda_zaturre_oran']);
//    $b['hastalarda_zaturre_oran'] = (int)$b['hastalarda_zaturre_oran'];
    unset($b['yatak_doluluk_orani']);
//    $b['yatak_doluluk_orani'] = (int)$b['yatak_doluluk_orani'];
    unset($b['eriskin_yogun_bakim_doluluk_orani']);
    unset($b['ventilator_doluluk_orani']);
    unset($b['ortalama_filyasyon_suresi']);
    unset($b['ortalama_temasli_tespit_suresi']);
    unset($b['filyasyon_orani']);
    (!empty($b['toplam_asi'])) ? $b['toplam_asi'] = (int)$b['toplam_asi'] : $b['toplam_asi'] = null;    // 5
    (!empty($b['1_doz_asi'])) ? $b['1_doz_asi'] = (int)$b['1_doz_asi'] : $b['1_doz_asi'] = null;        // 6
    (!empty($b['2_doz_asi'])) ? $b['2_doz_asi'] = (int)$b['2_doz_asi'] : $b['2_doz_asi'] = null;        // 7
    (!empty($b['3_doz_asi'])) ? $b['3_doz_asi'] = (int)$b['3_doz_asi'] : $b['3_doz_asi'] = null;        // 8

    $b['vaka_vefat'] = percent($b['gunluk_vaka'], $b['gunluk_vefat']);                                  // 9
    $b['hasta_vefat'] = percent($b['gunluk_hasta'], $b['gunluk_vefat']);                                // 10
    $b['agir_hasta_vefat'] = percent($b['agir_hasta_sayisi'], $b['gunluk_vefat']);                      // 11

    $c = array_values($b);
    echo "                ";
    print_r(json_encode($c));
    echo ",\n";
}
?>
        ]);

        var options = {
            title: 'Türkiye\'de günlük Covid-19 aşısı grafiği',
//            interpolateNulls = true;
            //colors: ['#19215c', '#e0772f', '#665191', '#824a87', '#d45087', '#f95d6a', '#ff7c43', '#ffa600'],
            vAxes: {
                1: {
                    gridlines: {color: 'transparent'},
                    format: '#\'%\'',
                    minValue: 0,
                    maxValue: 5
                },
            },
            series: {
                '8':{targetAxisIndex:1},
            },
            // http://www.marinamele.com/2014/04/google-charts-double-axes.html

            curveType: 'none',
            legend: {position: 'bottom'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        const graphics = [0,6,7,8];                 // showVaccine
        const graphicsInfection = [0,1,2,4,3,9];    // showInfection
        const graphicsSick = [0,2,4,3,10,11];       // showSick
        const graphicsDeath = [0,3,9,10,11];        // showDeath

        view = new google.visualization.DataView(data);
        view.setColumns(graphics); 
        chart.draw(view, options);

        var showVaccine = document.getElementById("vaccine");
        showVaccine.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphics); 
            chart.draw(view, options);
        }
        
        var showInfection = document.getElementById("infection");
        showInfection.onclick = function() {
            view = new google.visualization.DataView(data);
            view.setColumns(graphicsInfection);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 vakası grafiği',
                vAxes: {
                    1: {
                        gridlines: {color: 'transparent'},
                        format: '#\'%\'',
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

        var showSick = document.getElementById("sick");
        showSick.onclick = function() {
            view = new google.visualization.DataView(data);
//            view.hideColumns([1]); 
            view.setColumns(graphicsSick);
            var options = {
                title: 'Türkiye\'de günlük Covid-19 hastası grafiği',
                vAxes: {
                    1: {
                        gridlines: {color: 'transparent'},
                        format: '#\'%\'',
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
                    1: {
                        gridlines: {color: 'transparent'},
                        format: '#\'%\'',
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
        }
        .mskMenu {
            text-align: center;
        }
        .button {
            margin: 25px 5px 0;
            padding: 7px;
            border: 1px solid #36c;
            border-radius: 0;
            background: transparent;
            color: #36c;
            font-size: 95%;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover, .button:target {
            background-color: #36c;
            color: #fff;
        }
		.msk-Notes {
			margin: 70px 15px 30px;
		}
		li {
			margin-bottom: 10px;
		}
		h2 {
			margin-left: 40px;
		}
		a {
			color: #36c;
			text-decoration: none;
		}
		a:hover {
			color: #14d;
		}
		em {
			margin-right:5px;
		}
		.msk-selectAll {
			-webkit-user-select: all;
			-moz-user-select: all;
			-ms-user-select: all;
			user-select: all;
		}
		.msk-footer {
			text-align: center;
			font-size: 90%;
		}
    </style>
</head>
<body>
	<div class="mskMenu">
		<a class="button" id="vaccine" href="#vaccine">Aşılama verileri</a>
		<a class="button" id="infection" href="#infection">Vaka verileri</a>
		<a class="button" id="sick" href="#sick">Hasta verileri</a>
		<a class="button" id="death" href="#death">Vefat verileri</a>
	</div>
    <div id="curve_chart" style="width: calc(100vw - 25px); height: calc(100vh - 70px)"></div>
	<div class="msk-Notes">
		<h2>Grafik bilgi notu</h2>
		<ol>
			<li><strong>Grafik</strong>, Türkiye’ye dair <strong>Sağlık Bakanlığı</strong>nın paylaştığı <strong>Kovid-19</strong> verilerinin tek bir tablo üzerinde görselleştirmesi amacıyla hazırlanmıştır. Ancak aşılama sayılarının milyonlarla, vefat sayılarının ise yüzlerle ifade edilmesi gibi nedenlerle tüm veriler tek tablo üzerinde anlamlı bir sonuç oluşturamadığı için anlamlı okumaların yapılabilmesi için belirli veri setleri gizlenerek dört sekme oluşturulmuştur.</li>
			<li>Günlük <strong>Kovid-19</strong> vaka, hasta ve vefat sayısı gibi veriler Sağlık Bakanlığının yayımladığı <a href="https://covid19.saglik.gov.tr/TR-66935/genel-koronavirus-tablosu.html" target="_blank">Genel Koronavirüs Tablosu</a>’ndan <strong>anlık ve otomatik</strong> olarak çekilmektedir.</li>
			<li>Aşılama sayıları ile ilgili olarak Bakanlık tarafından sadece toplam aşı miktarları paylaşıldığı için birinci ve ikinci doz aşılara dair günlük aşılama sayıları Bakanlığın <a href="https://covid19asi.saglik.gov.tr" target="_blank">covid19asi.saglik.gov.tr</a> adresli internet sitesinin <a href="https://web.archive.org/web/*/https://covid19asi.saglik.gov.tr/" target="_blank">The Wayback Machine</a> üzerindeki ilgili güne dair son kaydı esas alınarak, üçüncü doz aşılara dair günlük aşılama sayıları ise yine Bakanlığın <a href="https://covid19.saglik.gov.tr" target="_blank">covid19.saglik.gov.tr</a> adresli internet sitesinin <a href="https://web.archive.org/web/*/https://covid19.saglik.gov.tr/" target="_blank">The Wayback Machine</a> üzerindeki ilgili güne dair son kaydı esas alınarak <strong>derlenmiştir.</strong></li>
			<li><em>“Vaka - vefat oranı”, “Hasta - vefat oranı”</em> ve <em>“Ağır hasta - vefat oranı”</em> Bakanlıktan alınan veriler işlenerek elde edilmiştir.</li>
			<li>Sayı niteliğindeki verilere dair referans aralığı tablonun sol bölümünde, oran niteliğindeki verilere dair referans aralığı ise tablonun sağ bölümünde gösterilmiştir.</li>
			<li><strong>PHP</strong> ve <strong>JS</strong> ile hazırlanan ve veri görselleştirmesi için <strong>Google Charts</strong>’ın kullanıldığı grafik açık kaynak kodlu olup, GitHub üzerinden kaynak kodlarına erişilebilir.</li>
			<li>Aşılara dair derlenen <a href="https://raw.githubusercontent.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/main/vaccine.json" target="_blank">JSON</a> ve <a href="https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/blob/main/vaccine.php" target="_blank">PHP Array</a> formatındaki verilere grafiğin GitHub sayfasından erişilebilir. Derlenen verilerin güvenilirliği ve devamlılığı konusunda ise grafik çalışmasının bir iddiası yoktur.</li>
			<li>Grafikle ilgili olarak soru, öneri ve eleştiri gibi konularda <em class="msk-selectAll">mail@mertskaplan.com</em> adresi ile iletişime geçebilirsiniz.</li>
		</ol>
	</div>
	<div class="msk-footer">
	     <p>İçerik <a rel="license" title="Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International" href="https://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY-NC-SA 4.0</a> lisansı altındadır.</p>
	</div>
</body>
</html>
