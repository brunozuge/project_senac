<?php
include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
include_once('navbar.php');

// Fetch cargo information
$cargos = busca_info_bd($conexao, 'cargo');

// Get current user cargo if available
$id_cargo = $_GET['id_cargo'] ?? '';

// Function to fetch menu options by level
function getMenuOptions($conexao, $parentId = null) {
    $whereClause = $parentId === null ? 
                  "nivelOpcao = 1" : 
                  "idSuperior = " . intval($parentId);
    
    $sql = "SELECT
              o.idOpcao,
              o.descricaoOpcao,
              o.nivelOpcao,
              o.urlOpcao,
              o.statusOpcao,
              n.descricaoNivel,
              u.usuario
            FROM opcoes_menu o
            LEFT JOIN nivel_acesso n ON n.idNivel = o.nivelOpcao
            LEFT JOIN usuario u ON u.idUsuario = o.idUsuario
            WHERE $whereClause
            ORDER BY o.descricaoOpcao";
            
    $result = mysqli_query($conexao, $sql);
    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Build menu hierarchy
function buildMenuHierarchy($conexao) {
    $menuHierarchy = [];
    $topOptions = getMenuOptions($conexao);
    
    foreach ($topOptions as $option) {
        $optionId = $option['idOpcao'];
        $menuHierarchy[$optionId] = [
            'DESCR_OPCAO' => $option['descricaoOpcao'],
            'NIVEL_OPCAO' => $option['nivelOpcao'],
            'URL_OPCAO' => $option['urlOpcao'],
            'STATUS_OPCAO' => $option['statusOpcao'],
            'DESCR_NIVEL' => $option['descricaoNivel'],
            'SUB_OPCOES' => []
        ];
        
        // Get second level options
        $secondLevel = getMenuOptions($conexao, $optionId);
        foreach ($secondLevel as $subOption) {
            $subId = $subOption['idOpcao'];
            $menuHierarchy[$optionId]['SUB_OPCOES'][$subId] = [
                'DESCR_OPCAO' => $subOption['descricaoOpcao'],
                'NIVEL_OPCAO' => $subOption['nivelOpcao'],
                'URL_OPCAO' => $subOption['urlOpcao'],
                'STATUS_OPCAO' => $subOption['statusOpcao'],
                'DESCR_NIVEL' => $subOption['descricaoNivel'],
                'SUB_OPCOES' => []
            ];
            
            // Get third level options
            $thirdLevel = getMenuOptions($conexao, $subId);
            foreach ($thirdLevel as $thirdOption) {
                $thirdId = $thirdOption['idOpcao'];
                $menuHierarchy[$optionId]['SUB_OPCOES'][$subId]['SUB_OPCOES'][$thirdId] = [
                    'DESCR_OPCAO' => $thirdOption['descricaoOpcao'],
                    'NIVEL_OPCAO' => $thirdOption['nivelOpcao'],
                    'URL_OPCAO' => $thirdOption['urlOpcao'],
                    'STATUS_OPCAO' => $thirdOption['statusOpcao'],
                    'DESCR_NIVEL' => $thirdOption['descricaoNivel']
                ];
            }
        }
    }
    
    return $menuHierarchy;
}

// Function to get permissions for a specific cargo
function getCargoPermissions($conexao, $idCargo) {
    if (empty($idCargo)) {
        return [];
    }
    
    $sql = "SELECT idOpcao FROM acesso WHERE idCargo = " . intval($idCargo);
    $result = mysqli_query($conexao, $sql);
    
    if (!$result) {
        die("Erro ao buscar permissões: " . mysqli_error($conexao));
    }
    
    $permissions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $permissions[] = $row['idOpcao'];
    }
    
    return $permissions;
}

// Get the menu hierarchy
$menuOptions = buildMenuHierarchy($conexao);

// Get permissions for selected cargo
$permissoes = [];
if (!empty($id_cargo)) {
    $permissoes = getCargoPermissions($conexao, $id_cargo);
}

