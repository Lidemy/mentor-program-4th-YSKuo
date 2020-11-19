import styled from "styled-components";
import Row from './Row';

const Board = styled.div`
  display: inline-block;
  background: #827D83;
  background-image: 
    linear-gradient(90deg, rgba(235, 235, 235, 1) 10%, rgba(0, 0, 0, 0) 10%),
    linear-gradient(rgba(235, 235, 235, 1) 10%, rgba(0, 0, 0, 0) 10%)
    ;
  background-size: 40px 40px;
  background-position: 18px 18px;
  width: 760px;
  height: 760px;
`;

export default ({board, showStep, handleClickSquare}) => (
  <Board>
    {
      board
        .map((item, row) => {
          return (
            <Row
              key={row}
              board={board}
              row={row}
              item={item}
              showStep={showStep}
              handleClickSquare={handleClickSquare}
            />
          )
        })
    }
  </Board>
);
