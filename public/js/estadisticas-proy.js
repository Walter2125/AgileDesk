document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const modal = document.getElementById('contributorModal');
    const closeModal = document.getElementById('closeModal');
    const modalContent = document.getElementById('contributorModalContent');
    
    // Datos del servidor - estos serán inyectados desde la vista Blade
    const userContributions = window.userContributions || {};
    const projectId = window.projectId || null;
    const estadisticas = window.estadisticas || [];
    const columnasOrdenadas = window.columnasOrdenadas || [];
    
    // Verificar si está vacío
    if (Object.keys(userContributions).length === 0) {
    }
    
    // Función para crear el avatar del usuario
    function createUserAvatar(user, size = 80) {
    const baseStyle = `
        width: ${size}px;
        height: ${size}px;
        border-radius: 50%;
        border: 3px solid var(--github-border);
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--github-green);
        color: white;
        font-weight: 700;
        font-size: ${size/2.5}px;
        overflow: hidden;
    `;
    
    if (user.photo) {
        return `
            <div style="${baseStyle}">
                <img src="${user.photo}" 
                     alt="${user.name}" 
                     style="width:100%; height:100%; object-fit:cover;">
            </div>`;
    }
    
    return `
        <div style="${baseStyle}">
            ${user.name.charAt(0).toUpperCase()}
        </div>`;
}
    
    // Función para crear el contenido de tareas con acordeón - MEJORADA
    function createTasksAccordion(story) {
        const accordionId = `accordion-${story.id}`;
        const tasks = story.tareas || [];
        const taskCount = tasks.length;
        const completedTasks = tasks.filter(t => t.completada).length;
        
        let tasksHtml = `
            <li style="text-align: center; padding: 2rem; color: #64748b; font-style: italic;">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 0.5rem; opacity: 0.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div>No hay tareas asignadas para esta historia</div>
            </li>
        `;
        
        if (taskCount > 0) {
            tasksHtml = tasks.map((task, index) => {
                const completedIcon = task.completada 
                    ? '<svg width="16" height="16" fill="#10b981" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                    : '<svg width="16" height="16" fill="#6b7280" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>';
                
                const taskStyle = task.completada 
                    ? 'text-decoration: line-through; color: #9ca3af;'
                    : 'color: #374151;';
                
                const assigneeInfo = task.user 
                    ? `<span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                         ${task.user.photo ? `<img src="${task.user.photo}" alt="${task.user.name}" style="width: 20px; height: 20px; border-radius: 50%; object-fit: cover;">` : `<div style="width: 20px; height: 20px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">${task.user.name.charAt(0)}</div>`}
                         ${task.user.name}
                       </span>`
                    : '<span style="font-size: 0.875rem; color: #9ca3af;">o</span>';
                
                return `
                    <li style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; animation: fadeInUp 0.2s ease ${index * 0.05}s both;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1;">
                            ${completedIcon}
                            <span style="${taskStyle} font-weight: 500;">${task.nombre}</span>
                        </div>
                        ${assigneeInfo}
                    </li>
                `;
            }).join('');
        }
        
        const progressPercentage = taskCount > 0 ? Math.round((completedTasks / taskCount) * 100) : 0;
        const progressColor = progressPercentage === 100 ? '#10b981' : progressPercentage > 50 ? '#3b82f6' : '#f59e0b';
        
        return `
            <div class="tasks-accordion" style="margin-top: 1rem;">
                <button class="accordion-toggle" type="button" data-target="#${accordionId}" style="
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    border-radius: 8px 8px 0 0;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    position: relative;
                    z-index: 1;
                " onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="font-weight: 600; color: #374151;">Tareas</span>
                        ${taskCount > 0 ? `
                        <div style="width: 100%; max-width: 120px; background: #e5e7eb; border-radius: 8px; height: 6px; overflow: hidden;">
                            <div style="width: ${progressPercentage}%; height: 100%; background: ${progressColor}; transition: width 0.3s ease; border-radius: 8px;"></div>
                        </div>
                        ` : ''}
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="background: ${taskCount > 0 ? '#3b82f6' : '#9ca3af'}; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; min-width: 24px; text-align: center;">
                            ${taskCount}
                        </span>
                        <svg class="chevron-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.2s ease;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div id="${accordionId}" class="accordion-content" style="
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.3s ease;
                    border: 1px solid #e2e8f0;
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                    background: white;
                    margin-top: -1px;
                ">
                    <ul style="list-style: none; margin: 0; padding: 1rem;">${tasksHtml}</ul>
                </div>
            </div>
        `;
    }
    
    // Resolver el estado visual de una historia según el orden de columnas o nombre de la columna
    function resolveStoryStatus(story) {
        const colorMap = {
            pending: { class: 'status-pending', text: 'Pendiente', color: '#f59e0b' },
            progress: { class: 'status-progress', text: 'En progreso', color: '#3b82f6' },
            ready: { class: 'status-ready', text: 'Listo', color: '#10b981' }
        };

        const colId = story.columna_id || story.columna?.id || null;
        const colName = (story.columna?.nombre || '').toString().toLowerCase().trim();

        // 1) Usar columnas ordenadas del backend si están disponibles
        if (Array.isArray(columnasOrdenadas) && columnasOrdenadas.length > 0 && colId) {
            const first = columnasOrdenadas[0]?.id;
            const last = columnasOrdenadas[columnasOrdenadas.length - 1]?.id;
            if (columnasOrdenadas.length >= 3) {
                if (colId === first) return colorMap.pending;
                if (colId === last) return colorMap.ready;
                return colorMap.progress;
            } else if (columnasOrdenadas.length === 2) {
                if (colId === first) return colorMap.pending;
                return colorMap.ready;
            } else {
                // 1 sola columna => considerar como pendientes
                return colorMap.pending;
            }
        }

        // 2) Fallback por nombres conocidos (sinónimos en ES/EN)
        const pendingNames = ['pendiente','por hacer','por-hacer','todo','to do','backlog','nuevo','new'];
        const progressNames = ['en progreso','progreso','doing','in progress','wip','en curso','curso','trabajando','en desarrollo','desarrollo'];
        const readyNames = ['listo','hecho','done','terminado','terminada','completado','completada','cerrado','closed','finalizado','finalizada'];

        if (pendingNames.includes(colName)) return colorMap.pending;
        if (progressNames.includes(colName)) return colorMap.progress;
        if (readyNames.includes(colName)) return colorMap.ready;

        // 3) Último recurso: pendientes
        return colorMap.pending;
    }

    // Función para crear el contenido del modal - MEJORADA
    function createModalContent(userData) {
        
        if (!userData || !userData.user) {
            return `
                <div class="alert alert-warning" style="margin: 2rem; padding: 1.5rem; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #92400e;">⚠️ Sin datos</h4>
                    <p style="margin: 0; color: #92400e;">No se encontraron datos para este usuario.</p>
                </div>
            `;
        }
        
        const { user, stories = [] } = userData;
        const userAvatar = createUserAvatar(user, 100);
        
        
        // Estadísticas del usuario
        const totalHistorias = stories.length;
        const tareasCompletadas = stories.reduce((total, story) => {
            return total + (story.tareas?.filter(t => t.completada).length || 0);
        }, 0);
        const totalTareas = stories.reduce((total, story) => total + (story.tareas?.length || 0), 0);
        
        // Calcular En Proceso y Terminado basado en posición de columnas del backend
        let historiasEnProceso = 0;
        let historiasTerminadas = 0;
        
        
        if (columnasOrdenadas && columnasOrdenadas.length >= 3) {
            const primeraColumna = columnasOrdenadas[0];
            const ultimaColumna = columnasOrdenadas[columnasOrdenadas.length - 1];
            
            
            stories.forEach(story => {
                
                const columnaId = story.columna_id || story.columna?.id;
                
                if (columnaId === ultimaColumna.id) {
                    historiasTerminadas++;
                } else if (columnaId !== primeraColumna.id && columnaId !== ultimaColumna.id) {
                    historiasEnProceso++;
                } else {
                }
            });
        } else {
            // Si hay menos de 3 columnas, usar el método anterior por compatibilidad
            historiasEnProceso = stories.filter(s => s.columna?.nombre === 'En progreso').length;
            historiasTerminadas = stories.filter(s => s.columna?.nombre === 'Listo').length;
        }
        
        
        // Estadísticas por estado (mantener para compatibilidad)
        const estadoStats = {
            'Pendiente': stories.filter(s => s.columna?.nombre === 'Pendiente').length,
            'En progreso': stories.filter(s => s.columna?.nombre === 'En progreso').length,
            'Listo': stories.filter(s => s.columna?.nombre === 'Listo').length
        };
        
        let storiesHtml = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h4 style="margin: 0 0 0.5rem 0;">No hay historias asignadas</h4>
                <p style="margin: 0;">Este usuario aún no tiene historias asignadas en el proyecto.</p>
            </div>
        `;
        
        if (stories.length > 0) {
            storiesHtml = stories.map((story, index) => {
                const status = resolveStoryStatus(story);
                return `
                    <div class="story-item" style="animation: fadeInUp 0.3s ease ${index * 0.1}s both;">
                        <div class="story-header">
                            <a href="/historas/${story.id}/show" class="story-title" style="text-decoration: none; color: #0ea5e9; font-size: 1.2rem; font-weight: 600; margin: 0; transition: color 0.2s ease; flex: 1;" onmouseover="this.style.color='#0284c7'; this.style.textDecoration='underline'" onmouseout="this.style.color='#0ea5e9'; this.style.textDecoration='none'">${story.nombre || 'Sin título'}</a>
                            <span class="story-status ${status.class}" style="background: ${status.color}; color: white;">
                                ${status.text}
                            </span>
                        </div>
                        <p class="story-description">${story.descripcion || 'Sin descripción disponible.'}</p>
                        ${createTasksAccordion(story)}
                    </div>
                `;
            }).join('');
        }
        
        return `
            <div class="user-details-header" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                ${userAvatar}
                <div class="user-info" style="display: flex; flex-direction: column; min-width: 150px;">
                    <h3 class="user-name" style="margin: 0 0 0.25rem 0; font-size: 1.25rem; font-weight: 600;">${user.name}</h3>
                    <p class="user-email" style="margin: 0; color: #6b7280; font-size: 0.875rem;">${user.email}</p>
                </div>
                
                <!-- Estadísticas del usuario -->
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; flex: 1;">
                    <div style="text-align: center; padding: 0.5rem 0.75rem; background: #f1f5f9; border-radius: 8px; min-width: 70px; flex: 1;">
                        <div style="font-size: 1.1rem; font-weight: 700; color: #0ea5e9;">${totalHistorias}</div>
                        <div style="font-size: 0.65rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Historias</div>
                    </div>
                    <div style="text-align: center; padding: 0.5rem 0.75rem; background: #f1f5f9; border-radius: 8px; min-width: 70px; flex: 1;">
                        <div style="font-size: 1.1rem; font-weight: 700; color: #8b5cf6;">${totalTareas}</div>
                        <div style="font-size: 0.65rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Tareas</div>
                    </div>
                    <div style="text-align: center; padding: 0.5rem 0.75rem; background: #f1f5f9; border-radius: 8px; min-width: 70px; flex: 1;">
                        <div style="font-size: 1.1rem; font-weight: 700; color: #f59e0b;">${historiasEnProceso}</div>
                        <div style="font-size: 0.65rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">En Proceso</div>
                    </div>
                    <div style="text-align: center; padding: 0.5rem 0.75rem; background: #f1f5f9; border-radius: 8px; min-width: 70px; flex: 1;">
                        <div style="font-size: 1.1rem; font-weight: 700; color: #10b981;">${historiasTerminadas}</div>
                        <div style="font-size: 0.65rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Terminadas</div>
                    </div>
                </div>
            </div>
            
            <div class="stories-container">
                <h4 class="section-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Historias Asignadas (${stories.length})
                </h4>
                ${storiesHtml}
            </div>
        `;
    }
    
    // Función para manejar los acordeones
    function handleAccordionToggle(event) {
        const button = event.target.closest('.accordion-toggle');
        if (!button) return;
        
        const targetId = button.getAttribute('data-target');
        const accordion = document.querySelector(targetId);
        const chevron = button.querySelector('.chevron-icon');
        
        if (!accordion || !chevron) return;
        
        const isActive = accordion.classList.contains('active');
        accordion.classList.toggle('active', !isActive);
        chevron.style.transform = isActive ? 'rotate(0deg)' : 'rotate(180deg)';
    }
    
    // Función para truncar nombres largos con ellipsis
    function truncateName(name, maxLength = 15) {
        if (name.length <= maxLength) return name;
        return name.substring(0, maxLength) + '...';
    }

    // Función para inicializar el gráfico
    function initChart() {
        const canvas = document.getElementById('contributionsChart');
        if (!canvas || typeof Chart === 'undefined') return;
        
        const ctx = canvas.getContext('2d');
        
        // Usar datos globales inyectados desde la vista
        const contributorData = estadisticas.map(stat => ({
            name: stat.usuario.name,
            contributions: stat.total_contribuciones || 0,
            email: stat.usuario.email
        }));
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: contributorData.map(user => truncateName(user.name)),
                datasets: [{
                    label: 'Contribuciones',
                    data: contributorData.map(user => user.contributions),
                    backgroundColor: '#679def',
                    borderColor: '#21262d',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#161b22',
                        titleColor: '#e6edf3',
                        bodyColor: '#e6edf3',
                        borderColor: '#21262d',
                        borderWidth: 1,
                        cornerRadius: 6,
                        displayColors: false,
                        callbacks: {
                            title: (context) => contributorData[context[0].dataIndex].name,
                            label: (context) => `${contributorData[context.dataIndex].contributions} contribuciones`,
                            afterLabel: (context) => contributorData[context.dataIndex].email
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#7d8590', stepSize: 1 },
                        grid: { color: '#21262d' }
                    },
                    x: {
                        ticks: { 
                            color: '#7d8590', 
                            maxRotation: 45, 
                            minRotation: 0,
                            font: {
                                size: 11
                            },
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                // Para pantallas pequeñas, truncar aún más
                                if (window.innerWidth < 768) {
                                    return truncateName(contributorData[index]?.name || label, 10);
                                }
                                return label;
                            }
                        },
                        grid: { display: false }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    }
    
    // Event listeners - MEJORADOS CON MEJOR DEBUGGING
    document.addEventListener('click', function(event) {
        // Manejo del modal de contribuidor
        const contributorItem = event.target.closest('.contributor-item');
        if (contributorItem) {
            event.preventDefault();
            
            const userId = contributorItem.dataset.userId;
            const userData = userContributions[userId];
            
            
            // Verificar si los datos existen
            if (!userData) {
                modalContent.innerHTML = `
                    <div style="text-align: center; padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">❌</div>
                        <h3 style="color: #dc2626; margin-bottom: 1rem;">Error de datos</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">No se encontraron datos para el usuario ID: ${userId}</p>
                        <details style="text-align: left; background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                            <summary style="cursor: pointer; font-weight: bold;">Información de debug</summary>
                            <pre style="font-size: 0.875rem; margin-top: 0.5rem; overflow-x: auto;">
Datos disponibles: ${JSON.stringify(Object.keys(userContributions), null, 2)}
userContributions: ${JSON.stringify(userContributions, null, 2)}
                            </pre>
                        </details>
                    </div>
                `;
                modal.classList.add('active');
                return;
            }
            
            // Si hay datos, mostrar loading
            modalContent.innerHTML = `
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 300px; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    <p style="color: #6b7280; margin: 0;">Cargando datos del usuario...</p>
                    <small style="color: #9ca3af;">Usuario: ${userData.user?.name || 'Desconocido'}</small>
                </div>
                <style>
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                </style>
            `;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Mostrar contenido real después de un delay más corto
            setTimeout(() => {
                try {
                    const content = createModalContent(userData);
                    modalContent.innerHTML = content;
                } catch (error) {
                    modalContent.innerHTML = `
                        <div style="text-align: center; padding: 3rem;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">⚠️</div>
                            <h3 style="color: #dc2626; margin-bottom: 1rem;">Error al cargar</h3>
                            <p style="color: #6b7280;">Error: ${error.message}</p>
                        </div>
                    `;
                }
            }, 300);
            
            return;
        }
        
        // Manejo del acordeón
        const accordionButton = event.target.closest('.accordion-toggle');
        if (accordionButton) {
            event.preventDefault();
            
            const targetId = accordionButton.getAttribute('data-target');
            const accordion = document.querySelector(targetId);
            const chevron = accordionButton.querySelector('.chevron-icon');
            
            if (accordion && chevron) {
                const isActive = accordion.style.maxHeight && accordion.style.maxHeight !== '0px';
                
                if (isActive) {
                    accordion.style.maxHeight = '0px';
                    chevron.style.transform = 'rotate(0deg)';
                } else {
                    accordion.style.maxHeight = accordion.scrollHeight + 'px';
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
            
            return;
        }
    });
    
    // Cerrar modal - MEJORADO
    function closeModalHandler() {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar scroll del body
        
        // Limpiar contenido después de la animación
        setTimeout(() => {
            modalContent.innerHTML = '';
        }, 300);
    }
    
    closeModal.addEventListener('click', closeModalHandler);
    
    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModalHandler();
        }
    });
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModalHandler();
        }
    });
    
    // Inicializar gráfico
    initChart();
});
