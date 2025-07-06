<style>
/* Mobile responsiveness */
@media screen and (max-width: 480px) {
    #taskModal > div {
        width: calc(100% - 32px);
        max-width: none;
        margin: 16px;
        padding: 16px;
    }
    
    #taskModal h3 {
        font-size: 12px;
        margin-bottom: 12px;
    }
    
    #taskModal input,
    #taskModal select {
        padding: 10px;
        font-size: 12px;
        margin-bottom: 10px;
    }
    
    #taskModal button {
        padding: 10px 12px;
        font-size: 12px;
    }
}

@media screen and (max-width: 360px) {
    #taskModal > div {
        padding: 12px;
    }
    
    #taskModal h3 {
        font-size: 13px;
    }
    
    #taskModal input,
    #taskModal select {
        padding: 8px;
        font-size: 12px;
    }
    
    #taskModal button {
        padding: 8px 10px;
        font-size: 12px;
    }
}

/* Label styling - aligned to the left */
#taskModal label {
    display: block;
    text-align: left;
    margin-bottom: 4px;
    margin-top: 8px;
    font-weight: 500;
    font-size: 14px;
    color: #333;
}

#taskModal label:first-of-type {
    margin-top: 0;
}

/* Button hover effects */
#taskModal button[type="button"]:hover {
    background: #e9e9e9;
}

#taskModal button[type="submit"]:hover {
    background: #0056b3;
}

/* Input focus effects */
#taskModal input:focus,
#taskModal select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}
</style>

<div id="taskModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; justify-content: center; align-items: center; font-family: 'Inter', sans-serif;">
    <div style="background: white; padding: 24px; border-radius: 12px; width: 320px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
        <h3 style="margin-top: 0; margin-bottom: 16px; font-size: 20px;">Add New Task</h3>
@if ($errors->any())
    <div id="errorBox" style="color: red; margin-bottom: 10px;">
        <ul style="padding-left: 16px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="/tasks" method="POST" class="modal-form">
            @csrf
            <input type="hidden" name="column_id" id="modalColumnId" value="{{ $columns->firstWhere('name', 'To Do')->id }}">

            <label for="title">Task Title</label>
            <input type="text" name="title" id="title" placeholder="Enter task title" required>

            <label for="description">Task Description</label>
            <input type="text" name="description" id="description" placeholder="Enter description">

            <label for="deadlineInput">Deadline</label>
            <input type="date" name="deadline" id="modalDeadline">

            <select name="priority_color">
                <option value="">Priority Color</option>
                <option value="red">Red</option>
                <option value="yellow">Yellow</option>
                <option value="green">Green</option>
            </select>

            <div style="display: flex; justify-content: space-between;">
                <button type="button" onclick="closeModal()" class="modal-cancel-button">Cancel</button>
                <button type="submit" class="modal-add-button">Add Task</button>
            </div>
        </form>
    </div>
</div>
@if ($errors->any())
<script>
    window.onload = function () {
        const lastColumnId = sessionStorage.getItem('lastColumnId');
        if (lastColumnId) {
            document.getElementById('modalColumnId').value = lastColumnId;
        }
        document.getElementById('taskModal').style.display = 'flex';
    };
</script>
@endif