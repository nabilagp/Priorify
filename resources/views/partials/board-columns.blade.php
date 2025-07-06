<div class="board-wrapper">

    {{-- Status Overview di kiri --}}

    <div class="status-overview">
    <h3>Status Overview</h3>
    <div class="status-box">
        <div class="status-title">To Do</div>
        <div class="status-count" id="count-ToDo">{{ $statusCounts['To Do'] }}</div>
    </div>
    <div class="status-box">
        <div class="status-title">In Progress</div>
        <div class="status-count" id="count-InProgress">{{ $statusCounts['In Progress'] }}</div>
    </div>
    <div class="status-box">
        <div class="status-title">Completed</div>
        <div class="status-count" id="count-Completed">{{ $statusCounts['Completed'] }}</div>
    </div>
</div>



    {{-- Board columns --}}
    <div class="board">
        <?php 
            $pastelColors = [
                'red' => '#ff9999',
                'blue' => '#add8e6',
                'green' => '#b3ffb3',
                'yellow' => '#ffffcc',
                'purple' => '#e0bbff',
            ];
        ?>
        @foreach ($columns as $column)
            <div class="column {{ $column->name === 'To Do' ? 'to-do' : '' }}" 
                data-column-id="{{ $column->id }}"
                data-column-name="{{ $column->name }}"
                ondragover="allowDrop(event)" 
                ondrop="drop(event)">

                <h2>{{ $column->name }}</h2>

                <div class="column-tasks">
                    @foreach ($column->tasks->filter(function($task) use ($column) {
    if ($column->name !== 'Completed') return true;

    return \Carbon\Carbon::parse($task->updated_at)->diffInDays(now()) <= 7;
}) as $task)

                        <div class="task {{ $column->name === 'Completed' ? 'completed-task' : '' }}" 
                            draggable="true" 
                            ondragstart="drag(event)" 
                            id="task-{{ $task->id }}" 
                            style="border-left: 5px solid {{ $pastelColors[$task->priority_color] ?? '#ccc' }}; margin-bottom: 10px;"
                            data-task-id="{{ $task->id }}">

                            <div>
                                <strong>{{ $task->title }}</strong><br>
                                <small>{{ $task->description }}</small><br>
                                <input type="date" name="deadline" id="deadline-{{ $task->id }}"
                                    value="{{ old('deadline', optional($task->deadline)->format('Y-m-d')) }}"
                                    style="margin-top: 6px;">
                            </div>

                            <div class="menu-container" style="position: relative;">
                                <button class="menu-button"  data-menu-target="dropdown-{{ $task->id }}"  onclick="toggleMenu(event)">&#x22EE;</button>
                                <div class="dropdown-menu" id="dropdown-{{ $task->id }}" style="display: none;">
                                    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                                    <form id="delete-form-{{ $task->id }}" action="/tasks/{{ $task->id }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete" onclick="openConfirmDelete({{ $task->id }})">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button onclick="openModal({{ $column->id }})" class="create-btn">+ Create</button>
            </div>
        @endforeach
    </div>
</div>
