@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-between m-2">
        <a href="{{ route('tasks.create') }}" class="btn m-2 btn-sm btn-primary">إنشاء مهمة جديدة</a>
        <h3 class="text-center ">قائمة المهام</h3>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="copy-message hidden"></div>

    <table class="table">
        <thead>
            <tr>
                <th>اسم المهمة</th>
                <th>التعليق</th>
                <th>الحالة</th>
                <th>تاريخ الاستحقاق</th>
                <th>العمليات</th>
                <th>مكتمل</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="{{ str_replace(' ', '-', strtolower($task->status)) }}" id="task{{ $task->id }}" data-id="{{ $task->id }}">
                    <td class='perfmatters'>{{ $task->name }}</td>
                    <td>{{ $task->comment }}</td>
                    <td id="status{{ $task->id }}">{{ $task->status }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td class="task-buttons">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn mx-2 btn-sm btn-warning">تعديل</a>
                        {{-- <form action="{{ route('tasks.destroy', $task) }}" method="post" class="btn mx-2 btn-sm btn-danger">
                            @csrf
                            @method('DELETE')
                            <button type="submit">حذف</button>
                        </form> --}}
                        <button onclick="deleteTask(this)" name="delete" data-id="{{ $task->id }}" class="btn mx-2 btn-sm btn-danger">حذف</button>
                        <button id="copy-button" class="btn mx-2 btn-sm btn-primary copy-button"
                            onclick="copyToClipboard('{{ $task->name }}')">نسخ</button>
                    </td>
                    <td>
                        <input type="checkbox" id="checkbox" name="status" data-id="{{ $task->id }}" data-status="{{ str_replace(' ', '-', strtolower($task->status)) }}" value="Completed"
                            onclick="changeStatus(this)">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('headerScript')
    <script>

        // ---> Checked Input Box
        window.onload = () => {
            const checkboxes = document.querySelectorAll('#checkbox');
            const completedTasks = document.querySelectorAll('input[type=checkbox]');

            checkboxes.forEach(box => {
                console.log(box.dataset.status);
                if (box.dataset.status == 'completed') {
                    box.checked = true;
                    completedTasks.forEach(task => {
                        if (task.dataset.id == box.dataset.id) {
                            task.checked = true;
                        }
                    })
                }
            });
        }

        // ---> Chang Status of Task
        function changeStatus(checkbox) {
            const id = checkbox.dataset.id;
            const status = checkbox.checked ? "Completed" : "In Progress";

            if (status === 'Completed') {
                console.log(`lskdj ${id}`);
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }

            axios.post(`/tasks/${id}/update-status`, {
                status,
            }).then((response) => {
                document.getElementById(`status${id}`).textContent = status;
                const task = document.getElementById(`task${id}`);
                task.classList.remove(task.className);
                const newClassStatus = status.replace(/\s/g, '-');
                
                task.classList.add(`${newClassStatus.toLowerCase()}`);

                const tasks = document.querySelectorAll('#task');

                tasks.forEach(task => {
                    task.classList.remove('in-progress', 'completed');
                    task.classList.add(status);
                    console.log(task)
                });
            });
        }

        // ---> Delete Task
        function deleteTask(task) {
            const taskId = task.dataset.id;

            axios.post(`/tasks/${taskId}/delete-task`)
                .then(function (response) {
                    if (response.status === 200) {
                        message('تم حذف المهمة بنجاح');
                        // Remove the deleted task from the DOM
                        const taskElement = document.querySelector(`[data-id="${taskId}"]`);
                        taskElement.parentNode.removeChild(taskElement);
                    } else {
                        console.error('Error deleting task:', response.data);
                    }
                })
                .catch(function (error) {
                    console.error('Error deleting task:', error);
            });
        }

    </script>
@endsection

