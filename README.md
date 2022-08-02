## Penggunaan

Silahkan clone repository ini, pastikan anda bisa menjalankan perintah php di CLI (php -v)

**Konversi error.log ke JSON**
```bash
  php Loglinux.php /var/log/apache2/error.log -t json
```

**Konversi error.log ke plaintext**
```bash
  php Loglinux.php /var/log/apache2/error.log -t text
```

atau
```bash
  php Loglinux.php /var/log/apache2/error.log
```

**Menyimpan ouput kedalam sebuah file**
```bash
  php Loglinux.php /var/log/apache2/error.log -t json -o output.txt
```

atau
```bash
  php Loglinux.php /var/log/apache2/error.log -o output.txt
```