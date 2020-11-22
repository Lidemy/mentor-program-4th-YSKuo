import React, { useState, memo } from 'react';
import { useDispatch } from 'react-redux';
import { addTodo } from '../redux/actions';

const MemoButton = memo(({ className, children }) =>{
  return (
    <button className={className}>{children}</button>
  )
});

const TodoInput = () => {
  const [content, setContent] = useState('');
  const dispatch = useDispatch();
  const handleSubmit = (e) => {
    e.preventDefault();
    dispatch(addTodo(content));
    setContent('');
  };

  return (
    <div className="container todo-input-form mt-4 mb-4">
      <form className="form-row" onSubmit={handleSubmit}>
        <div className="input-group">
          <input
            type="text" name="content" className="form-control" 
            value={content}
            onChange={e => setContent(e.target.value)}
            placeholder="What needs to be done?" 
          />
          <MemoButton className="btn btn-primary">Submit</MemoButton>
        </div>
      </form>
    </div>
  );
}

export default TodoInput;