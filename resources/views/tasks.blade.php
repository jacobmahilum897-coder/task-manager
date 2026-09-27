<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-center">Task Manager</h1>

        <div class="mb-4 flex gap-2">
            <input type="text" id="taskTitle" placeholder="Add a new task..." class="flex-1 border p-2 rounded border-gray-300">
            <button onclick="addTask()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
        </div>

        <ul id="taskList" class="divide-y divide-gray-200"></ul>
    </div>

    <script>
        async function fetchTasks() {
            try {
                const response = await fetch('/api/tasks');
                const tasks = await response.json();
                const list = document.getElementById('taskList');
                list.innerHTML = '';

                tasks.forEach(task => {
                    const li = document.createElement('li');
                    li.className = 'py-2 flex justify-between items-center';
                    li.innerHTML = `
                        <span>${task.title}</span>
                        <button onclick="deleteTask(${task.id})" class="text-red-500 hover:text-red-700">Delete</button>
                    `;
                    list.appendChild(li);
                });
            } catch (error) {
                console.error('Error fetching tasks:', error);
            }
        }
async function addTask() {
    try {
        const titleInput = document.getElementById('taskTitle');

        await fetch('/api/tasks', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                title: titleInput.value
            })
        });

        titleInput.value = '';
        fetchTasks();

    } catch (error) {
        console.error('Error adding task:', error);
    }
} 
       

       async function deleteTask(id) {
    try {
      const response = await fetch(`/api/tasks/${id}`, {

            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Delete failed:', response.status);
            return;
        }

        fetchTasks();

    } catch (error) {
        console.error('Error deleting task:', error);
    }
}

fetchTasks();
    </script>
</body>
</html>