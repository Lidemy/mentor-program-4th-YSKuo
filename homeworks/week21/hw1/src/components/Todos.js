import React from 'react';
import Todo from './Todo';

const Todos = ({ filter, localTodos, handleCheckboxChange, handleClearTodo, handleEditTodo }) => {

  return (
    <section className="todos mt-4">
    { 
      localTodos
        .filter(todo => {
          if (filter === 'active') {
            return !todo.isCompleted;
          } else if (filter === 'completed') {
            return todo.isCompleted;
          } else { return true }
        })
        .map(todo => (
          <Todo
            id={todo.id}
            key={todo.id}
            content={todo.content}
            isCompleted={todo.isCompleted}
            handleCheckboxChange={handleCheckboxChange}
            handleClearTodo={handleClearTodo}
            handleEditTodo={handleEditTodo}
          />
          )
        )
    }
    </section>
  )
};

export default Todos;
