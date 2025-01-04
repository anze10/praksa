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
```
Solski projekt 
Anze Reopse 4.1.2025

