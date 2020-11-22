import React, { memo } from 'react';
import { useSelector } from 'react-redux';
import { selectTodos } from '../redux/selectors';

const MemoProgressBar = memo(({ percent }) => {
  return (
    <div
      className="progress-bar"
      style={{width: percent +'%'}}
      aria-valuemin="0"
      aria-valuemax="100"
    >
      {percent}%
    </div>
  );
});

const MemoUncompletedNumber = memo(({ numUncomplete }) => {
  return (
    <p>
      <span>
        {numUncomplete}
      </span> item(s) left
    </p>
  );
});

const Progress = () => {
  const todos = useSelector(selectTodos);

  // 進度顯示項目的計算
  const numTodos = todos.length;
  const numCompleted = todos.filter(todo => todo.isCompleted).length;
  const numUncomplete = todos.filter(todo => !todo.isCompleted).length;
  let percent;
  if (numTodos === 0) {
    percent = 0;
  } else {
    percent = Math.round(numCompleted / numTodos * 10000) / 100;
  }
  
  return (
    <div>
      <h5>Your Progress</h5>
      <div className="progress">
        <MemoProgressBar percent={percent} />
      </div>
      <MemoUncompletedNumber numUncomplete={numUncomplete} />
    </div>
  );
};

export default Progress;