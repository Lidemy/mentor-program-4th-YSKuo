import React from 'react';
import classNames from 'classnames';

const Todo = ({ id, content, isCompleted, handleCheckboxChange, handleClearTodo, handleEditTodo }) => {
  const inputIsCompleted = classNames('todo__input form-control', {'todo__input-completed': isCompleted});

  return (
    <div className="todo input-group mb-1">
      <div className="input-group-prepend">
        <div className="input-group-text">
          <input 
            type="checkbox" 
            checked={isCompleted}
            onChange={() => handleCheckboxChange(id)}
          />
        </div>
      </div>
      <input 
        type="text" 
        className={inputIsCompleted} 
        value={content}
        id={id}
        onChange={handleEditTodo}
      />

      <button 
        type="button" 
        className="clear-btn btn btn-outline-danger" 
        onClick={() => handleClearTodo(id)}
      >
        Clear
      </button>
    </div>
  );
}

export default Todo;