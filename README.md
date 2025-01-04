```sql
CREATE TABLE Stranke (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50) NOT NULL,
    priimek VARCHAR(50) NOT NULL,
    naslov VARCHAR(255) NOT NULL,
    e_posta VARCHAR(100) NOT NULL UNIQUE
);
CREATE TABLE Zaposleni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50) NOT NULL,
    priimek VARCHAR(50) NOT NULL,
    telefonska_stevilka VARCHAR(15) NOT NULL,
    naslov VARCHAR(255) NOT NULL,
    datum_zaposlitve DATE NOT NULL,
    pozicija VARCHAR(50) NOT NULL
);
CREATE TABLE Izdelki (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime_izdelka VARCHAR(100) NOT NULL,
    kolicina INT NOT NULL,
    cena DECIMAL(10, 2) NOT NULL
);
CREATE TABLE Narocila (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_stranke INT NOT NULL,
    id_izdelka INT NOT NULL,
    kolicina INT NOT NULL,
    datum_narocila DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_stranke) REFERENCES Stranke(id),
    FOREIGN KEY (id_izdelka) REFERENCES Izdelki(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

```

# Šolski projekt - Navodila za zagon

**Avtor:** Anže Reopse  
**Datum:** 4. 1. 2025

---

## Kako zagnati projekt

1. Odprite terminal in ustvarite mapo ter se premaknite vanjo:
    ```bash
    mkdir praksa && cd praksa
    ```

2. Klonirajte repozitorij s kodo:
    ```bash
    git clone https://github.com/anze10/praksa.git
    ```

3. Premaknite mapo `praksa` v mapo `htdocs` z naslednjim ukazom v CMD:
    ```cmd
    move praksa "C:\xampp\htdocs"
    ```

4. Zaženite Apache strežnik iz CMD-ja:
    ```cmd
    cd C:\xampp
    apache_start.bat
    ```

5. V spletnem brskalniku obiščite naslednji naslov:
    ```
    http://localhost/praksa/login.php
    ```

---

Želim vam uspešno delo in lep dan! 😊
