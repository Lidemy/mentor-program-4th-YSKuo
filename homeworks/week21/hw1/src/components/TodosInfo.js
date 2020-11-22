import React from 'react';
import Progress from './Progress';
import TodosControls from './TodosControls';
import Todos from './Todos';

const TodosInfo = ({ localTodos, filter, handleCheckboxChange, handleClearCompletedTodos, handleClearTodo, handdlePickFilter, handleCompleteAllToggle, handleEditTodo }) => (
  <div className="container">
    <Progress 
      localTodos={localTodos}
    />
    <TodosControls 
      localTodos={localTodos}
      filter={filter}
      handdlePickFilter={handdlePickFilter}
      handleClearCompletedTodos={handleClearCompletedTodos}
      handleCompleteAllToggle={handleCompleteAllToggle}
    />
    <Todos 
      localTodos={localTodos}
      filter={filter}
      handleCheckboxChange={handleCheckboxChange}
      handleClearTodo={handleClearTodo}
      handleEditTodo={handleEditTodo}
    />
  </div>
)

export default TodosInfo;