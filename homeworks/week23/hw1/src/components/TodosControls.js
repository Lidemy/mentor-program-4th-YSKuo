import React, { memo } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { selectTodos, selectFilter } from '../redux/selectors';
import { deleteCompletedTodos, changeAllTodosStatus, pickFilter } from '../redux/actions';
import { DropdownButton, Dropdown } from 'react-bootstrap';
import classNames from 'classnames';

const MemoFilterRadio = memo(({ filter }) => {
  const dispatch = useDispatch();
  const filterState = useSelector(selectFilter);

  return (
    <label className={classNames('btn btn-secondary', {active: filterState === filter})}>
      <input type="radio" name="filter" value={filter} 
        checked={filterState === filter}
        onChange={(e) => dispatch(pickFilter(e.target.value))} 
      />
      {filter.toUpperCase()}
    </label>
  );
});

const TodosControls = () => {
  const todos = useSelector(selectTodos);
  const dispatch = useDispatch();
  const completeAllToggleText = todos.every((todo) => todo.isCompleted) ? 'Uncomplete all' : 'Complete all';

  return (
    <div className="row todos__controls justify-content-between">
      <div className="btn-group btn-group-toggle mt-2" >
        <MemoFilterRadio filter='all' />
        <MemoFilterRadio filter='active' />
        <MemoFilterRadio filter='completed' />
      </div>

      <DropdownButton className="dropdown mt-2" id="dropdown-basic-button" title="ACTIONS">
        <Dropdown.Item onClick={(e) => dispatch(changeAllTodosStatus())}>
          {completeAllToggleText}
        </Dropdown.Item>
        <Dropdown.Item onClick={(e) => dispatch(deleteCompletedTodos())}>
          Clear completed
        </Dropdown.Item>
      </DropdownButton>
    </div>
  );
};

export default TodosControls;