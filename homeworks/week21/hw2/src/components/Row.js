import styled from "styled-components";
import Square from './Square';

const Row = styled.div`
  display: flex;
`;

export default ({ item, board, row, showStep, handleClickSquare }) => (
  <Row>
    {
      item.map((cell, column) => {
        return (
          <Square
            board={board}
            row={row}
            column={column}
            key={column}
            showStep={showStep}
            handleClickSquare={handleClickSquare}
          />
        )
      })  
    }
  </Row>  
);
