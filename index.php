<!DOCTYPE html>
<html lang="sl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Aplikacija - praksa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
$host = '158.180.230.254';
$user = 'username';
$password = 'Kaks123!@';
$database = 'praksa';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("<p>Trenutno ni mogoče vzpostaviti povezave z bazo. Poskusite kasneje.</p>");
}

// Funkcija za pridobivanje podatkov s pripravljenimi poizvedbami
function getStranke($conn)
{
    $stmt = $conn->prepare("SELECT id, ime, priimek, naslov, e_posta FROM Stranke");
    $stmt->execute();
    return $stmt->get_result();
}

function getZaposleni($conn)
{
    $stmt = $conn->prepare("SELECT id, ime, priimek, telefonska_stevilka, naslov, pozicija, datum_zaposlitve FROM Zaposleni");
    $stmt->execute();
    return $stmt->get_result();
}

function getIzdelki($conn)
{
    $stmt = $conn->prepare("SELECT id, ime_izdelka, kolicina, cena FROM Izdelki");
    $stmt->execute();
    return $stmt->get_result();
}

function getNarocila($conn)
{
    $stmt = $conn->prepare("SELECT id, stranka_id, izdelek_id, datum_narocila, status FROM Narocila");
    $stmt->execute();
    return $stmt->get_result();
}
?>

