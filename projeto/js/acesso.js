/**
 * Menu Permissions System - Frontend functionality
 * 
 * This file handles the client-side logic for the menu permissions management interface.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Handle cargo selection
    const cargoSelect = document.getElementById('cargo_select');
    if (cargoSelect) {
        cargoSelect.addEventListener('change', function() {
            // Form will be submitted automatically via onchange attribute
            // This is just a fallback if the attribute doesn't work
            this.form.submit();
        });
    }

    // Handle parent-child checkbox relationships
    function setupCheckboxHierarchy() {
        // When a parent checkbox is checked/unchecked, update all its children
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
                        const parentCheckbox = document.getElementById(parentId);
                        if (parentCheckbox && !parentCheckbox.checked) {
                            parentCheckbox.checked = true;
                            
                            // If parent has its own parent, check that too (for grandchildren)
                            if (parentCheckbox.hasAttribute('data-parent')) {
                                const grandparentId = parentCheckbox.getAttribute('data-parent');
                                const grandparentCheckbox = document.getElementById(grandparentId);
                                if (grandparentCheckbox) {
                                    grandparentCheckbox.checked = true;
                                }
                            }
                        }
                    }
                }
                
                // If this is a child with children, check/uncheck all its children
                const grandchildCheckboxes = document.querySelectorAll(`[data-parent="${this.id}"]`);
                grandchildCheckboxes.forEach(grandchildBox => {
                    grandchildBox.checked = this.checked;
                });
            });
        });
        
        // Check parent boxes if any children are already checked
        function checkParentsIfChildrenChecked() {
            const childrenChecked = document.querySelectorAll('.child-checkbox:checked, .grandchild-checkbox:checked');
            childrenChecked.forEach(checkbox => {
                const parentId = checkbox.getAttribute('data-parent');
                if (parentId) {
                    const parentCheckbox = document.getElementById(parentId);
                    if (parentCheckbox) {
                        parentCheckbox.checked = true;
                        
                        // If parent has its own parent, check that too (for grandchildren)
                        if (parentCheckbox.hasAttribute('data-parent')) {
                            const grandparentId = parentCheckbox.getAttribute('data-parent');
                            const grandparentCheckbox = document.getElementById(grandparentId);
                            if (grandparentCheckbox) {
                                grandparentCheckbox.checked = true;
                            }
                        }
                    }
                }
            });
        }
        
        // Run once at page load to set parent checkboxes based on initial state
        checkParentsIfChildrenChecked();
    }

    // Search functionality for finding menu options
    const searchInput = document.getElementById('menu-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('.row');
            
            menuItems.forEach(item => {
                const label = item.querySelector('.form-check-label');
                if (!label) return;
                
                const itemText = label.textContent.toLowerCase();
                
                if (itemText.includes(searchTerm)) {
                    item.style.display = '';
                    
                    // Show all parent items of this matching item
                    let parentElement = item;
                    while (parentElement) {
                        const checkbox = parentElement.querySelector('.form-check-input');
                        if (checkbox && checkbox.hasAttribute('data-parent')) {
                            const parentId = checkbox.getAttribute('data-parent');
                            const parentRow = document.getElementById(parentId)?.closest('.row');
                            if (parentRow) {
                                parentRow.style.display = '';
                            }
                        }
                        parentElement = parentElement.previousElementSibling;
                    }
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Toggle section visibility
    const toggleButtons = document.querySelectorAll('.toggle-section');
    if (toggleButtons.length > 0) {
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-section');
                const section = document.getElementById(sectionId);
                
                if (section) {
                    section.classList.toggle('collapsed');
                    this.textContent = section.classList.contains('collapsed') ? '+' : '-';
                }
            });
        });
    }

    // Bulk selection actions
    const selectAllBtn = document.getElementById('select-all');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(checkbox => checkbox.checked = true);
        });
    }

    const deselectAllBtn = document.getElementById('deselect-all');
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(checkbox => checkbox.checked = false);
        });
    }

    // Load saved permissions via AJAX if needed
    function loadPermissionsAjax(cargoId) {
        if (!cargoId) return;
        
        fetch(`../controle/carregar_permissoes.php?id_cargo=${cargoId}`)
            .then(response => response.json())
            .then(data => {
                // Reset all checkboxes first
                const checkboxes = document.querySelectorAll('.form-check-input');
                checkboxes.forEach(checkbox => checkbox.checked = false);
                
                // Check the boxes for options with permissions
                if (data.permissoes && data.permissoes.length > 0) {
                    data.permissoes.forEach(opcaoId => {
                        const checkbox = document.getElementById(`opcao_${opcaoId}`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                    
                    // Update parent checkboxes based on children state
                    checkParentsIfChildrenChecked();
                }
            })
            .catch(error => {
                console.error('Erro ao carregar permissões:', error);
            });
    }

    // Initialize the checkbox hierarchy
    setupCheckboxHierarchy();

    // Add support for bulk action buttons
    const addBulkActionButtons = function() {
        const formContainer = document.querySelector('.card-header');
        if (formContainer && !document.getElementById('bulk-actions')) {
            const bulkActions = document.createElement('div');
            bulkActions.id = 'bulk-actions';
            bulkActions.className = 'mt-2';
            
            bulkActions.innerHTML = `
                <div class="input-group mb-3">
                    <input type="text" id="menu-search" class="form-control" placeholder="Buscar opções de menu...">
                    <button class="btn btn-outline-secondary" type="button" id="select-all">Selecionar Todos</button>
                    <button class="btn btn-outline-secondary" type="button" id="deselect-all">Desmarcar Todos</button>
                </div>
            `;
            
            formContainer.appendChild(bulkActions);
            
            // Re-attach event listeners
            const selectAllBtn = document.getElementById('select-all');
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.form-check-input');
                    checkboxes.forEach(checkbox => checkbox.checked = true);
                });
            }

            const deselectAllBtn = document.getElementById('deselect-all');
            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.form-check-input');
                    checkboxes.forEach(checkbox => checkbox.checked = false);
                });
            }

            const searchInput = document.getElementById('menu-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.menu-options .row');
                    
                    rows.forEach(row => {
                        const label = row.querySelector('.form-check-label');
                        if (!label) return;
                        
                        const text = label.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        }
    };

    // Add bulk action buttons if they don't exist
    addBulkActionButtons();
});
// No arquivo theme.js, você pode adicionar algo como:
document.addEventListener('DOMContentLoaded', function() {
    // Código que evita que o tema seja aplicado à navbar
    const navbarElement = document.querySelector('.navbar');
    if (navbarElement) {
        navbarElement.classList.add('theme-exempt');
    }
    
    // E então em suas funções de tema
    const themableElements = document.querySelectorAll(':not(.theme-exempt)');
    // aplique o tema apenas a estes elementos
});