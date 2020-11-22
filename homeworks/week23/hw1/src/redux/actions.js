import { 
  GET_TODOS_FROM_LOCALSTORAGE,
  ADD_TODO, 
  DELETE_TODO, 
  EDIT_TODO, 
  DELETE_COMPLETED_TODOS, 
  CLICK_CHECKBOX, 
  CHANGE_ALL_TODOS_STATUS, 
  PICK_FILTER } from './actionTypes';

export function getTodosFromLocalStorage(todos) {
  return {
    type: GET_TODOS_FROM_LOCALSTORAGE,
    payload: {
      todos
    }
  }
};

export function addTodo(content) {
  return {
    type: ADD_TODO,
    payload: {
      content
    }
  }
};

export function deleteTodo(id) {
  return {
    type: DELETE_TODO,
    payload: {
      id
    }
  }
};

export function editTodo(id, content) {
  return {
    type: EDIT_TODO,
    payload: {
      id,
      content
    }
  }
};

export function deleteCompletedTodos() {
  return {
    type: DELETE_COMPLETED_TODOS
  }
};

export function clickCheckbox(id) {
  return {
    type: CLICK_CHECKBOX,
    payload: {
      id
    }
  }
};

export function changeAllTodosStatus() {
  return {
    type: CHANGE_ALL_TODOS_STATUS
  }
};

export function pickFilter(filter) {
  return {
    type: PICK_FILTER,
    payload: {
      filter
    }
  }
};
