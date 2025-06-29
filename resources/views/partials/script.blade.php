<script>
    // Modal Add Task
    function openModal(columnId = null) {
        document.getElementById('taskModal').style.display = 'flex';
        if (columnId) {
            document.getElementById('modalColumnId').value = columnId;
            sessionStorage.setItem('lastColumnId', columnId);
        }
        
        // Clear any residual mm/dd/yyyy values
        const deadlineInput = document.getElementById('modalDeadline');
        if (deadlineInput && deadlineInput.value === 'mm/dd/yyyy') {
            deadlineInput.value = '';
        }
    }

    function closeModal() {
        document.getElementById('taskModal').style.display = 'none';

        // Hapus pesan error dari DOM
        const errorBox = document.getElementById('errorBox');
        if (errorBox) {
            errorBox.remove();
        }

        // Reset input di dalam modal saja (tidak menyentuh task lain)
        const form = document.querySelector('#taskModal form');
        if (form) {
            form.reset();

            // Reset input date secara eksplisit agar tidak ganggu input task lain
            const dateInput = form.querySelector('input[type="date"]');
            if (dateInput) {
                dateInput.value = ''; // Hapus nilai tanggal
                dateInput.style.borderColor = ''; // Reset border color
            }
        }
        
        // Clear session storage yang berkaitan dengan form
        sessionStorage.removeItem('lastColumnId');
        sessionStorage.removeItem('taskFormData');
    }

    // Dropdown Menu Toggle
    function toggleMenu(event) {
        event.stopPropagation();
        const button = event.currentTarget;
        const menuId = button.dataset.menuTarget;
        const menu = document.getElementById(menuId);
        const isVisible = menu.style.display === 'block';

        // Tutup semua dropdown yang lain
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            m.style.display = 'none';
            if (m.dataset.originalParent) {
                const parent = document.querySelector(m.dataset.originalParent);
                if (parent && !parent.contains(m)) parent.appendChild(m);
            }
        });

        if (!isVisible) {
            const rect = button.getBoundingClientRect();

            if (!menu.dataset.originalParent) {
                const parentId = menu.closest('.menu-container')?.id;
                if (parentId) {
                    menu.dataset.originalParent = `#${parentId}`;
                }
            }

            document.body.appendChild(menu);
            menu.style.display = 'block';
            menu.style.position = 'absolute';
            menu.style.top = `${rect.bottom + window.scrollY}px`;
            menu.style.left = `${rect.left + window.scrollX}px`;
            menu.style.zIndex = 1001;
        } else {
            menu.style.display = 'none';
        }
    }

    // HANYA SATU listener global
    document.addEventListener('click', function (e) {
        const isMenuButton = e.target.classList.contains('menu-button');
        const isInDropdown = e.target.closest('.dropdown-menu');
        const isProfile = e.target.closest('.profile-circle');
        const isProfileDropdown = e.target.closest('#profileDropdown');

        // Tutup dropdown menu titik 3 jika klik di luar
        if (!isMenuButton && !isInDropdown) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
                const parentSelector = menu.dataset.originalParent;
                const originalParent = parentSelector ? document.querySelector(parentSelector) : null;
                if (originalParent && !originalParent.contains(menu)) {
                    originalParent.appendChild(menu);
                }
            });
        }

        // Tutup dropdown profil jika klik di luar
        if (!isProfile && !isProfileDropdown) {
            const profileDropdown = document.getElementById('profileDropdown');
            if (profileDropdown) {
                profileDropdown.style.display = 'none';
            }
        }
    });

    // Desktop Drag & Drop Tasks
    let draggedTaskId = null;

    function drag(event) {
        draggedTaskId = event.target.dataset.taskId;
        event.dataTransfer.setData("text", event.target.id);
        event.target.classList.add('dragging');
        event.dataTransfer.effectAllowed = 'move';
    }

    function allowDrop(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        event.currentTarget.classList.add('drop-target');
    }

    function drop(event) {
        event.preventDefault();
        event.currentTarget.classList.remove('drop-target');

        const columnId = event.currentTarget.dataset.columnId;
        const columnName = event.currentTarget.dataset.columnName;
        if (!draggedTaskId) return;

        const draggedElem = document.getElementById('task-' + draggedTaskId);
        const columnTasks = event.currentTarget.querySelector('.column-tasks');

        if (draggedElem && columnTasks) {
            const fromColumn = draggedElem.closest('.column')?.dataset.columnName;
            columnTasks.appendChild(draggedElem);
            updateStatusOverviewUI(fromColumn, columnName);

            if (columnName.toLowerCase() === 'completed') {
                draggedElem.classList.add('completed-task');
            } else {
                draggedElem.classList.remove('completed-task');
            }
        }

        // Update to backend
        fetch('/update-tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                task_id: draggedTaskId,
                column_id: columnId
            })
        }).then(response => {
            if (!response.ok) throw new Error('Failed to update task');
            return response.json();
        }).then(data => {
            console.log('Task updated:', data);
        }).catch(err => {
            alert('Error updating task');
            console.error(err);
        });

        draggedTaskId = null;
        document.querySelectorAll('.task.dragging').forEach(el => el.classList.remove('dragging'));
    }

    // Bersihkan drag style saat keluar kolom
    document.querySelectorAll('.column').forEach(col => {
        col.addEventListener('dragleave', e => {
            e.currentTarget.classList.remove('drop-target');
        });
    });

    // Mobile Touch Drag & Drop Support
    let touchDraggedTaskId = null;
    let touchStartY = 0;
    let touchStartX = 0;
    let isDragging = false;
    let draggedElement = null;
    let dragPreview = null;
    let autoScrollInterval = null;

    // Detect if device supports touch
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    if (isTouchDevice) {
        document.addEventListener('DOMContentLoaded', function() {
            addTouchEventsToTasks();
        });

        function addTouchEventsToTasks() {
            document.querySelectorAll('.task').forEach(task => {
                if (!task.hasAttribute('data-touch-enabled')) {
                    task.addEventListener('touchstart', handleTouchStart, { passive: false });
                    task.addEventListener('touchmove', handleTouchMove, { passive: false });
                    task.addEventListener('touchend', handleTouchEnd, { passive: false });
                    task.setAttribute('data-touch-enabled', 'true');
                }
            });
        }

        function handleTouchStart(e) {
            const touch = e.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
            touchDraggedTaskId = e.currentTarget.dataset.taskId;
            draggedElement = e.currentTarget;
        }

        function handleTouchMove(e) {
            if (!touchDraggedTaskId) return;
            
            const touch = e.touches[0];
            const deltaX = Math.abs(touch.clientX - touchStartX);
            const deltaY = Math.abs(touch.clientY - touchStartY);
            
            if (!isDragging && deltaX > 15 && deltaX > deltaY) {
                isDragging = true;
                e.preventDefault();
                
                createDragPreview(draggedElement, touch.clientX, touch.clientY);
                draggedElement.classList.add('dragging');
                
                document.querySelectorAll('.column').forEach(col => {
                    col.classList.add('touch-drag-active');
                });
                
                startAutoScroll();
            }
            
            if (isDragging) {
                e.preventDefault();
                
                if (dragPreview) {
                    dragPreview.style.left = (touch.clientX - 50) + 'px';
                    dragPreview.style.top = (touch.clientY - 30) + 'px';
                }
                
                handleAutoScroll(touch.clientY);
                
                const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
                const column = elementBelow?.closest('.column');
                
                document.querySelectorAll('.column').forEach(col => {
                    col.classList.remove('drop-target');
                });
                
                if (column && column !== draggedElement.closest('.column')) {
                    column.classList.add('drop-target');
                }
            }
        }

        function startAutoScroll() {
            if (autoScrollInterval) return;
            
            autoScrollInterval = setInterval(() => {
                if (!isDragging) {
                    clearInterval(autoScrollInterval);
                    autoScrollInterval = null;
                }
            }, 16);
        }

        function handleAutoScroll(touchY) {
            const scrollThreshold = 100;
            const scrollSpeed = 5;
            const windowHeight = window.innerHeight;
            
            if (touchY < scrollThreshold) {
                window.scrollBy(0, -scrollSpeed);
            } else if (touchY > windowHeight - scrollThreshold) {
                window.scrollBy(0, scrollSpeed);
            }
            
            const scrollContainer = document.querySelector('.kanban-board');
            if (scrollContainer) {
                const rect = scrollContainer.getBoundingClientRect();
                const touchX = event.touches ? event.touches[0].clientX : 0;
                
                if (touchX < rect.left + scrollThreshold) {
                    scrollContainer.scrollBy(-scrollSpeed, 0);
                } else if (touchX > rect.right - scrollThreshold) {
                    scrollContainer.scrollBy(scrollSpeed, 0);
                }
            }
        }

        function handleTouchEnd(e) {
            if (!isDragging) {
                touchDraggedTaskId = null;
                draggedElement = null;
                return;
            }
            
            e.preventDefault();
            
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
                autoScrollInterval = null;
            }
            
            const touch = e.changedTouches[0];
            const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
            const targetColumn = elementBelow?.closest('.column');
            
            document.querySelectorAll('.column').forEach(col => {
                col.classList.remove('drop-target', 'touch-drag-active');
            });
            
            if (draggedElement) {
                draggedElement.classList.remove('dragging');
            }
            
            if (dragPreview) {
                dragPreview.remove();
                dragPreview = null;
            }
            
            if (targetColumn && touchDraggedTaskId) {
                const columnId = targetColumn.dataset.columnId;
                const columnName = targetColumn.dataset.columnName;
                const columnTasks = targetColumn.querySelector('.column-tasks');
                
                if (draggedElement && columnTasks) {
                    const fromColumn = draggedElement.closest('.column')?.dataset.columnName;
                    
                    if (fromColumn !== columnName) {
                        columnTasks.appendChild(draggedElement);
                        updateStatusOverviewUI(fromColumn, columnName);
                        
                        if (columnName.toLowerCase() === 'completed') {
                            draggedElement.classList.add('completed-task');
                        } else {
                            draggedElement.classList.remove('completed-task');
                        }
                        
                        fetch('/update-tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                task_id: touchDraggedTaskId,
                                column_id: columnId
                            })
                        }).then(response => {
                            if (!response.ok) throw new Error('Failed to update task');
                            return response.json();
                        }).then(data => {
                            console.log('Task updated:', data);
                        }).catch(err => {
                            alert('Error updating task');
                            console.error(err);
                        });
                    }
                }
            }
            
            touchDraggedTaskId = null;
            draggedElement = null;
            isDragging = false;
        }

        function createDragPreview(element, x, y) {
            dragPreview = element.cloneNode(true);
            dragPreview.style.position = 'fixed';
            dragPreview.style.left = (x - 50) + 'px';
            dragPreview.style.top = (y - 30) + 'px';
            dragPreview.style.width = '100px';
            dragPreview.style.height = '60px';
            dragPreview.style.opacity = '0.8';
            dragPreview.style.transform = 'rotate(5deg)';
            dragPreview.style.zIndex = '9999';
            dragPreview.style.pointerEvents = 'none';
            dragPreview.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';
            dragPreview.classList.add('drag-preview');
            
            document.body.appendChild(dragPreview);
        }

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1 && node.classList.contains('task')) {
                            if (!node.hasAttribute('data-touch-enabled')) {
                                node.addEventListener('touchstart', handleTouchStart, { passive: false });
                                node.addEventListener('touchmove', handleTouchMove, { passive: false });
                                node.addEventListener('touchend', handleTouchEnd, { passive: false });
                                node.setAttribute('data-touch-enabled', 'true');
                            }
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    // Modal Konfirmasi Hapus
    let taskIdToDelete = null;

    function openConfirmDelete(taskId) {
        taskIdToDelete = taskId;
        document.getElementById('confirmDeleteModal').classList.add('active');
    }

    function closeConfirmDelete() {
        taskIdToDelete = null;
        document.getElementById('confirmDeleteModal').classList.remove('active');
    }

    // DOMContentLoaded Event Handler
    document.addEventListener('DOMContentLoaded', () => {
        // Form submission validation
        const taskForm = document.querySelector('#taskModal form');
        if (taskForm) {
            taskForm.addEventListener('submit', function(e) {
                const deadlineInput = document.getElementById('modalDeadline'); // Ganti dengan modalDeadline
                const deadline = deadlineInput ? deadlineInput.value : '';
                
                // Check for empty deadline
                if (!deadline) {
                    e.preventDefault();
                    alert('Please fill in the deadline first!');
                    if (deadlineInput) {
                        deadlineInput.focus();
                        deadlineInput.style.borderColor = '#dc3545'; // Red border
                    }
                    return false;
                }
                
                // Reset border color if valid
                if (deadlineInput) {
                    deadlineInput.style.borderColor = '';
                }
            });
        }

        // Date input validation
        const deadlineInput = document.getElementById('modalDeadline'); // Ganti dengan modalDeadline
        if (deadlineInput) {
            // Clear mm/dd/yyyy on focus
            deadlineInput.addEventListener('focus', function() {
                if (this.value === 'mm/dd/yyyy') {
                    this.value = '';
                }
            });

            // Validate on change
            deadlineInput.addEventListener('change', function() {
                if (this.value === 'mm/dd/yyyy' || this.value === '') {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '';
                }
            });

            // Handle input event
            deadlineInput.addEventListener('input', function() {
                if (this.value === 'mm/dd/yyyy') {
                    this.value = '';
                }
            });
        }

        // Delete confirmation handlers
        document.getElementById('cancelDeleteBtn')?.addEventListener('click', () => {
            closeConfirmDelete();
        });

        document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
            if (!taskIdToDelete) return;
            const form = document.getElementById('delete-form-' + taskIdToDelete);
            if (form) form.submit();
            closeConfirmDelete();
        });

        // Initialize touch events for existing tasks
        if (isTouchDevice) {
            addTouchEventsToTasks();
        }
    });

    // Profile Dropdown
    function toggleProfileMenu() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Status Overview Updater
    function updateStatusOverviewUI(fromColumn, toColumn) {
        if (fromColumn === toColumn) return;

        const fromCountEl = document.querySelector(`#count-${fromColumn?.replace(/\s/g, '')}`);
        const toCountEl = document.querySelector(`#count-${toColumn?.replace(/\s/g, '')}`);

        if (fromCountEl && toCountEl) {
            fromCountEl.textContent = Math.max(0, parseInt(fromCountEl.textContent) - 1);
            toCountEl.textContent = parseInt(toCountEl.textContent) + 1;
        }
    }
</script>