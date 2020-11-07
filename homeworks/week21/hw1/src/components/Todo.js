import React from 'react';

const Todo = ({ id, content, isCompleted, handleCheckboxChange, handleClearTodo, handleEditTodo }) => {
  const todoIsCompleted = (isCompleted) => isCompleted ? 'todo-is-completed' : 'todo-is-uncompleted';
  const inputIsCompleted = (isCompleted) => isCompleted ? 'todo__input-completed' : '';
  
  return (
    <div className={`todo input-group mb-1 ${todoIsCompleted(isCompleted)}`}>
      <div className="input-group-prepend">
        <div className="input-group-text">
          <input 
            type="checkbox" 
            aria-label="Checkbox for following text input" 
            checked={isCompleted}
            onChange={handleCheckboxChange}
            value={id}
          />
        </div>
      </div>
      <input 
        type="text" 
        className={`todo__input form-control ${inputIsCompleted(isCompleted)}`} 
        aria-label="Text input with checkbox" 
        value={content}
        id={id}
        onChange={handleEditTodo}
      />

      <button 
        value={id}
        type="button" 
        className="clear-btn btn btn-outline-danger" 
        onClick={handleClearTodo}
      >
        Clear
      </button>
    </div>
  );
}

export default Todo;