<?php
session_start();

// Incluir o arquivo de conexão
include('includes/database/ementas_db.php');
include('includes/database/alergenos_db.php');

// Redirect to index if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Ementas</title>
    <!-- Link para o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar de Tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-view-pratos" data-toggle="tab" href="#view-pratos" role="tab" aria-controls="view-pratos" aria-selected="true">Gerir Pratos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-view-alergenos" data-toggle="tab" href="#view-alergenos" role="tab" aria-controls="view-alergenos" aria-selected="false">Gerir Alergenos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-view-ementas" data-toggle="tab" href="#view-ementas" role="tab" aria-controls="view-ementas" aria-selected="false">Gerir Ementas</a>
            </li>
        </ul>

        <!-- Conteúdo das Tabs -->
        <div class="tab-content" id="myTabContent">
           <!-- Aba de Ver Pratos -->
            <div class="tab-pane fade show active" id="view-pratos" role="tabpanel" aria-labelledby="tab-view-pratos">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>ID</th><th>Designação</th><th>Alergenos</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    <?php if ($resultPratos->num_rows > 0): ?>
                        <?php while ($row = $resultPratos->fetch_assoc()): ?>
                            <tr id="row-<?=$row['id']?>">
                                <td><?=$row['id']?></td>
                                <td>
                                    <span id="text-<?=$row['id']?>"><?=$row['designacao']?></span>
                                    <input type="text" class="form-control form-control-sm" id="input-<?=$row['id']?>" value="<?=$row['designacao']?>" style="display:none;">
                                </td>
                                <td>
                                    <span id="alergenos-text-<?=$row['id']?>">
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
                                            echo implode(', ', $alergenos_nomes);
                                        } else {
                                            echo 'Nenhum alergeno';
                                        }
                                        ?>
                                    </span>
                                    <!-- Checkboxes for editing allergens -->
                                    <div id="alergenos-edit-<?=$row['id']?>" style="display:none;" class="mt-2">
                                        <div class="border p-2 rounded">
                                            <?php
                                            $resultAlergenos->data_seek(0);
                                            while ($alergeno = $resultAlergenos->fetch_assoc()):
                                                $checked = in_array($alergeno['id'], $alergenos_prato) ? 'checked' : '';
                                            ?>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="alergenos-<?=$row['id']?>[]" id="alergeno-<?=$row['id']?>-<?=$alergeno['id']?>" value="<?=$alergeno['id']?>" <?=$checked?>>
                                                    <label class="form-check-label" for="alergeno-<?=$row['id']?>-<?=$alergeno['id']?>"><?=$alergeno['alergeno']?></label>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Default buttons (Edit and Delete) -->
                                    <div id="task-buttons-<?=$row['id']?>">
                                        <button class="btn btn-warning btn-sm btn-edit-prato" data-id="<?=$row['id']?>">Editar</button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_prato" value="<?=$row['id']?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </div>
                                    <!-- Edit mode buttons (Save and Cancel) -->
                                    <div id="edit-buttons-<?=$row['id']?>" style="display:none;">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="edit_prato_id" value="<?=$row['id']?>">
                                            <input type="hidden" name="edit_designacao" id="edit-designacao-<?=$row['id']?>">
                                            <input type="hidden" name="edit_alergenos" id="edit-alergenos-<?=$row['id']?>">
                                            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                        </form>
                                        <button class="btn btn-secondary btn-sm btn-cancel-edit" data-id="<?=$row['id']?>">Cancelar</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Nenhum prato encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Botão para mostrar formulário (Pratos) -->
            <button class="btn btn-success mb-3" id="btn-show-add-prato-form">Adicionar Prato</button>

            <!-- Formulário oculto inicialmente (Pratos) -->
            <div id="add-prato-form" style="display:none;" class="mb-4">
                <form method="POST" action="" class="mt-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="new_designacao" placeholder="Nome do prato" required>
                    </div>
                    <div class="form-group">
                        <label>Alergenos</label>
                        <div class="border p-3 rounded">
                            <?php
                            $resultAlergenos->data_seek(0);
                            while ($alergeno = $resultAlergenos->fetch_assoc()):
                            ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="alergenos[]" id="alergeno-<?=$alergeno['id']?>" value="<?=$alergeno['id']?>">
                                    <label class="form-check-label" for="alergeno-<?=$alergeno['id']?>"><?=$alergeno['alergeno']?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" id="btn-cancel-add-prato-form">Cancelar</button>
                </form>
            </div>
        </div>
            
           <!-- Aba de Ver Alergenos -->
            <div class="tab-pane fade" id="view-alergenos" role="tabpanel" aria-labelledby="tab-view-alergenos">
            <table class="table table-striped table-bordered">
            <thead>
                <tr><th>ID</th><th>Designação</th><th>Ações</th></tr>
            </thead>
            <tbody>
                <?php 
                $resultAlergenos->data_seek(0); // Reinicia o cursor
                if ($resultAlergenos->num_rows > 0): ?>
                    <?php while ($row = $resultAlergenos->fetch_assoc()): ?>
                        <tr id="row-alergeno-<?=$row['id']?>">
                            <td><?=$row['id']?></td>
                            <td>
                                <span id="text-alergeno-<?=$row['id']?>"><?=$row['alergeno']?></span>
                                <input type="text" class="form-control form-control-sm" id="input-alergeno-<?=$row['id']?>" value="<?=$row['alergeno']?>" style="display:none;">
                            </td>
                            <td>
                                <!-- Botões padrão (Editar e Eliminar) -->
                                <div id="task-buttons-alergeno-<?=$row['id']?>">
                                    <button class="btn btn-warning btn-sm btn-edit-alergeno" data-id="<?=$row['id']?>">Editar</button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_alergeno" value="<?=$row['id']?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                                <!-- Botões de edição (Salvar e Cancelar) -->
                                <div id="edit-buttons-alergeno-<?=$row['id']?>" style="display:none;">
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="edit_alergeno_id" value="<?=$row['id']?>">
                                        <input type="hidden" name="edit_alergeno" id="edit-alergeno-<?=$row['id']?>">
                                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                    </form>
                                    <button class="btn btn-secondary btn-sm btn-cancel-edit-alergeno" data-id="<?=$row['id']?>">Cancelar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">Nenhum alergeno encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

                <!-- Botão para mostrar formulário (Alergenos) -->
                <button class="btn btn-success mb-3" id="btn-show-add-alergeno-form">Adicionar Alergeno</button>

                <!-- Formulário oculto inicialmente (Alergenos) -->
                <div id="add-alergeno-form" style="display:none;" class="mb-4">
                    <form method="POST" action="" class="mt-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="alergeno" placeholder="Nome do alergeno" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cancel-add-alergeno-form">Cancelar</button>
                    </form>
                </div>
            </div>

            <!-- Aba de Ver Ementas -->
            <div class="tab-pane fade" id="view-ementas" role="tabpanel" aria-labelledby="tab-view-ementas">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>ID</th><th>Data</th><th>Prato</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    <?php if ($resultEmentas->num_rows > 0): ?>
                        <?php while ($row = $resultEmentas->fetch_assoc()): ?>
                            <tr id="row-ementa-<?=$row['id']?>">
                                <td><?=$row['id']?></td>
                                <td>
                                    <span id="text-data-<?=$row['id']?>"><?=$row['data']?></span>
                                    <input type="date" class="form-control form-control-sm" id="input-data-<?=$row['id']?>" value="<?=$row['data']?>" style="display:none;">
                                </td>
                                <td>
                                    <span id="text-prato-<?=$row['id']?>"><?=$row['designacao']?></span>
                                    <select class="form-control form-control-sm" id="input-prato-<?=$row['id']?>" style="display:none;">
                                        <option value="">Selecione um prato</option>
                                        <?php
                                        $resultPratos->data_seek(0);
                                        while ($prato = $resultPratos->fetch_assoc()):
                                            $selected = ($prato['id'] == $row['id_prato']) ? 'selected' : '';
                                        ?>
                                            <option value="<?=$prato['id']?>" <?=$selected?>><?=$prato['designacao']?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <!-- Botões padrão (Editar e Eliminar) -->
                                    <div id="task-buttons-ementa-<?=$row['id']?>">
                                        <button class="btn btn-warning btn-sm btn-edit-ementa" data-id="<?=$row['id']?>">Editar</button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_ementa" value="<?=$row['id']?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </div>
                                    <!-- Botões de edição (Salvar e Cancelar) -->
                                    <div id="edit-buttons-ementa-<?=$row['id']?>" style="display:none;">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="edit_ementa_id" value="<?=$row['id']?>">
                                            <input type="hidden" name="edit_data" id="edit-data-<?=$row['id']?>">
                                            <input type="hidden" name="edit_id_prato" id="edit-id-prato-<?=$row['id']?>">
                                            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                        </form>
                                        <button class="btn btn-secondary btn-sm btn-cancel-edit-ementa" data-id="<?=$row['id']?>">Cancelar</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Nenhuma ementa encontrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
                <!-- Botão para mostrar formulário (Ementas) -->
                <button class="btn btn-success mb-3" id="btn-show-add-ementa-form">Adicionar Ementa</button>

                <!-- Formulário oculto inicialmente (Ementas) -->
                <div id="add-ementa-form" style="display:none;" class="mb-4">
                    <form method="POST" action="" class="mt-3">
                        <div class="form-group">
                            <label for="data">Data</label>
                            <input type="date" class="form-control" name="data" required>
                        </div>
                        <div class="form-group">
                            <label for="id_prato">Prato</label>
                            <select class="form-control" name="id_prato" required>
                                <option value="">Selecione um prato</option>
                                <?php
                                // Reutiliza a query dos pratos para popular o dropdown
                                $resultPratos->data_seek(0); // Volta ao início dos resultados
                                while ($prato = $resultPratos->fetch_assoc()):
                                ?>
                                    <option value="<?=$prato['id']?>"><?=$prato['designacao']?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cancel-add-ementa-form">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="includes/logout.php" class="logout-btn">
        <img src="assets/sair.png" alt="Sair" class="img-fluid">
    </a>
    <!-- Link para o JS do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts/pratos/addbutton.js"></script>
    <script src="scripts/pratos/editbutton.js"></script>
    <script src="scripts/alergenos/addbutton.js"></script>
    <script src="scripts/alergenos/editbutton.js"></script>
    <script src="scripts/ementas/addbutton.js"></script>
    <script src="scripts/ementas/editbutton.js"></script>
    <script src="scripts/tab_persistence.js"></script>
</body>
</html>
<?php
// Fechar a conexão
$conn->close();
?>
