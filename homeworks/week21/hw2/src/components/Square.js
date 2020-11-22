import styled from "styled-components";

const Square = styled.button`
  background: none;
  border: none;
  font-size: 15px;
  font-weight: bold;
  line-height: 20px;
  height: 40px;
  padding: 0;
  text-align: center;
  width: 40px;

  &:focus {
    outline: none;
  }
`;

const BlackStone = styled.span`
  text-align: center;
  line-height: 30px;
  color: white;
  height: 30px;
  width: 30px;
  background-color: black;
  border-radius: 50%;
  display: inline-block;
`;

const WhiteStone = styled.span`
  text-align: center;
  line-height: 30px;
  color: black;
  height: 30px;
  width: 30px;
  background-color: white;
  border-radius: 50%;
  display: inline-block;
`;

export default ({ board, row, column, showStep, handleClickSquare }) => (
  <Square
    key={column}
    onClick={() => handleClickSquare(row, column)}
  >
    {
      board[row][column]["value"] && 
      (board[row][column]["value"] === 'Black' ? 
        <BlackStone>{showStep ? board[row][column]["stepRecord"] : ''}</BlackStone> : 
        <WhiteStone>{showStep ? board[row][column]["stepRecord"] : ''}</WhiteStone>)
    }
  </Square>
);