<body>
    <header>
        <h1>CRM Aplikacija - praksa</h1>
        <nav>
            <ul>
                <li><a href="#" onclick="showSection('stranke')">Stranke</a></li>
                <li><a href="#" onclick="showSection('zaposleni')">Zaposleni</a></li>
                <li><a href="#" onclick="showSection('izdelki')">Izdelki</a></li>
                <li><a href="#" onclick="showSection('narocila')">Naročila</a></li>
            </ul>
        </nav>
    </header>

    <main>


        <!-- Stranke -->
        <section id="stranke" class="section active">
            <h2>Upravljanje s strankami</h2>
            <form id="dodaj-stranko" action="koda.php" method="POST">
                <input type="text" name="ime" placeholder="Ime" required>
                <input type="text" name="priimek" placeholder="Priimek" required>
                <input type="text" name="naslov" placeholder="Naslov" required>
                <input type="email" name="e_posta" placeholder="E-pošta" required>
                <input type="hidden" name="operation" value="dodaj_stranko">
                <button type="submit">Dodaj stranko</button>
            </form>
            <div id="seznam-strank">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Priimek</th>
                            <th>Naslov</th>
                            <th>E-pošta</th>
                            <th>Dejanja</th>
                            <th>Dejanja2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = getStranke($conn);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <form action='koda.php' method='POST'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <td>{$row['id']}</td>
                                        <td><input type='text' name='ime' value='{$row['ime']}' required></td>
                                        <td><input type='text' name='priimek' value='{$row['priimek']}' required></td>
                                        <td><input type='text' name='naslov' value='{$row['naslov']}' required></td>
                                        <td><input type='email' name='e_posta' value='{$row['e_posta']}' required></td>
                                        <td>
                                            <input type='hidden' name='operation' value='posodobi_stranko'>
                                            <button type='submit'>Posodobi</button>
                                        </td>
                                    </form>
                                    <td>
                                        <form action='koda.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='hidden' name='operation' value='izbrisi_stranko'>
                                            <button type='submit' onclick=\"return confirm('Ste prepričani?');\">Izbriši</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Ni zapisov.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Zaposleni -->
        <section id="zaposleni" class="section">
            <h2>Upravljanje z zaposlenimi</h2>
            <form id="dodaj-zaposlenega" action="koda.php" method="POST">
                <input type="text" name="ime" placeholder="Ime" required>
                <input type="text" name="priimek" placeholder="Priimek" required>
                <input type="text" name="telefonska_stevilka" placeholder="Telefonska številka" required>
                <input type="text" name="naslov" placeholder="Naslov" required>
                <input type="date" name="datum_zaposlitve" required>
                <input type="text" name="pozicija" placeholder="Pozicija" required>
                <input type="hidden" name="operation" value="dodaj_zaposlenega">
                <button type="submit">Dodaj zaposlenega</button>
            </form>
            <div id="seznam-zaposlenih">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Priimek</th>
                            <th>Telefonska številka</th>
                            <th>Naslov</th>
                            <th>Pozicija</th>
                            <th>Datum zaposlitve</th>
                            <th>Dejanja</th>
                            <th>Dejanja2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = getZaposleni($conn);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                <form action='koda.php' method='POST'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <td>{$row['id']}</td>
                    <td><input type='text' name='ime' value='{$row['ime']}' required></td>
                    <td><input type='text' name='priimek' value='{$row['priimek']}' required></td>
                    <td><input type='text' name='telefonska_stevilka' value='{$row['telefonska_stevilka']}' required></td>
                    <td><input type='text' name='naslov' value='{$row['naslov']}' required></td>
                    <td><input type='text' name='pozicija' value='{$row['pozicija']}' required></td>
                    <td><input type='date' name='datum_zaposlitve' value='{$row['datum_zaposlitve']}' required></td>
                    <td>
                        <input type='hidden' name='operation' value='posodobi_zaposlenega'>
                        <button type='submit'>Posodobi</button>
                    </td>
                </form>
                <td>
                    <form action='koda.php' method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='operation' value='izbrisi_zaposlenega'>
                        <button type='submit' onclick=\"return confirm('Ste prepričani?');\">Izbriši</button>
                    </form>
                </td>
              </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Ni zapisov.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Izdelki -->
        <section id="izdelki" class="section">
            <h2>Upravljanje z izdelki</h2>
            <form id="dodaj-izdelek" action="koda.php" method="POST">
                <input type="text" name="ime_izdelka" placeholder="Ime izdelka" required>
                <input type="number" name="kolicina" placeholder="Količina" required>
                <input type="text" name="cena" placeholder="Cena" required>
                <input type="hidden" name="operation" value="dodaj_izdelek">
                <button type="submit">Dodaj izdelek</button>
            </form>
            <div id="seznam-izdelkov">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime izdelka</th>
                            <th>kolicina</th>
                            <th>Cena</th>
                            <th>Dejanja</th>
                            <th>Dejanja2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = getIzdelki($conn);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                <form action='koda.php' method='POST'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <td>{$row['id']}</td>
                    <td><input type='text' name='ime_izdelka' value='{$row['ime_izdelka']}' required></td>
                    <td><input type='number' name='kolicina' value='{$row['kolicina']}' required></td>
                    <td><input type='text' name='cena' value='{$row['cena']}' required></td>
                    <td>
                        <input type='hidden' name='operation' value='posodobi_izdelek'>
                        <button type='submit'>Posodobi</button>
                    </td>
                </form>
                <td>
                    <form action='koda.php' method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='operation' value='izbrisi_izdelek'>
                        <button type='submit' onclick=\"return confirm('Ste prepričani?');\">Izbriši</button>
                    </form>
                </td>
              </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Ni zapisov.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Naročila -->
        <section id="narocila" class="section">
            <h2>Upravljanje z naročili</h2>
            <form id="dodaj-narocilo" action="koda.php" method="POST">
                <input type="text" name="id_stranke" placeholder="ID stranke" required>
                <input type="text" name="id_izdelka" placeholder="ID izdelka" required>
                <!-- <input type="number" name="kolicina" placeholder="Količina" required> -->
                <input type="hidden" name="operation" value="dodaj_narocilo">
                <button type="submit">Dodaj naročilo</button>
            </form>
            <div id="seznam-narocil">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Stranka ID</th>
                            <th>Izdelek ID</th>
                            <th>Datum naročila</th>
                            <th>Status</th>
                            <th>Dejanja</th>
                            <th>Dejanja2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = getNarocila($conn);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                        <tr>
                                             <td>{$row['id']}</td>
                                           
                                                <form action='koda.php' method='POST'>
                                                     <input type='hidden' name='id' value='{$row['id']}'> 
                                                   <td> <input type='text' name='stranka_id' value='{$row['stranka_id']}' required> </td>
                                                    <td><input type='text' name='izdelek_id' value='{$row['izdelek_id']}' required></td>
                                                   <td ><input type='date' name='datum_narocila' value='{$row['datum_narocila']}' required> </td>
                                                   <td> <input type='text' name='status' value='{$row['status']}' required> </td>
                                                   <td> <input type='hidden' name='operation' value='posodobi_narocilo'>
                                                    <button type='submit'>Posodobi</button>
                                                    </td>
                                                </form>
                                            
                                            <td>
                                                <form action='koda.php' method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='operation' value='izbrisi_narocilo'>
                                                    <button type='submit' onclick=\"return confirm('Ste prepričani?');\">Izbriši</button>
                                                </form>
                                                

                                            </td>
                                        </tr>";
                            }
                        } else {
                            echo "
                                    <tr>
                                        <td colspan='6'>Ni zapisov.</td>
                                    </tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 CRM Aplikacija - praksa</p>
    </footer>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSection('stranke');
        });
    </script>
</body>

</html>