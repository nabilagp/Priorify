<!DOCTYPE html>
<html>
<head>
    <title>Edit Delete Dropdown</title>
    <style>
        input[type="date"] {
    font-family: 'Inter', sans-serif;
}

        .menu-container {
            position: relative;
            display: inline-block;
        }
        .menu-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            z-index: 100;
            min-width: 100px;
        }
        .dropdown-menu div {
            padding: 8px 12px;
            cursor: pointer;
        }
        .dropdown-menu div:hover {
            background-color: #eee;
        }
        .dropdown-menu .delete {
            color: red;
        }
    </style>
</head>
<body>

<div class="menu-container">
    <button class="menu-button" onclick="toggleMenu(this)">&#8230;</button>
    <div class="dropdown-menu">
        <div onclick="editItem()">Edit</div>
        <div class="delete" onclick="showConfirmDelete()">Delete</div>
    </div>
</div>

<!-- Modal konfirmasi hapus -->
<div id="confirmDeleteModal" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9999; justify-content: center; align-items: center;">
  <div style="background: white; padding: 24px; border-radius: 12px; width: 300px; font-family: 'Inter', sans-serif;">
    <p style="margin-bottom: 20px;">Are you sure you want to delete this item?</p>
    <div style="display: flex; justify-content: flex-end; gap: 8px;">
      <button onclick="closeConfirmDelete()" style="padding: 8px 16px; background: #ccc; border: none; border-radius: 6px;">Cancel</button>
      <button id="confirmDeleteBtn" style="padding: 8px 16px; background: red; color: white; border: none; border-radius: 6px;">Yes, Delete</button>
    </div>
  </div>
</div>


<script>
    function toggleMenu(button) {
        const menu = button.nextElementSibling;
        const isOpen = menu.style.display === 'block';
        // tutup semua menu dulu
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
        if (!isOpen) {
            menu.style.display = 'block';
        }
    }

    // Tutup menu kalau klik di luar
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.menu-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
        }
    });

    function editItem() {
        alert('Edit clicked');
        closeAllMenus();
    }

    function deleteItem() {
        if (confirm('Are you sure you want to delete this item?')) {
            alert('Delete clicked');
            // Di sini bisa panggil ajax untuk delete atau submit form
        }
        closeAllMenus();
    }

    function closeAllMenus() {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
    }
</script>

</body>
</html>
