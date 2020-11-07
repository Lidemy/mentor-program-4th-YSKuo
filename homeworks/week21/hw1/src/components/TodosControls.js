import React from 'react';
import { DropdownButton, Dropdown } from 'react-bootstrap';

const TodosControls = ({ localTodos, filter, handdlePickFilter, handleClearCompletedTodos, handleCompleteAllToggle }) => {
  const CompleteAllToggleText = localTodos.length === localTodos.filter(todo => todo.isCompleted).length ? 'Uncomplete all' : 'Complete all';
  return (
    <div className="row todos__controls justify-content-between">
      <div className="btn-group btn-group-toggle mt-2" >
        <label className={`btn btn-secondary ${filter === 'all' ? 'active' : '' }`}>
          <input type="radio" name="filter" value="all" 
            checked={filter === 'all'} 
            onChange={handdlePickFilter} 
          />
          All
        </label>
        <label className={`btn btn-secondary ${filter === 'active' ? 'active' : '' }`}>
          <input type="radio" name="filter" value="active" 
            checked={filter === 'active'} 
            onChange={handdlePickFilter} 
          />
          Active
        </label>
        <label className={`btn btn-secondary ${filter === 'completed' ? 'active' : '' }`}>
          <input type="radio" name="filter" value="completed" 
            checked={filter === 'completed'} 
            onChange={handdlePickFilter}   
          />
          Completed
        </label>
      </div>

      <DropdownButton className="dropdown mt-2" id="dropdown-basic-button" title="Actions">
        <Dropdown.Item onClick={handleCompleteAllToggle}>
          {CompleteAllToggleText}
        </Dropdown.Item>
        <Dropdown.Item onClick={handleClearCompletedTodos}>
          Clear completed
        </Dropdown.Item>
      </DropdownButton>
    </div>
  );
}
export default TodosControls;