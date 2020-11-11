import React from 'react';
import Todo from './Todo';

const Todos = ({ filter, localTodos, handleCheckboxChange, handleClearTodo, handleEditTodo }) => {
  return (
    <section className="todos mt-4">
    { 
      localTodos
        .filter(todo => {
          if (filter === 'all') return true
          return filter === 'completed' ? todo.isCompleted : !todo.isCompleted
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
