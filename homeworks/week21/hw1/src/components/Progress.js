import React from 'react';

const Progress = ({ localTodos }) => {
  const numTodos = localTodos.length;
  const numCompleted = localTodos.filter(todo => todo.isCompleted).length;
  const numUncomplete = localTodos.filter(todo => !todo.isCompleted).length;
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
        <div 
          className="progress-bar" 

          style={{width: percent +'%'}} 
          aria-valuenow={percent} 
          aria-valuemin="0" 
          aria-valuemax="100"
        >
          {percent}%
        </div>
      </div>
      <p>
        <span className="rest-items-number">
          {numUncomplete}
        </span> item(s) left
      </p>
    </div>
  );
}

export default Progress;