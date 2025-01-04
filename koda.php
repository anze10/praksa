<?php
// Povezava z bazo
$host = '158.180.230.254';
$user = 'username';
$password = 'Kaks123!@';
$database = 'praksa';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("<p>Trenutno ni mogoče vzpostaviti povezave z bazo. Poskusite kasneje.</p>");
}

// Preveri, katera operacija je poslana prek obrazca
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'] ?? '';

    switch ($operation) {
        case 'dodaj_stranko':
            dodajStranko($conn);
            break;
        case 'posodobi_stranko':
            posodobiStranko($conn);
            break;
        case 'izbrisi_stranko':
            izbrisiStranko($conn);
            break;
        case 'dodaj_zaposlenega':
            dodajZaposlenega($conn);
            break;
        case 'posodobi_zaposlenega':
            posodobiZaposlenega($conn);
            break;
        case 'izbrisi_zaposlenega':
            izbrisiZaposlenega($conn);
            break;
        case 'dodaj_izdelek':
            dodajIzdelek($conn);
            break;
        case 'posodobi_izdelek':
            posodobiIzdelek($conn);
            break;
        case 'izbrisi_izdelek':
            izbrisiIzdelek($conn);
            break;
        case 'dodaj_narocilo':
            dodajNarocilo($conn);
            break;
        case 'posodobi_narocilo':
            posodobiNarocilo($conn);
            break;
        case 'izbrisi_narocilo':
            izbrisiNarocilo($conn);
            break;
    }
}

function dodajStranko($conn)
{
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $naslov = $_POST['naslov'];
    $e_posta = $_POST['e_posta'];

    $stmt = $conn->prepare("INSERT INTO Stranke (ime, priimek, naslov, e_posta) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ime, $priimek, $naslov, $e_posta);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri dodajanju stranke: " . $stmt->error;
    }
}

function posodobiStranko($conn)
{
    $id = $_POST['id'];
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $naslov = $_POST['naslov'];
    $e_posta = $_POST['e_posta'];

    $stmt = $conn->prepare("UPDATE Stranke SET ime = ?, priimek = ?, naslov = ?, e_posta = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $ime, $priimek, $naslov, $e_posta, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri posodabljanju stranke: " . $stmt->error;
    }
}

function preveriPovezave($conn, $id)
{
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM Narocila WHERE stranka_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['cnt'] > 0;
}

function izbrisiStranko($conn)
{
    $id = $_POST['id'];
    if (preveriPovezave($conn, $id)) {
        echo "Napaka: Stranke ni mogoče izbrisati, ker ima povezane zapise.";
        return;
    }

    $stmt = $conn->prepare("DELETE FROM Stranke WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri brisanju stranke: " . $stmt->error;
    }
}


function dodajZaposlenega($conn)
{
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $telefonska_stevilka = $_POST['telefonska_stevilka'];
    $naslov = $_POST['naslov'];
    $pozicija = $_POST['pozicija'];
    $datum_zaposlitve = $_POST['datum_zaposlitve'];

    $stmt = $conn->prepare("INSERT INTO Zaposleni (ime, priimek, telefonska_stevilka, naslov, pozicija, datum_zaposlitve) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ime, $priimek, $telefonska_stevilka, $naslov, $pozicija, $datum_zaposlitve);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri dodajanju zaposlenega: " . $stmt->error;
    }
}

function posodobiZaposlenega($conn)
{
    $id = $_POST['id'];
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $telefonska_stevilka = $_POST['telefonska_stevilka'];
    $naslov = $_POST['naslov'];
    $pozicija = $_POST['pozicija'];
    $datum_zaposlitve = $_POST['datum_zaposlitve'];

    $stmt = $conn->prepare("UPDATE Zaposleni SET ime = ?, priimek = ?, telefonska_stevilka = ?, naslov = ?, pozicija = ?, datum_zaposlitve = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $ime, $priimek, $telefonska_stevilka, $naslov, $pozicija, $datum_zaposlitve, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri posodabljanju zaposlenega: " . $stmt->error;
    }
}

function izbrisiZaposlenega($conn)
{
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM Zaposleni WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri brisanju zaposlenega: " . $stmt->error;
    }
}

function dodajIzdelek($conn)
{
    $ime = $_POST['ime_izdelka'];
    $kolicina = $_POST['kolicina'];
    $cena = $_POST['cena'];

    $stmt = $conn->prepare("INSERT INTO Izdelki (ime_izdelka, kolicina, cena) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $ime, $kolicina, $cena);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri dodajanju izdelka: " . $stmt->error;
    }
}

function posodobiIzdelek($conn)
{
    $id = $_POST['id'];
    $ime = $_POST['ime_izdelka'];
    $kolicina = $_POST['kolicina'];
    $cena = $_POST['cena'];

    $stmt = $conn->prepare("UPDATE Izdelki SET ime_izdelka = ?, kolicina = ?, cena = ? WHERE id = ?");
    $stmt->bind_param("sdii", $ime, $kolicina, $cena, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri posodabljanju izdelka: " . $stmt->error;
    }
}

function izbrisiIzdelek($conn)
{
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM Izdelki WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri brisanju izdelka: " . $stmt->error;
    }
}

function dodajNarocilo($conn)
{
    $id_stranke = $_POST['id_stranke'];
    $id_izdelka = $_POST['id_izdelka'];
    $datum_narocila = date('Y-m-d H:i:s');
    $status = 'V obdelavi';

    $stmt = $conn->prepare("INSERT INTO Narocila (stranka_id, izdelek_id, datum_narocila, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_stranke, $id_izdelka, $datum_narocila, $status);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri dodajanju naročila: " . $stmt->error;
    }
}

function posodobiNarocilo($conn)
{
    $id = $_POST['id'];
    $stranka_id = $_POST['stranka_id'];
    $izdelek_id = $_POST['izdelek_id'];
    $datum_narocila = $_POST['datum_narocila'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE Narocila SET stranka_id = ?, izdelek_id = ?, datum_narocila = ?, status = ? WHERE id = ?");
    $stmt->bind_param("iissi", $stranka_id, $izdelek_id, $datum_narocila, $status, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri posodabljanju naročila: " . $stmt->error;
    }
}

function izbrisiNarocilo($conn)
{
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM Narocila WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Napaka pri brisanju naročila: " . $stmt->error;
    }
}
?>