
# Türkiye'de günlük Covid-19 aşı, vaka, hasta ve ölüm grafiği

> **covid19tr** - v1.3
> 
> https://lab.mertskaplan.com/covid19tr


### Grafik bilgi notu

1.  **Grafik**, Türkiye’ye dair **Sağlık Bakanlığı**nın paylaştığı **Covid-19** verilerinin tek bir tablo üzerinde görselleştirmesi amacıyla hazırlanmıştır. Ancak aşılama sayılarının milyonlarla, vefat sayılarının ise yüzlerle ifade edilmesi gibi nedenlerle tüm veriler tek tablo üzerinde anlamlı bir sonuç oluşturamadığı için anlamlı okumaların yapılabilmesi için belirli veri setleri gizlenerek dört sekme oluşturulmuştur.
2.  Günlük **Covid-19** vaka, hasta ve vefat sayısı gibi veriler Sağlık Bakanlığının yayımladığı [Genel Koronavirüs Tablosu](https://covid19.saglik.gov.tr/TR-66935/genel-koronavirus-tablosu.html)’ndan **anlık ve otomatik** olarak çekilmektedir.
3.  Aşılama sayıları ile ilgili olarak Bakanlık tarafından sadece toplam aşı miktarları paylaşıldığı için birinci ve ikinci doz aşılara dair günlük aşılama sayıları Bakanlığın [covid19asi.saglik.gov.tr](https://covid19asi.saglik.gov.tr) adresli internet sitesinin [The Wayback Machine](https://web.archive.org/web/*/https://covid19asi.saglik.gov.tr/) üzerindeki ilgili güne dair son kaydı esas alınarak, üçüncü doz aşılara dair günlük aşılama sayıları ise yine Bakanlığın [covid19.saglik.gov.tr](https://covid19.saglik.gov.tr) adresli internet sitesinin [The Wayback Machine](https://web.archive.org/web/*/https://covid19.saglik.gov.tr/) üzerindeki ilgili güne dair son kaydı esas alınarak **derlenmiştir.**
4.  _“Vaka - vefat oranı”, “Hasta - vefat oranı”_, _“Ağır hasta - vefat oranı”_ ve uygulanan aşı dozu sayısının 18 yaş ve üstü nüfusa oranı, Bakanlıktan ve [TÜİK](https://data.tuik.gov.tr/Bulten/Index?p=Istatistiklerle-Cocuk-2020-37228)'ten alınan veriler işlenerek elde edilmiştir.
5.  Sayı niteliğindeki verilere dair referans aralığı tablonun sol bölümünde, oran niteliğindeki verilere dair referans aralığı ise tablonun sağ bölümünde gösterilmiştir.
6.  **PHP** ve **JS** ile hazırlanan ve veri görselleştirmesi için **Google Charts**’ın kullanıldığı grafik açık kaynak kodlu olup, [GitHub](https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi) üzerinden kaynak kodlarına erişilebilir.
7.  Aşılara dair derlenen [JSON](https://raw.githubusercontent.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/main/vaccine.json) ve [Excel](https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/blob/main/vaccine.xlsx?raw=true) formatındaki verilere grafiğin GitHub sayfasından erişilebilir. Veriler Bakanlığın standartlarına(!) uygun olarak hazırlanmıştır ve verilerin güvenilirliği ile devamlılığı konusunda grafik çalışmasının bir iddiası yoktur.
8.  Grafikle ilgili olarak soru, öneri ve eleştiri gibi konularda aşağıdaki kanallar üzerinden iletişime geçebilirsiniz.

### İletişim
Web: [mertskaplan.com](http://mertskaplan.com) | Mail: mail@mertskaplan.com | Twitter: [@mertskaplan](https://twitter.com/mertskaplan)

### Lisans
İçerik [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/ "Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International"), kaynak kodları [MIT](https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/blob/main/LICENSE "Massachusetts Institute of Technology License") lisansı altındadır.

### Sürüm notları
##### v1.3 - 04.08.2021
* Sağlık Bakanlığı tarafından sağlanan tüm veriler JSON formatında kullanılabilir hale getirildi.
* CSS kodları ayrı bir dosyaya taşındı.
* Bakanlığın 3 Temmuz 2021'den sonra veri paylaşmayı terk ettiği toplam test, toplam hasta, toplam vefat ve toplam iyilesen sayıları başlıkları için eksik verilerin otomatik olarak hesaplanması sağlandı.
* Bakanlığın vaka ve hasta sayılarını açıkladığı ve açıklamayı terk ettiği tarihler göz önünde bulundurularak toplam vaka/hasta sayısından toplam iyileşen sayısı ve toplam vefat sayısı çıkarılarak o güne dair aktif vaka/hasta sayısı hesaplandı.
* Günlük vaka değişim oranı verisi eklendi.
* Grafik bölümlerinin işaret ettiği veri türleri bilgisi eklendi.
* Yeni veriler ilgili ilgili açıklamalar eklendi.
##### v1.2 - 21.07.2021
* Standardın sağlanabilmesi için *"php array"* dosyası terk edilerek veriler *JSON* formatında ve *GitHub* üzerinden içe aktarıldı. [[↑](https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/commit/b72bff2b5b3ac8cca20be02d1b9d9ab7eb40048f)]
##### v1.1 - 18.07.2021
* Aşılama verilerinin nüfusa oranı grafiğe eklendi. [[↑](https://github.com/mertskaplan/turkiyede-gunluk-covid-19-grafigi/commit/634957313136a3ff0c20ee47e7b25f11dd200d86)]
