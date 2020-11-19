import React from 'react';

const TodoInput = ({ content, handleAddTodo, handleInputOnChange }) => (
  <div className="container todo-input-form mt-4 mb-4">
    <form className="form-row" onSubmit={handleAddTodo}>
      <div className="input-group">
        <input 
          type="text" name="content" className="form-control" 
          value={content}
          onChange={handleInputOnChange}
          placeholder="What needs to be done?" 
        />
        <button className="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
);

export default TodoInput;