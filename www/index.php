<?php
include('includes/database/ementas_db.php'); // Inclui a conexão e query das ementas
include('includes/database/alergenos_db.php'); // Inclui a query dos alergenos

// Função para obter o dia da semana em português
function getDiaSemana($data) {
    $dias = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
    return $dias[date('w', strtotime($data))];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ementa Semanal do bar da AAUAlg</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h1 class="text-center mb-4">Ementa Semanal do bar da AAUAlg</h1>
        <div class="row">
            <?php if ($resultEmentas->num_rows > 0): ?>
                <?php while ($row = $resultEmentas->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <?php echo getDiaSemana($row['data']); ?>
                            </div>
                            <div class="card-body">
                                <p class="date"><?php echo date('d/m/Y', strtotime($row['data'])); ?></p>
                                <p class="dish-name"><?php echo htmlspecialchars($row['designacao']); ?></p>
                                <!-- Display allergens in red -->
                                <p class="allergens text-danger">
                                    <?php
                                    $alergenos_prato = json_decode($row['alergeno_id'] ?? '[]', true);
                                    if (!empty($alergenos_prato)) {
                                        $alergenos_nomes = [];
                                        $resultAlergenos->data_seek(0);
                                        while ($alergeno = $resultAlergenos->fetch_assoc()) {
                                            if (in_array($alergeno['id'], $alergenos_prato)) {
                                                $alergenos_nomes[] = $alergeno['alergeno'];
                                            }
                                        }
                                        echo 'Alergenos: ' . implode(', ', $alergenos_nomes);
                                    } else {
                                        echo 'Sem alergenos';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Nenhuma ementa disponível no momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="signature text-center mb-4">
            <img src="/assets/aaualg.png" alt="AAUALG Signature" class="img-fluid" style="max-width: 200px;">
        </div>
    </div>

    <!-- Round button with gear icon -->
    <a href="login.php" class="settings-btn">
        <img src="assets/gear.png" alt="Painel de Admin" class="img-fluid">
    </a>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>