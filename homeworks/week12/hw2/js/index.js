// escape 把那些會被瀏覽器判別為標籤的字處理成純字串

/* eslint no-undef: 0 */
/* eslint no-shadow: 0 */

/* eslint-disable */
  function escape(toOutput){
    return toOutput.replace(/\&/g, '&amp;')
        .replace(/\</g, '&lt;')
        .replace(/\>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/\'/g, '&#x27')
        .replace(/\//g, '&#x2F');
  }

/* eslint-enable */
let listId;

function appendTodoToDOM(container, todo) {
  const todoIsCompleted = todo.is_completed ? 'todo-is-completed' : 'todo-is-uncompleted';
  const inputIsCompleted = todo.is_completed ? 'todo__input-completed' : '';
  const isChecked = todo.is_completed ? 'checked' : '';
  const todoId = todo.todo_id ? todo.todo_id : '';
  const html = `
    <div class="todo input-group mb-1 ${todoIsCompleted}">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <input type="checkbox" aria-label="Checkbox for following text input" ${isChecked}>
        </div>
      </div>
      <input type="text" class="todo__input form-control ${inputIsCompleted}" aria-label="Text input with checkbox" value="${escape(todo.content)}">
      <input type="hidden" name="todo_id" value="${todoId}">
      <button type="button" class="clear-btn btn btn-outline-danger">Clear</button>
    </div>
  `;
  container.append(html);
}

function refreshStatus() {
  $('.progress').html('');
  $('.rest-items-number').html('');
  const numTodos = $('.todo').length;
  const numDeleted = $('.todo-is-deleted').length;
  const numCompleted = $('.todo-is-completed').length;
  const numUncomplete = $('.todo-is-uncompleted').length;
  let percent;
  if ((numTodos - numDeleted) === 0) {
    percent = 0;
  } else {
    percent = Math.round(numCompleted / (numTodos - numDeleted) * 10000) / 100;
  }
  const progressBar = `
    <div class="progress-bar" role="progressbar" style="width: ${percent}%;" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100">${percent}%</div>
  `;
  $('.progress').append(progressBar);
  $('.rest-items-number').html(numUncomplete);
  // change clear-all-toggle
  if (numCompleted > 0 && numUncomplete === 0) {
    $('.complete-all-toggle').html('Uncomplete all');
  } else {
    $('.complete-all-toggle').html('Complete all');
  }
}

function getTodosFromListId(listId) {
  $('.todos').html('');
  $.ajax({
    type: 'POST',
    url: 'http://localhost:8080/YSK/be101/board/week12/hw2/api_todos.php',
    data: { listId },
  }).done((data) => {
    let ModalHtml;
    if (!data.ok) {
      console.log(data.msg);
      if (data.errCode === 1) {
        ModalHtml = 'Please input List ID';
      } else if (data.errCode === 2) {
        ModalHtml = 'The list ID does not exist in our database.';
      }
      $('#list-id-modal .modal-body').html(ModalHtml);
      return;
    }
    ModalHtml = 'Your todo list is displayed.';
    $('#list-id-modal .modal-body').html(ModalHtml);

    const { todos } = data;

    if (todos.length) {
      for (const todo of todos) {
        appendTodoToDOM($('.todos'), todo);
        refreshStatus();
      }
    } else {
      console.log('no undeleted todos');
    }
  });
}

function todosDataArray(listId) {
  const todosData = [];

  for (const todo of $('.todo')) {
    const todoData = {};
    todoData.todo_id = $(todo).children('input[name=todo_id]').val();
    todoData.list_id = listId;
    todoData.is_completed = $(todo).children('.todo__input').hasClass('todo__input-completed') ? 1 : 0;
    todoData.is_deleted = $(todo).css('display') === 'none' ? 1 : 0;
    todoData.content = $(todo).children('.todo__input').val();
    todosData.push(todoData);
  }
  return todosData;
}

function addTodosData(todosData) {
  const json = JSON.stringify(todosData);
  $.ajax({
    type: 'POST',
    url: 'http://localhost:8080/YSK/be101/board/week12/hw2/api_edit_todos.php',
    data: { listId, json },
    dataType: 'json',
  }).done((data) => {
    getTodosFromListId(listId);
    let ModalHtml;
    if (!data.ok) {
      console.log(data.msg);
      if (data.errCode === 2) {
        ModalHtml = 'The list ID does not exist in our database.';
      } else {
        ModalHtml = 'Somthing wrong.';
      }
    } else {
      ModalHtml = ` 
        Your data have been saved successfully!<br>
        Please remember your list ID is ${listId}.
      `;
    }
    $('#save-btn-modal .modal-body').html(ModalHtml);
  }).fail((data) => {
    console.log('fail: ');
    console.log(data.responseText);
  });
}

function addListAndTodosToServer() {
  $.ajax({
    type: 'POST',
    url: 'http://localhost:8080/YSK/be101/board/week12/hw2/api_add_list.php',
  }).done((data) => {
    if (!data.ok) {
      console.log(data.msg);
      return;
    }
    listId = data.list_id;
    $('.list-id').val(listId);
    const todosData = todosDataArray(listId);
    addTodosData(todosData);
  });
}

// 1st load

refreshStatus();

// sumbit todo input
$('.todo-input-form').submit((e) => {
  e.preventDefault();
  const newTodo = {};
  newTodo.content = $('input[name=content]').val();
  if (newTodo.content) {
    appendTodoToDOM($('.todos'), newTodo);
    $('input[name=content]').val('');
    refreshStatus();
  }
});

// clicking clear
$('.todos').on('click', '.clear-btn', (e) => {
  e.preventDefault();
  $(e.target).closest('.todo').removeClass('todo-is-completed');
  $(e.target).closest('.todo').removeClass('todo-is-uncompleted');
  $(e.target).closest('.todo').addClass('todo-is-deleted');
  refreshStatus();
});

// clicking checkbox
$('.todos').on('click', 'input[type=checkbox]', (e) => {
  $(e.target).closest('.todo').toggleClass('todo-is-completed');
  $(e.target).closest('.todo').toggleClass('todo-is-uncompleted');

  $(e.target).parents('.input-group-prepend').siblings('.todo__input').toggleClass('todo__input-completed');
  refreshStatus();
});

// clicking "complete all toggle"
$('.todos__controls').on('click', '.complete-all-toggle', () => {
  if ($('.todo').hasClass('todo-is-uncompleted')) {
    $('input[type=checkbox]').prop('checked', true);
    $('.todo-is-uncompleted').addClass('todo-is-completed');
    $('.todo').removeClass('todo-is-uncompleted');
  } else {
    $('input[type=checkbox]').prop('checked', false);
    $('.todo-is-completed').addClass('todo-is-uncompleted');
    $('.todo').removeClass('todo-is-completed');
  }

  $('.todo__input').toggleClass('todo__input-completed');

  refreshStatus();
});

// clicking "clear completed"
$('.todos__controls').on('click', '.clear-completed-btn', () => {
  $('.todo-is-completed').addClass('todo-is-deleted');
  $('.todo-is-deleted').removeClass('todo-is-uncompleted');
  $('.todo-is-deleted').removeClass('todo-is-completed');

  refreshStatus();
});

// clicking "all"
$('.todos__controls').on('click', '.filter-all', () => {
  $('.todo-is-uncompleted').show();
  $('.todo-is-completed').show();
  $('.todo-is-deleted').hide();
  refreshStatus();
});

// clicking "active"
$('.todos__controls').on('click', '.filter-active', () => {
  $('.todo-is-uncompleted').show();
  $('.todo-is-completed').hide();
  $('.todo-is-deleted').hide();
  refreshStatus();
});

// clicking "completed"
$('.todos__controls').on('click', '.filter-completed', () => {
  $('.todo-is-uncompleted').hide();
  $('.todo-is-completed').show();
  $('.todo-is-deleted').hide();
  refreshStatus();
});

// submit List ID
$('.list-id-btn').click((e) => {
  e.preventDefault();
  listId = $('.list-id').val();
  getTodosFromListId(listId);
  refreshStatus();
});

// clicking save-btn
$('.save-btn').click((e) => {
  e.preventDefault();
  if (!listId) {
    addListAndTodosToServer();
  } else {
    const todosData = todosDataArray(listId);
    addTodosData(todosData);
  }
});
