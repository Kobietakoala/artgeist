#Technologie
Php 8.2
PhpUnit ^9.6

#Plik konfiguracyjny
```
 FILES_PATH - ścieżka do katalogu z plikami
 SAMPLE_FILE_NAME - nazwa pliku który chcemy odczytać
 REMOTE_URL - adres do serwera do pobrania zdalnego pliku
 MAX_SMALL_FILE_SIZE - maksymalny rozmiar 'małego pliku'
 MAX_READ_LARGE_FILE_LINE_BYTES - wielkość odczytywanych lini z 'dużego pliku'
```

#Uruchomienie
```
php index.php
```

#Testy
```
.\vendor\bin\phpunit tests
```