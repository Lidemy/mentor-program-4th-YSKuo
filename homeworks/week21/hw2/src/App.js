import styled from "styled-components";
import React, { useState } from "react";
import calculateWinner from "./functions/calculateWinner";
import Board from "./components/Board";

const Wrapper = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;
`;

const ShowStepToggle = styled.button`
  margin: 1em 0;
`;

const GameInfo = styled.div`
  display: flex;
`;

const GameStatus = styled.div`
  width: 300px;
  margin-left: 20px;
`;

const App = () => {
  const [history, setHistory] = useState([
    Array(19).fill(Array(19).fill({ value: "", step: null })),
  ]);
  const [stepNumber, setStepNumber] = useState(0);
  const [bIsNext, setBIsNext] = useState(true);
  const [showStep, setShowStep] = useState(false);

  const currentBoard = history[stepNumber];
  const winner = calculateWinner(currentBoard);

  let status;
  if (winner) {
    status = "Winner: " + winner;
  } else {
    status = `Next player: ${bIsNext ? "Black" : "White"}`;
  }

  const moves = history.map((step, move) => {
    const desc = move ? `Go to move #${move}` : "Go to game start";
    return (
      <li key={move}>
        <button onClick={() => jumpTo(move)}>{desc}</button>
      </li>
    );
  });

  const jumpTo = (step) => {
    setStepNumber(step);
    setBIsNext(step % 2 === 0);
  };

  const handleClickSquare = (row, column) => {
    const newHistory = history.slice(0, stepNumber + 1);
    const currentBoard = newHistory[newHistory.length - 1];
    const newBoard = JSON.parse(JSON.stringify(currentBoard));
    if (calculateWinner(newBoard) || newBoard[row][column]["value"]) {
      return;
    }
    newBoard[row][column] = {
      value: bIsNext ? "Black" : "White",
      stepRecord: stepNumber + 1,
    };
    setHistory([...newHistory, newBoard]);
    setStepNumber(stepNumber + 1);
    setBIsNext(!bIsNext);
  };

  const handleShowStepToggle = () => {
    setShowStep(!showStep);
  };

  return (
    <Wrapper>
      <h1>五子棋</h1>
      <GameInfo>
        <Board
          board={currentBoard}
          showStep={showStep}
          handleClickSquare={handleClickSquare}
        />
        <GameStatus>
          <p>{status}</p>
          <ShowStepToggle onClick={handleShowStepToggle}>
            {showStep ? "Hide Step" : "Show Step"}
          </ShowStepToggle>
          <ol>{moves}</ol>
        </GameStatus>
      </GameInfo>
    </Wrapper>
  );
};

export default App;
