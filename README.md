# Türkiye'de günlük Covid-19 aşı, vaka, hasta ve ölüm grafiği


* Grafik, Türkiye’ye dair Sağlık Bakanlığının paylaştığı Kovid-19 verilerinin tek bir tablo üzerinde görselleştirmesi amacıyla hazırlanmıştır. Ancak aşılama sayılarının milyonlarla, vefat sayılarının ise yüzlerle ifade edilmesi gibi nedenlerle tüm veriler tek tablo üzerinde anlamlı bir sonuç oluşturamadığı için anlamlı okumaların yapılabilmesi için belirli veri setleri gizlenerek dört sekme oluşturulmuştur.
* Günlük Kovid-19 vaka, hasta ve vefat sayısı gibi veriler Sağlık Bakanlığının yayımladığı Genel Koronavirüs Tablosu’ndan anlık ve otomatik olarak çekilmektedir.
* Aşılama sayıları ile ilgili olarak Bakanlık tarafından sadece toplam aşı miktarları paylaşıldığı için birinci ve ikinci doz aşılara dair günlük aşılama sayıları Bakanlığın covid19asi.saglik.gov.tr adresli internet sitesinin The Wayback Machine üzerindeki ilgili güne dair son kaydı esas alınarak, üçüncü doz aşılara dair günlük aşılama sayıları ise yine Bakanlığın covid19.saglik.gov.tr adresli internet sitesinin The Wayback Machine üzerindeki ilgili güne dair son kaydı esas alınarak derlenmiştir.
* “Vaka - vefat oranı”, “Hasta - vefat oranı” ve “Ağır hasta - vefat oranı” Bakanlıktan alınan veriler işlenerek elde edilmiştir.
* Sayı niteliğindeki verilere dair referans aralığı tablonun sol bölümünde, oran niteliğindeki verilere dair referans aralığı ise tablonun sağ bölümünde gösterilmiştir.
* PHP ve JS ile hazırlanan ve veri görselleştirmesi için Google Charts’ın kullanıldığı grafik açık kaynak kodlu olup, GitHub üzerinden kaynak kodlarına erişilebilir.
* Aşılara dair derlenen JSON ve PHP Array formatındaki verilere grafiğin GitHub sayfasından erişilebilir. Derlenen verilerin güvenilirliği ve devamlılığı konusunda ise grafik çalışmasının bir iddiası yoktur.
* Grafikle ilgili olarak soru, öneri ve eleştiri gibi konularda mail@mertskaplan.com adresi ile iletişime geçebilirsiniz.
