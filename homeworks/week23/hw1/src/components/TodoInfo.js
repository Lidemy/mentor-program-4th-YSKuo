import React, { memo } from 'react';
import Progress from './Progress';
import TodosControls from './TodosControls';
import Todos from './Todos';

const MemoTodosInfo = memo(() => {
  return (
    <div className="container">
      <Progress />
      <TodosControls />
      <Todos />
    </div>
  );
});

export default MemoTodosInfo;