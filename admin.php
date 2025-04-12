<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht der Teilnehmer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            margin-top: 50px;
        }

        .table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Übersicht der Teilnehmer</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Anzahl der Gäste</th>
                <th>Teilnahme</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // الاتصال بقاعدة البيانات
            // على سبيل المثال:
            $host = "sql205.infinityfree.com";
            $db = "if0_38681738_event_registry";
            $user = "if0_38681738";
            $pass = "OazxO3tx6aEPch";
            try {
                $con = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // استعلام لاسترجاع البيانات من قاعدة البيانات
                $stmt = $con->prepare("SELECT * FROM registrations");
                $stmt->execute();
                $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $totalYes = 0;
                $totalNo = 0;
                $totalGuests = 0;
                $counter = 1;

                // عرض البيانات في جدول
                foreach ($registrations as $registration) {
                    echo "<tr>";
                    echo "<td>" . $counter++ . "</td>";
                    echo "<td>" . htmlspecialchars($registration['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($registration['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($registration['number_of_guests']) . "</td>";
                    echo "<td>" . htmlspecialchars($registration['attending']) . "</td>";
                    echo "</tr>";

                    // تحديث الإجماليات
                    if ($registration['attending'] == 'yes') {
                        $totalYes++;
                        $totalGuests += $registration['number_of_guests'];
                    } elseif ($registration['attending'] == 'no') {
                        $totalNo++;
                    }
                }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>

    <div class="total-row">
        <p><strong>Gesamtanzahl der Teilnehmer, die Ja gesagt haben: </strong><?php echo $totalYes; ?></p>
        <p><strong>Gesamtanzahl der Teilnehmer, die Nein gesagt haben: </strong><?php echo $totalNo; ?></p>
        <p><strong>Gesamtzahl der Gäste (Ja): </strong><?php echo $totalGuests; ?></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
