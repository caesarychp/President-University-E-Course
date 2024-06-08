<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `databanks`");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>

<style>
     .popup {
        width: 465px;
        height: 600px;
        background: #fff;
        border-radius: 5px;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.1);
        text-align: center;
        padding: 0 30px 30px;
        color: var(--jay, #fff);
        visibility: hidden;
        transition: transform 0.4s, top 0.4s;
    }

    .open-popup {
        visibility: visible;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1);
    }
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }

    .div {
        /* background-color: var(--jay, #ffffff); */
        display: flex;
        max-width: 463px;
        padding-bottom: 22px;
        flex-direction: column;
        font-size: 20px;
    }

    .div-2 {
        font-family: Roboto Slab, sans-serif;
        align-items: start;
        background-color: #293352;
        width: 100%;
        color: var(--puis-president-ac-id-12633333740234375-x-5413333129882812-default-nero,
                var(--jay, #fff));
        font-weight: 400;
        line-height: 120%;
        justify-content: center;
        padding: 24px 29px;
    }

    .div-3 {
        display: flex;
        margin-top: 25px;
        width: 100%;
        flex-direction: column;
        color: #000;
        font-weight: 300;
        padding: 0 44px;
    }

    .div-4 {
        justify-content: center;
        background-color: #dcdcdc;
        align-self: center;
        white-space: nowrap;
        text-align: center;
        text-transform: uppercase;
        padding: 18px 51px;
        font: 700 24px/100% Merriweather Sans, -apple-system, Roboto, Helvetica,
            sans-serif;
    }

    .div-5 {
        font-family: Roboto, sans-serif;
        margin-top: 12px;
    }

    .div-6 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 16px;
        width: 400px;
        max-width: 100%;
        height: 61px;
    }

    .div-7 {
        display: flex;
        margin-top: 10px;
        gap: 20px;
        justify-content: space-between;
    }

    .div-8 {
        display: flex;
        flex-direction: column;
    }

    .div-9 {
        font-family: Roboto, sans-serif;
    }

    .div-10 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 10px;
        height: 60px;
        width: 200px;
    }

    .div-11 {
        display: flex;
        flex-direction: column;
        white-space: nowrap;
    }

    .div-12 {
        font-family: Roboto, sans-serif;
    }

    .div-13 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        height: 60px;
        margin: 10px 0 0 -3px;
        width: 160px;
    }

    .div-14 {
        font-family: Roboto, sans-serif;
        margin-top: 12px;
    }

    .div-15 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 16px;
        width: 374px;
        max-width: 100%;
        height: 59px;
    }

    .div-16 {
        font-family: Roboto Slab, sans-serif;
        background-color: #293352;
        align-self: center;
        margin-top: 19px;
        border-radius: 10px;
        width: 174px;
        max-width: 100%;
        align-items: center;
        position: center;
        color: var(--jay, #fff);
        font-weight: 400;
        white-space: nowrap;
        text-align: center;
        line-height: 120%;
        justify-content: center;
        padding: 22px 60px;
    }

    .div-17 {
        justify-content: center;
    }
</style>

<div class="div">
    <div class="div-3">
        <?php
        // include_once "conn.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // $databanks = $_POST['databanksID'];
            $cardNumber = $_POST['card-number'];
            $expiredDate = $_POST['expired-date'];
            $cvv = $_POST['cvv'];
            $cardOwner = $_POST['card-owner'];
            $bank = $_POST['banks'];

            // Validasi data
            $errors = [];
            if (empty($cardNumber) || empty($expiredDate) || empty($cvv) || empty($cardOwner) || empty($bank)) {
                $errors[] = "Semua data wajib diisi!";
            }
            // if (empty($errors)) {
            //     // Buat koneksi ke database (ganti dengan koneksi sesuai dengan implementasi Anda)
            //     $conn = new mysqli("localhost", "username", "password", "ebusiness2");
        
            //     // Periksa koneksi
            //     if ($conn->connect_error) {
            //         die("Koneksi database gagal: " . $conn->connect_error);
            //     }
            // $databanks = $conn->real_escape_string($databanks);
            $cardNumber = $conn->real_escape_string($cardNumber);
            $expiredDate = $conn->real_escape_string($expiredDate);
            $cvv = $conn->real_escape_string($cvv);
            $cardOwner = $conn->real_escape_string($cardOwner);
            $bank = $conn->real_escape_string($bank);

            if (empty($errors)) {
                $sql = "INSERT INTO databanks (' ', CardNumber, ExpiredDate, CVV, CardOwner, BanksID) 
                    VALUES (' ', '$cardNumber', '$expiredDate', '$cvv', '$cardOwner' , (SELECT BanksID FROM banks WHERE BanksName='$bank'))";

                    // if ($conn->query($sql) === TRUE) {
                    // Redirect to invoicesbanks.php after saving data to the database
                    // header("Location: http://localhost/admin_dashboard-2\admin_dashboard\admin\payment\invoicesbanks.php?BanksID=$bank");
                    // exit;
                if ($conn->query($sql) === TRUE) {
                        echo "Data pembayaran berhasil disimpan.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            }
        }

        // Mengambil nama bank berdasarkan ImageLink
        if (isset($_GET['banks'])) {
            $clickedImage = $_GET['banks'];
            $sql_bank = "SELECT BanksName FROM banks WHERE ImageLink = '$clickedImage'";
            $result_bank = mysqli_query($conn, $sql_bank);

            if ($result_bank) {
                $row_bank = mysqli_fetch_assoc($result_bank);
                $nama_bank = $row_bank['BanksName'];
            } else {
                $nama_bank = "Nama Bank Tidak Ditemukan";
            }
        } else {
            $nama_bank = "Bank Tidak Dipilih";
        }

        ?>

        <form method="post" action="">
            <input type="hidden" name="banks" id="banks" value="<?php echo isset($_GET['banks']) ? $_GET['banks'] : $nama_bank ; ?>">
            <!-- <div class="div-3"> -->

            <!-- muncul nama bank, data dari table banks -->
            
            <div>
                <!-- <div id="nama-bank"> -->
                <!-- <//?php echo $nama_bank ?>  -->
            <!-- </div> -->
                <div class="div-5">Card Number</div>
                <input class="div-6" type="text" id="card-number" name="card-number" placeholder="Card Number" required></input>
                <div class="div-7">
                    <div class="div-8">
                        <div class="div-9">Expired Date</div>
                        <input class="div-10" type="text" id="expired-date" name="expired-date" placeholder="MM/DD" required></input>
                    </div>
                    <div class="div-11">
                        <div class="div-12">CVV</div>
                        <input class="div-13" type="text" id="cvv" name="cvv" placeholder="CVV" required></input>
                    </div>
                </div>
                <div class="div-14">Card Owner</div>
                <input class="div-15" type="text" id="card-owner" name="card-owner" placeholder="Card Owner" required></input>

            </div>
    </div>
    <!-- <div class="div-17"> -->
    <!-- <button type="submit" id="bt_pay" class="div-16">PAY</button> -->
    <button onclick="submitPayment()" class="div-16">PAY</button>
</div>

</form>
</div>
</div>
<div id="invoices-container"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function submitPayment() {
        // Mengambil nilai dari input
        var bank = document.getElementById('banks').value;
        var cardNumber = document.getElementById('card-number').value;
        var expiredDate = document.getElementById('expired-date').value;
        var cvv = document.getElementById('cvv').value;
        var cardOwner = document.getElementById('card-owner').value;

        // Melakukan AJAX POST request untuk menyimpan data pembayaran ke database
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                // databanksID: bank,
                'card-number': cardNumber,
                'expired-date': expiredDate,
                cvv: cvv,
                'card-owner': cardOwner,
                banks: bank
                // bank: bank,
                // cardNumber: cardNumber,
                // expiredDate: expiredDate,
                // cvv: cvv,
                // cardOwner: cardOwner,
                // banksID: <//?php echo $banksID; ?> // Variabel banksID dari PHP
            },
            success: function(response) {
                // Memuat halaman invoicesbanks.php ke dalam div
                $('#invoices-container').load('payment/invoicesbanks.php');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Menampilkan pesan error jika terjadi kesalahan
            }
    });
    }
</script>