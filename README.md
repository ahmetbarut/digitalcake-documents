# Digitalcake Documents

Bu paket, siteye dosya veya fotoğraf yüklemek için kullanılabilir.

## Paketin Özellikleri

- Dosya yükleme.
- Dosya silme.
- Dosya güncelleme.
- Duruma göre dosya için e-posta adresi isteme ve dosyayı e-posta ile gönderme.

## Kurulum

Kurulum için `composer` gereklidir ve paket `laravel`'e göre yazılmıştır.

```shell
    composer require digitalcake/documents
```

Paketimiz kurulduktan sonra otomatik olarak `ServiceProvider`'i ekleyecektir. Paketin routing, config ve navigation dosyalarını yayınlamak için aşağıdaki komutu çalıştırın.

```shell
    php artisan vendor:publish --provider=Digitalcake\Documents\Providers\DigitalcakeDocumentServiceProvider --tag=documents
```

Bu komut, `config` dizini içerisindeki `documents.php` dosyasını, `app/Extensions` içinde `Documents` adında klasör yoksa oluşturur ve `navigation.php`, `routes.web.php`, `Lang` dosyalarını yayınlar.

Bundan sonra paket kullanıma hazır hale gelir fakat sizin kendi projenize göre şablon dosyalarını `config/documents.php` dosyasından ayarlamanız gereklidir.

Paket şuanda tam anlamıyla özelleştirme içermiyor. İlerleyen zamanlarda ihtiyaca göre daha fazlası eklenebilir.
