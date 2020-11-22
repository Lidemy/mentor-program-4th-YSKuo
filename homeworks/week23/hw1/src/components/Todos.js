import React from 'react';
import { useSelector } from 'react-redux';
import { selectTodos, selectFilter } from '../redux/selectors';

import Todo from './Todo';

const Todos = () => {
  const todos = useSelector(selectTodos);
  const filter = useSelector(selectFilter);
  
  return (
    <section className="todos mt-4">
    {
      todos
        .filter(todo => {
          if (filter === 'all') return true
          return filter === 'completed' ? todo.isCompleted : !todo.isCompleted
        })
        .map(todo => (
          <Todo
            key={todo.id}
            todo={todo}
          />
          )
        )
    }
    </section>
  )
};

export default Todos;