// Start the form
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Menu</title>
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Gerenciamento de Permissões de Menu</h2>
        <script src="../js/acesso.js"></script>
        <form method="get" action="" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <label for="cargo_select" class="form-label">Selecione o Cargo</label>
                    <select name="id_cargo" id="cargo_select" class="form-select" onchange="this.form.submit()">
                        <option value="">Selecione o cargo</option>
                        <?php foreach ($cargos as $cargo): ?>
                            <option value="<?php echo htmlspecialchars($cargo['idCargo']); ?>" 
                                <?php echo ($cargo['idCargo'] == $id_cargo) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cargo['descricaoCargo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>  
                </div>
            </div>
        </form>

        <?php if (!empty($id_cargo)): ?>
        <form method="post" action="inicio.php">
            <input type="hidden" name="id_cargo" value="<?php echo htmlspecialchars($id_cargo); ?>">
            
            <div class="card">
                <div class="card-header">
                    <h4>Opções de Menu</h4>
                </div>
                <div class="card-body">
                    <div class="menu-options">
                        <?php foreach ($menuOptions as $idOpcao => $opcao): ?>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input parent-checkbox" type="checkbox" 
                                               name="opcoes[]" value="<?php echo $idOpcao; ?>" 
                                               id="opcao_<?php echo $idOpcao; ?>"
                                               <?php echo in_array($idOpcao, $permissoes) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="opcao_<?php echo $idOpcao; ?>">
                                            <strong><?php echo htmlspecialchars($opcao['DESCR_OPCAO']); ?></strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($opcao['SUB_OPCOES'])): ?>
                                <?php foreach ($opcao['SUB_OPCOES'] as $subId => $sub): ?>
                                    <div class="row mb-1">
                                        <div class="col-md-12" style="padding-left: 40px;">
                                            <div class="form-check">
                                                <input class="form-check-input child-checkbox" 
                                                       type="checkbox" name="opcoes[]" 
                                                       value="<?php echo $subId; ?>" 
                                                       id="opcao_<?php echo $subId; ?>"
                                                       data-parent="opcao_<?php echo $idOpcao; ?>"
                                                       <?php echo in_array($subId, $permissoes) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="opcao_<?php echo $subId; ?>">
                                                    <?php echo htmlspecialchars($sub['DESCR_OPCAO']); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($sub['SUB_OPCOES'])): ?>
                                        <?php foreach ($sub['SUB_OPCOES'] as $thirdId => $thirdOp): ?>
                                            <div class="row mb-1">
                                                <div class="col-md-12" style="padding-left: 80px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input grandchild-checkbox" 
                                                               type="checkbox" name="opcoes[]" 
                                                               value="<?php echo $thirdId; ?>" 
                                                               id="opcao_<?php echo $thirdId; ?>"
                                                               data-parent="opcao_<?php echo $subId; ?>"
                                                               <?php echo in_array($thirdId, $permissoes) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="opcao_<?php echo $thirdId; ?>">
                                                            <?php echo htmlspecialchars($thirdOp['DESCR_OPCAO']); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php else: ?>
            <div class="alert alert-info">
                Selecione um cargo para gerenciar suas permissões.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/theme.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // When a parent checkbox is checked/unchecked, check/uncheck all its children
        const parentCheckboxes = document.querySelectorAll('.parent-checkbox');
        parentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Find all child checkboxes that have this parent
                const childCheckboxes = document.querySelectorAll(`[data-parent="${this.id}"]`);
                childCheckboxes.forEach(childBox => {
                    childBox.checked = this.checked;
                    
                    // Also trigger change event for the child to affect grandchildren
                    const event = new Event('change');
                    childBox.dispatchEvent(event);
                });
            });
        });

        // When a child checkbox is checked, make sure its parent is also checked
        const childCheckboxes = document.querySelectorAll('.child-checkbox, .grandchild-checkbox');
        childCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Get parent checkbox id from data-parent
                    const parentId = this.getAttribute('data-parent');
                    if (parentId) {
                        document.getElementById(parentId).checked = true;
                        
                        // If this is a grandchild, we need to check the parent of its parent
                        if (this.classList.contains('grandchild-checkbox')) {
                            const parentElement = document.getElementById(parentId);
                            const grandparentId = parentElement.getAttribute('data-parent');
                            if (grandparentId) {
                                document.getElementById(grandparentId).checked = true;
                            }
                        }
                    }
                }
                
                // If this is a child, check/uncheck all grandchildren
                if (this.classList.contains('child-checkbox')) {
                    const grandchildCheckboxes = document.querySelectorAll(`[data-parent="${this.id}"]`);
                    grandchildCheckboxes.forEach(grandchildBox => {
                        grandchildBox.checked = this.checked;
                    });
                }
            });
        });
        
        // Check parent boxes if any children are already checked
        function checkParentsIfChildrenChecked() {
            const childrenChecked = document.querySelectorAll('.child-checkbox:checked, .grandchild-checkbox:checked');
            childrenChecked.forEach(checkbox => {
                const parentId = checkbox.getAttribute('data-parent');
                if (parentId) {
                    document.getElementById(parentId).checked = true;
                    
                    // If this is a grandchild, check the parent of its parent
                    if (checkbox.classList.contains('grandchild-checkbox')) {
                        const parentElement = document.getElementById(parentId);
                        const grandparentId = parentElement.getAttribute('data-parent');
                        if (grandparentId) {
                            document.getElementById(grandparentId).checked = true;
                        }
                    }
                }
            });
        }
        
        // Run once at page load to set parent checkboxes based on initial state
        checkParentsIfChildrenChecked();
    });

    </script>
    
</body>
</html>