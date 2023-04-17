<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Przedszkole "Pszczółka"</title>
    <link rel="stylesheet" href="css.css">
    <script src="index.js"></script>
</head>

<body>
    <?php include("connection.php");
    session_start();
    if(isset($_GET['grupa']) && is_numeric($_GET['grupa'])){
        $_SESSION['grupa'] = $_GET['grupa'];
    }
    if(isset($_GET['wychowawca']) && is_numeric($_GET['wychowawca'])){
        $_SESSION['wychowawca'] = $_GET['wychowawca'];
    }
    if(isset($_GET['form']) && is_numeric($_GET['form'])){
        $_SESSION['form'] = $_GET['form'];
    }
    ?>
    <div id="baner">
        <a href="index.php"><img src="logo.png" alt="Przedszkole Pszczółka"></a>
    </div>
    <div id="lewyPanel">
        <h1>Dzieci według grupy</h1>
        <form id="grupy" action="index.php" method="get">
            <div class="box" id="grupaSelect">
                <select onchange="grupy.submit()" name="grupa">
                    <option value="">---</option>
                    <?php
            $sql = "SELECT id_grupy,NazwaGrupy FROM grupy";
            $result = mysqli_query($connection,$sql);
            while($row = mysqli_fetch_array($result)){
                if(isset($_SESSION['grupa']) && $row['id_grupy']==$_SESSION['grupa']){
                echo "<option selected value='",
                $row['id_grupy'],
                "'>",
                $row['NazwaGrupy'],
                "</option>"; 
                } else {
                echo "<option value='",
                $row['id_grupy'],
                "'>",
                $row['NazwaGrupy'],
                "</option>"; 
                }
            }
            ?>
                </select>
            </div>
        </form>
        <div id="dzieciTabela">
            <?php
            if(isset($_SESSION['grupa'])){
            $grupa = $_SESSION['grupa'];
            $sql = "SELECT Imie,Nazwisko FROM dzieci WHERE id_grupy='$grupa'";
            $result = mysqli_query($connection,$sql);
            echo "<table>",
                 "<thead>",
                 "<tr>",
                 "<th>Lp.</th>",
                 "<th>Imie</th>",
                 "<th>Nazwisko</th>",
                 "</tr>",
                 "</thead>",
                 "<tbody>";
            $i=1;
            while($row =  mysqli_fetch_array($result)){
                echo "<tr>",
                "<td>",$i,"</td>",
                "<td>",$row['Imie'],"</td>",
                "<td>",$row['Nazwisko'],"</td>",
                "</tr>";
                $i++;
            }
            echo "</tbody>",
                 "</table>";
            }
            ?>
        </div>
    </div>
    <div id="srodkowyPanel">
        <h1>Nauczyciele i jego grupa</h1>
        <form id="wychowawcy" action="index.php" method="get">
            <div class="box" id="wychowawcySelect">
                <select onchange="wychowawcy.submit()" name="wychowawca">
                    <option value="">---------------------</option>
                    <?php
            $sql = "SELECT id_wychowawcy,Imie,Nazwisko FROM wychowawcy";
            $result = mysqli_query($connection,$sql);
            while($row = mysqli_fetch_array($result)){
                if(isset($_SESSION['wychowawca']) && $_SESSION['wychowawca']==$row['id_wychowawcy']){
                echo "<option selected value='",
                $row['id_wychowawcy'],
                "'>",
                $row['Imie'],
                " ",
                $row['Nazwisko'],
                "</option>";  
                } else {
                echo "<option value='",
                $row['id_wychowawcy'],
                "'>",
                $row['Imie'],
                " ",
                $row['Nazwisko'],
                "</option>";
                }
            }
            ?>
                </select>
            </div>
        </form>
        <div id="wychowawcaTabela">
            <?php
            if(isset($_SESSION['wychowawca'])){
              $wychowawca = $_SESSION['wychowawca'];
              echo "<table>";
              $sql = "SELECT id_grupy,NazwaGrupy FROM grupy WHERE id_wychowawcy=$wychowawca";
              $result = mysqli_query($connection,$sql);
              if($row = mysqli_fetch_array($result)){
                  $idGrupy = $row['id_grupy'];
                  $nazwaGrupy = $row['NazwaGrupy'];
              }
              $sql = "SELECT COUNT(*) FROM dzieci WHERE id_grupy=$idGrupy";
              $result = mysqli_query($connection,$sql);
              if($row = mysqli_fetch_array($result)){
                  $iloscDzieci = $row['COUNT(*)'];
              }
              echo "<tr>",
              "<th>","Nazwa grupy:","</th>",
              "<td>",$nazwaGrupy,"</td>",
              "</tr>",
              "<tr>",
              "<th>","Ilość dzieci:","</th>",
              "<td>",$iloscDzieci,"</td>",
              "</tr>";                  
              echo "</table>",
                   "</div>",
                   "<h5>","Inne grupy","</h5>",
                   "<div id='wychowawcaInne'>", 
                   "<table>",
                   "<thead>";          
              echo "<tr>",
              "<th>","Lp.","</th>",
              "<th>","Nazwa grupy","</th>",
              "<th>","Ilość dzieci","</th>",
              "</tr>",
              "</thead>",
              "<tbody>";
              $sql = "SELECT g.NazwaGrupy,COUNT(d.id_dziecka) FROM grupy g INNER JOIN dzieci d ON d.id_grupy=g.id_grupy WHERE g.id_grupy <> $idGrupy GROUP BY g.NazwaGrupy ";
              $result = mysqli_query($connection,$sql);
              $i=1;
              while($row = mysqli_fetch_array($result)){
                  echo "<tr>",
                  "<td>",$i,"</td>",
                  "<td>",$row['NazwaGrupy'],"</td>",
                  "<td>",$row['COUNT(d.id_dziecka)'],"</td>",
                  "</tr>";
                  $i++;
              }
              echo "</tbody>",
                   "</table>";
            }
            ?>
        </div>
    </div>
    <div id="prawyPanel">
        <h1>Dodawnie dziecka i rodzica</h1>
        <a id="aForm1" href="index.php?form=1">Dodaj rodzica</a>
        <a id="aForm2" href="index.php?form=2">Dodaj dziecko</a>
        <div id="formRodzica">
            <h5>Dodawanie rodzica</h5>
            <form method="post" action="dodajRodzicaDoBazy.php">
                <label class="error" id="errorRodzicZajety">Rodzic już jest w bazie</label>
                <label class="error" id="errorRodzicImie">Wprowadź poprawne imię</label>
                <input type="text" name="imieRodzica" id="imieRodzica" placeholder="Imię" required <?php if(isset($_SESSION['rodzicInfo'])){$imie = $_SESSION['rodzicInfo']['imie'];echo "value='$imie'";} ?>>
                <label class="error" id="errorRodzicNazwisko">Wprowadź poprawne nazwisko</label>
                <input type="text" name="nazwiskoRodzica" id="nazwiskoRodzica" placeholder="Nazwisko" required <?php if(isset($_SESSION['rodzicInfo'])){$nazwisko = $_SESSION['rodzicInfo']['nazwisko'];echo "value='$nazwisko'";} ?>>
                <input type="submit" value="Dodaj rodzica">
            </form>
        </div>
        <div id="formDziecka">
            <h5>Dodawanie dziecka</h5>
            <form method="post" action="dodajDzieckoDoBazy.php">
                <label class="error" id="errorDzieckoZajete">PESEL jest już w bazie</label>
                <label class="error" id="errorDzieckoImie">Wprowadź poprawne imię</label>
                <input type="text" name="imieDziecka" id="imieDziecka" placeholder="Imię" required <?php if(isset($_SESSION['dzieckoInfo'])){$imie = $_SESSION['dzieckoInfo']['imie'];echo "value='$imie'";} ?>>
                <label class="error" id="errorDzieckoNazwisko">Wprowadź poprawne nazwisko</label>
                <input type="text" name="nazwiskoDziecka" id="nazwiskoDziecka" placeholder="Nazwisko" required <?php if(isset($_SESSION['dzieckoInfo'])){$nazwisko = $_SESSION['dzieckoInfo']['nazwisko'];echo "value='$nazwisko'";} ?>>
                <label class="error" id="errorDzieckoNiepoprawnyPesel">Wprowadź poprawny PESEL</label>
                <label class="error" id="errorDzieckoNiepoprawnyPeselData">Tylko dzieci od 3 do 7 lat mogą uczęszczać do przedszkola!</label>
                <input type="text" name="peselDziecka" id="peselDziecka" placeholder="PESEL" required <?php if(isset($_SESSION['dzieckoInfo'])){$pesel = $_SESSION['dzieckoInfo']['pesel'];echo "value='$pesel'";} ?>>
                <select name="grupaDziecka" required>
                    <option value="">Wybierz grupę</option>
                    <?php
                $sql = "SELECT id_grupy,NazwaGrupy FROM grupy";
                $result = mysqli_query($connection,$sql);
                while($row = mysqli_fetch_array($result)){
                if(isset($_SESSION['dzieckoInfo']) && $row['id_grupy']==$_SESSION['dzieckoInfo']['grupaId']){
                echo "<option selected value='",
                $row['id_grupy'],
                "'>",
                $row['NazwaGrupy'],
                "</option>";
                } else {
                echo "<option value='",
                $row['id_grupy'],
                "'>",
                $row['NazwaGrupy'],
                "</option>";
                }
                }
                ?>
                </select>
                <select name="rodzicDziecka" required>
                    <option value="">Wybierz rodzica</option>
                    <?php
                $sql = "SELECT id_rodzica,Imie,Nazwisko FROM rodzice";
                $result = mysqli_query($connection,$sql);
                while($row = mysqli_fetch_array($result)){
                if(isset($_SESSION['dzieckoInfo']) && $row['id_rodzica']==$_SESSION['dzieckoInfo']['rodzicId']){
                echo "<option selected value='",
                $row['id_rodzica'],
                "'>",
                $row['Imie'],
                " ",
                $row['Nazwisko'],
                "</option>";
                } else {
                echo "<option value='",
                $row['id_rodzica'],
                "'>",
                $row['Imie'],
                " ",
                $row['Nazwisko'],
                "</option>"; 
                }
                }
                ?>
                </select>
                <input type="submit" value="Dodaj ucznia">
            </form>
        </div>
    </div>
    <div id="stopka">
        Wykonał: Mateusz Poczta oraz Przemysław Jasiaczyk
    </div>
    <?php
    if(isset($_SESSION['rodzicInfo'])){
        unset($_SESSION['rodzicInfo']);
    }
    if(isset($_SESSION['dzieckoInfo'])){
        unset($_SESSION['dzieckoInfo']);
    }
    if(isset($_SESSION['form'])){
        if($_SESSION['form'] == 1){
            echo '<script type="text/javascript">',
                 'pokazFormularz("formRodzica");',
                 '</script>';
        } else if($_SESSION['form'] == 2){
            echo '<script type="text/javascript">',
                 'pokazFormularz("formDziecka");',
                 '</script>';
        }
    }
    if(isset($_GET['error'])){
       switch($_GET['error']){
           case 1:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorRodzicImie");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("imieRodzica");',
                    '</script>';
               break;
            case 2:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorRodzicNazwisko");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("nazwiskoRodzica");',
                    '</script>';
               break;
            case 3:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorRodzicZajety");',
                    '</script>';
               break;
            case 4:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorDzieckoImie");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("imieDziecka");',
                    '</script>';
               break;
            case 5:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorDzieckoNazwisko");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("nazwiskoDziecka");',
                    '</script>';
               break;
            case 6:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorDzieckoNiepoprawnyPesel");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("peselDziecka");',
                    '</script>';
               break;
            case 7:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorDzieckoNiepoprawnyPeselData");',
                    '</script>';
               echo '<script type="text/javascript">',
                    'zmienKolorNaBlad("peselDziecka");',
                    '</script>';
               break;
            case 8:
               echo '<script type="text/javascript">',
                    'pokazBlad("errorDzieckoZajete");',
                    '</script>';
               break;
           default:
               break;
       } 
    }
    ?>
</body>

</html>

