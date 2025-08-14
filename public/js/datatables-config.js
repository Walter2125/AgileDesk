/**
 * Configuración reutilizable para DataTables
 * AgileDesk - Sistema de Gestión de Proyectos
 */

// Configuración común base para todas las tablas
const DataTablesConfig = {
    // Configuración estándar
    getCommonConfig: function() {
        return {
            paging: true,
            searching: false, // Usar buscadores personalizados
            ordering: true,
            info: false, // Ocultar información por defecto
            lengthChange: true,
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
            pageLength: 10,
            pagingType: 'full_numbers',
            language: {
                emptyTable: 'No hay datos disponibles en la tabla',
                zeroRecords: 'No se encontraron resultados',
                lengthMenu: '_MENU_',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ elementos',
                infoEmpty: 'Mostrando 0 a 0 de 0 elementos',
                infoFiltered: '(filtrado de _MAX_ elementos totales)',
                search: 'Buscar:',
                searchPlaceholder: 'Filtrar elementos...',
                loadingRecords: 'Cargando...',
                processing: 'Procesando...',
                paginate: {
                    first: '«',
                    previous: '‹',
                    next: '›',
                    last: '»'
                }
            },
            dom: 'ltp', // l=length, t=table, p=pagination (sin info por defecto)
            initComplete: function () {
                try {
                    const api = this.api();
                    const tableId = api.table().node().id;
                    const wrapper = $(api.table().container());
                    const lengthDiv = wrapper.find('div.dataTables_length');
                    
                    console.log('InitComplete ejecutado para tabla:', tableId);
                    console.log('Length div encontrado:', lengthDiv.length > 0);
                    
                    // Mapeo de IDs de tabla a contenedores
                    const containerMap = {
                        'usuariosTable': '#usuariosLengthContainer',
                        'proyectosTable': '#proyectosLengthContainer',
                        'historialTable': '#historialLengthContainer',
                        'sprintsTable': '#sprintsLengthContainer',
                        'deletedItemsTable': '#deletedItemsLengthContainer',
                        'usersTable': '#usersLengthContainer',
                        'pendingUsersTable': '#pendingUsersLengthContainer'
                    };
                    
                    const targetSelector = containerMap[tableId];
                    const target = targetSelector ? document.querySelector(targetSelector) : null;
                    
                    console.log('Target selector:', targetSelector);
                    console.log('Target element encontrado:', !!target);
                    
                    if (target && lengthDiv.length) {
                        // Aplicar estilos al length div
                        lengthDiv.addClass('mb-0');
                        lengthDiv.find('label').addClass('mb-0 d-flex align-items-center gap-2');
                        lengthDiv.find('select')
                            .addClass('form-select form-select-sm')
                            .css({ 
                                width: 'auto',
                                height: '36px',
                                borderRadius: '6px'
                            });
                        
                        // Mover al contenedor objetivo
                        target.innerHTML = '';
                        target.appendChild(lengthDiv.get(0));
                        
                        console.log('Selector de longitud movido exitosamente');
                    } else {
                        console.warn('No se pudo mover selector - Target:', !!target, 'LengthDiv:', lengthDiv.length);
                    }
                } catch (err) {
                    console.error('Error moviendo selector de longitud:', err);
                }
            }
        };
    },

    // Configuración para tablas administrativas
    getAdminConfig: function(actionColumn = -1) {
        const config = this.getCommonConfig();
        config.columnDefs = [
            { orderable: false, targets: [actionColumn] }, // Deshabilitar ordenamiento en columna de acciones
            { className: 'text-center', targets: [0, actionColumn] } // Centrar columnas específicas
        ];
        return config;
    },

    // Configuración para elementos eliminados
    getDeletedItemsConfig: function() {
        const config = this.getCommonConfig();
        config.language.emptyTable = 'No hay elementos eliminados disponibles';
        config.columnDefs = [
            { orderable: false, targets: [5] }, // Columna de acciones
            { className: 'text-center', targets: [0, 5] }
        ];
        return config;
    },

    // Configuración para usuarios
    getUsersConfig: function() {
        const config = this.getCommonConfig();
        config.language.emptyTable = 'No hay usuarios registrados';
        // Mantener paginación incluso con tabla vacía
        config.emptyTable = false;
        config.columnDefs = [
            { orderable: false, targets: [4] }, // Columna de acciones (si existe)
            { className: 'text-center', targets: [0, 4] }
        ];
        return config;
    },

    // Utilidad para validar columnas consistentes
    hasConsistentColumns: function(table) {
        try {
            const headCols = table.querySelectorAll('thead th').length;
            const rows = table.querySelectorAll('tbody tr');
            for (const row of rows) {
                // Ignorar filas de mensajes personalizados
                if (row.classList.contains('no-results-message')) continue;
                const cells = row.querySelectorAll('td').length;
                if (cells > 0 && cells !== headCols) return false;
            }
            return true;
        } catch (e) {
            return true;
        }
    },

    // Inicializar tabla con configuración específica
    initTable: function(selector, config, searchInputSelector = null) {
        const element = document.querySelector(selector);
        if (!element) {
            console.warn(`Tabla ${selector} no encontrada`);
            return null;
        }

        if (!this.hasConsistentColumns(element)) {
            console.warn(`Columnas inconsistentes en ${selector} — se omite DataTables`);
            return null;
        }

        try {
            const dt = $(selector).DataTable(config);
            
            // Conectar buscador personalizado si se proporciona
            if (searchInputSelector) {
                const searchInput = document.querySelector(searchInputSelector);
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        dt.search(this.value).draw();
                    });
                }
            }
            
            return dt;
        } catch (e) {
            console.error(`Error inicializando DataTable para ${selector}:`, e);
            return null;
        }
    },

    // Inicializar múltiples tablas
    initMultipleTables: function(tablesConfig) {
        const initializedTables = {};
        
        tablesConfig.forEach(tableConfig => {
            const { id, searchInput, config } = tableConfig;
            const dt = this.initTable(id, config, searchInput);
            if (dt) {
                initializedTables[id] = dt;
            }
        });
        
        return initializedTables;
    }
};

// Función de inicialización global
function initializeDataTables() {
    if (!window.jQuery || !$.fn || !$.fn.DataTable) {
        console.error('DataTables no está disponible.');
        return false;
    }
    return true;
}

// Exportar para uso global
window.DataTablesConfig = DataTablesConfig;
window.initializeDataTables = initializeDataTables;
