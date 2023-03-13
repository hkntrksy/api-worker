## Proje Hakkında
Php 8.2 kullanılarak laravel frameworkü üzerinde geliştirme yapılmıştır. Mysql ve queue işlemek için redis ihtiyacı duymaktadır.

## Kurulum
composer install komutu çalıştırılmaldır.

```bash
    composer install
```

.env dosyası oluşturulmalıdır.

```bash
    cp .env.example .env
```

.env dosyasında gerekli ayarlamalar yapılmalıdır.

Migtaion işlemleri yapılmalıdır.

```bash
    php artisan migrate --seed
```


## API Kullanımı

Register, Purchase, Check Subscription şeklinde 3 adet endpoint bulunmaktadır.  Bu endpointlerin kullanımı için aşağıdaki örneklerdeki gibi postman collection kullanılabilir.

[![Run in Postman](https://run.pstmn.io/button.svg)](https://api.postman.com/collections/4453128-07023138-cb43-40de-8254-5c1bab83b7cc?access_key=PMAT-01GVDCDKGNEK46KP8KZK5JFM6H)

### Register
Register endpointi ile device register işlemi yapılır.  Bu endpointe gelen requestlerin token bilgisi header'a Client-Token olarak set edilmelidir.  Bu token bilgisi diğer endpointlerde kullanılacaktır.

#### Request
```http
  POST /api/register
  {
      uuid:             string|required
      app_id:           string|required
      language:         string|required
      operating_system: string|required  
  }
```

### Purchase
Purchase endpointi ile device subscription işlemi yapılır.  Bu endpointe gelen requestlerin token bilgisi header'a Client-Token olarak set edilmelidir.

#### Request
```http
  POST /api/purchase
  {
       receipt: string|required
  }
```

### Check Subscription
Check Subscription endpointi ile device subscription kontrolü yapılır.  Bu endpointe gelen requestlerin token bilgisi header'a Client-Token olarak set edilmelidir.

#### Request
```http
  GET /api/check-subscription
```

##Woker Kullanımı
Queue işlemlerinin başlatılması için "app:subscription:check" komutu kullanılmalıdır. Bu komut her seferedinde default olarak 100.000 adet kaydı işlemek için kullanır. 10M üzeri işlem yapılacağı için bu işlemin parçalı bir şekilde devam etmesi gerekir.

### Örnek Kullanım
```bash
  php artisan app:subscription:check
```

## Neleri Yaptım?
- Repository pattern kullanarak kod tekrarını önledim.
- Dependency injection kullanarak kodun bağımlılıklarını azalttım.
- Purchase işlemi için factory pattern kullandım. Yerine göre adapter pattern de kullanılabilirdi.

## Neler Daha İyi Olabilirdi?
Repositoryleri sadece eloquent çalışacak şekilde ayarladım. Herhangi bir yapılandırma yapmadım. Burada yapılması gereken şeyler şunlar olabilir:
- Bazı repositoryler mongodb ile çalıştırılabilirdi. Bu duruma uygun yapılandırma yapılabilirdi.
- Check-Susbcription endpointi için cache kullanılabilirdi. Bu sayede daha az request atılabilirdi.
- Client Token olarak jwt kullanılabilirdi. Bu sayede hem güvenli hemde daha performanslı olabilirdi.
