import React from 'react';
import classNames from 'classnames';
import { DropdownButton, Dropdown } from 'react-bootstrap';

const TodosControls = ({ localTodos, filter, handdlePickFilter, handleClearCompletedTodos, handleCompleteAllToggle }) => {
  const completeAllToggleText = localTodos.every((todo) => todo.isCompleted) ? 'Uncomplete all' : 'Complete all';
  return (
    <div className="row todos__controls justify-content-between">
      <div className="btn-group btn-group-toggle mt-2" >
        <label className={classNames('btn btn-secondary', {active: filter === 'all'})}>
          <input type="radio" name="filter" value="all" 
            checked={filter === 'all'} 
            onChange={handdlePickFilter} 
          />
          All
        </label>
        <label className={classNames('btn btn-secondary', {active: filter === 'active'})}>
          <input type="radio" name="filter" value="active" 
            checked={filter === 'active'} 
            onChange={handdlePickFilter} 
          />
          Active
        </label>
        <label className={classNames('btn btn-secondary', {active: filter === 'completed'})}>
          <input type="radio" name="filter" value="completed" 
            checked={filter === 'completed'} 
            onChange={handdlePickFilter}   
          />
          Completed
        </label>
      </div>

      <DropdownButton className="dropdown mt-2" id="dropdown-basic-button" title="Actions">
        <Dropdown.Item onClick={handleCompleteAllToggle}>
          {completeAllToggleText}
        </Dropdown.Item>
        <Dropdown.Item onClick={handleClearCompletedTodos}>
          Clear completed
        </Dropdown.Item>
      </DropdownButton>
    </div>
  );
}
export default TodosControls;