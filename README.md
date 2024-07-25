# Cloud-Storage

Bu proje, dosya yükleme ve yönetimi için kullanılan bir bulut depolama sistemidir. Kullanıcılar dosyalarını yükleyebilir, mevcut dosyaları listeleyebilir ve indirebilirler. Projede kullanılan veritabanı yapısı, dosyaların ve ilgili klasörlerin yönetimini basit ve etkili bir şekilde sağlamak amacıyla tasarlanmıştır.

## MYSQL

İlk öncelikle bir veritabanı oluşturmanız gerekmektedir. İsterseniz PhpMyAdmin üzerinden oluşturabilirsiniz. Oluşturduktan sonra isterseniz terminal üzerinden komut ile isterseniz PhpMyAdmin paneli üzerinden tek tek ilgili tabloları oluşturabilirsiniz.

```mysql
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `file_size` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

İlgili Veritabanına ait tabloyu oluşturduktan sonra Repo üzerindeki dosyalardan kendi DB bilgilerinizle değiştirmeniz gerekecektir.


## Güvenlik

İlgili sayfaya erişimi engellemek adına kullanıcı girişi kısmı tasarlanmıştır. Veritabanından gerekli kullanıcıyı oluşturup işlemleri sağlayabilirsiniz.


## Özellikler
- 10GB boyutuna kadar istediğiniz dosyayı yükleyebilirsiniz. isterseniz upload.php dosyasından bunun sınırını belirleyebilirsiniz.
- Yüklemiş olduğunuz dosyaları indirebilir veya silebilirsiniz.
- Dark mode seçeneği
- Yüklenen dosyaların toplam boyutunu ister MB ve GB cinsinden görüntüleyebilme

![image](https://github.com/user-attachments/assets/1dac720e-d816-4d30-992b-7d9d4382bd6e)


## Katkı

Katkılarınızı bekliyoruz! Herhangi bir iyileştirme veya öneri için lütfen bir sorun açın veya bir çekme isteği gönderin.



## Lisans

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Bu projeyi [MIT Lisansı](https://opensource.org/licenses/MIT) altında lisansladık. Lisansın tam açıklamasını burada bulabilirsiniz.
